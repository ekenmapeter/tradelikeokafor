<?php

namespace App\Services;

use App\Models\ForexRawArticle;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ForexRssFetcherService
{
    protected array $feeds;
    protected array $keywords;

    public function __construct()
    {
        $this->feeds = config('forex.rss_feeds', []);
        $this->keywords = config('forex.relevance_keywords', []);
    }

    /**
     * Fetch articles from all configured RSS feeds.
     */
    public function fetchAll(): array
    {
        $stats = ['fetched' => 0, 'duplicates' => 0, 'errors' => 0];

        foreach ($this->feeds as $feed) {
            try {
                $result = $this->fetchFeed($feed['name'], $feed['url']);
                $stats['fetched'] += $result['fetched'];
                $stats['duplicates'] += $result['duplicates'];
            } catch (\Exception $e) {
                $stats['errors']++;
                Log::error("Forex RSS: Failed to fetch {$feed['name']}", [
                    'url' => $feed['url'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        Log::info('Forex RSS Fetch Complete', $stats);
        return $stats;
    }

    /**
     * Fetch articles from a single RSS feed.
     */
    public function fetchFeed(string $sourceName, string $feedUrl): array
    {
        $stats = ['fetched' => 0, 'duplicates' => 0];

        $response = Http::timeout(30)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36',
                'Accept' => 'application/rss+xml, application/xml, text/xml',
            ])
            ->get($feedUrl);

        if (!$response->successful()) {
            throw new \Exception("HTTP {$response->status()} from {$feedUrl}");
        }

        $xml = $this->parseXml($response->body());
        if (!$xml) {
            throw new \Exception("Failed to parse XML from {$feedUrl}");
        }

        $items = $this->extractItems($xml);

        foreach ($items as $item) {
            $contentHash = hash('sha256', $item['title'] . $item['content']);

            // Skip duplicates
            if (ForexRawArticle::where('content_hash', $contentHash)->exists()) {
                $stats['duplicates']++;
                continue;
            }

            // Also skip if same URL already exists
            if (ForexRawArticle::where('source_url', $item['link'])->exists()) {
                $stats['duplicates']++;
                continue;
            }

            $relevanceScore = $this->calculateRelevanceScore($item['title'] . ' ' . $item['content']);

            ForexRawArticle::create([
                'source_name' => $sourceName,
                'source_feed_url' => $feedUrl,
                'source_url' => $item['link'],
                'raw_title' => mb_substr($item['title'], 0, 255),
                'raw_content' => $item['content'],
                'raw_excerpt' => mb_substr(strip_tags($item['content']), 0, 500),
                'content_hash' => $contentHash,
                'published_at' => $item['published_at'],
                'fetched_at' => now(),
                'status' => 'pending',
                'relevance_score' => $relevanceScore,
            ]);

            $stats['fetched']++;
        }

        return $stats;
    }

    /**
     * Parse XML string, handling different encoding and format issues.
     */
    protected function parseXml(string $body): ?\SimpleXMLElement
    {
        // Suppress XML errors and handle them manually
        libxml_use_internal_errors(true);

        // Try direct parse first
        $xml = simplexml_load_string($body);

        if ($xml === false) {
            // Try removing BOM and invalid characters
            $body = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $body);
            $body = ltrim($body, "\xEF\xBB\xBF"); // Remove BOM
            $xml = simplexml_load_string($body);
        }

        libxml_clear_errors();
        return $xml ?: null;
    }

    /**
     * Extract items from RSS/Atom feed XML.
     */
    protected function extractItems(\SimpleXMLElement $xml): array
    {
        $items = [];

        // Standard RSS 2.0
        if (isset($xml->channel->item)) {
            foreach ($xml->channel->item as $item) {
                $items[] = $this->parseRssItem($item);
            }
        }
        // Atom feed
        elseif (isset($xml->entry)) {
            foreach ($xml->entry as $entry) {
                $items[] = $this->parseAtomEntry($entry);
            }
        }
        // RSS 1.0 (RDF)
        elseif (isset($xml->item)) {
            foreach ($xml->item as $item) {
                $items[] = $this->parseRssItem($item);
            }
        }

        return $items;
    }

    /**
     * Parse a standard RSS item.
     */
    protected function parseRssItem(\SimpleXMLElement $item): array
    {
        $namespaces = $item->getNamespaces(true);

        // Get content from content:encoded or description
        $content = '';
        if (isset($namespaces['content'])) {
            $contentNs = $item->children($namespaces['content']);
            if (isset($contentNs->encoded)) {
                $content = (string) $contentNs->encoded;
            }
        }
        if (empty($content)) {
            $content = (string) ($item->description ?? '');
        }

        // Clean HTML from content
        $content = $this->cleanContent($content);

        // Parse publish date
        $pubDate = null;
        if (!empty((string) $item->pubDate)) {
            try {
                $pubDate = Carbon::parse((string) $item->pubDate);
            } catch (\Exception $e) {
                $pubDate = now();
            }
        }

        return [
            'title' => trim((string) $item->title),
            'link' => trim((string) $item->link),
            'content' => $content,
            'published_at' => $pubDate,
        ];
    }

    /**
     * Parse an Atom feed entry.
     */
    protected function parseAtomEntry(\SimpleXMLElement $entry): array
    {
        $link = '';
        if (isset($entry->link)) {
            foreach ($entry->link as $linkEl) {
                $attrs = $linkEl->attributes();
                if ((string) ($attrs['rel'] ?? '') === 'alternate' || empty($link)) {
                    $link = (string) ($attrs['href'] ?? '');
                }
            }
        }

        $content = (string) ($entry->content ?? $entry->summary ?? '');
        $content = $this->cleanContent($content);

        $pubDate = null;
        $dateStr = (string) ($entry->published ?? $entry->updated ?? '');
        if (!empty($dateStr)) {
            try {
                $pubDate = Carbon::parse($dateStr);
            } catch (\Exception $e) {
                $pubDate = now();
            }
        }

        return [
            'title' => trim((string) $entry->title),
            'link' => trim($link),
            'content' => $content,
            'published_at' => $pubDate,
        ];
    }

    /**
     * Clean HTML content — strip tags but preserve meaningful text.
     */
    protected function cleanContent(string $html): string
    {
        // Decode HTML entities
        $text = html_entity_decode($html, ENT_QUOTES, 'UTF-8');

        // Replace block elements with newlines before stripping
        $text = preg_replace('/<(br|p|div|li|h[1-6])[^>]*>/i', "\n", $text);

        // Strip remaining HTML tags
        $text = strip_tags($text);

        // Normalize whitespace
        $text = preg_replace('/[ \t]+/', ' ', $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);

        return trim($text);
    }

    /**
     * Calculate relevance score based on keyword matches.
     */
    protected function calculateRelevanceScore(string $text): int
    {
        $score = 0;
        $textLower = strtolower($text);

        foreach ($this->keywords as $keyword) {
            $keywordLower = strtolower($keyword);
            $count = substr_count($textLower, $keywordLower);

            if ($count > 0) {
                // Weighted scoring: currency pairs worth more
                $weight = strlen($keyword) > 5 ? 3 : 2;
                $score += $count * $weight;
            }
        }

        // Bonus for recency-indicating words
        $urgencyWords = ['breaking', 'just in', 'alert', 'update', 'live', 'now'];
        foreach ($urgencyWords as $word) {
            if (str_contains($textLower, $word)) {
                $score += 5;
            }
        }

        return min($score, 100); // Cap at 100
    }

    /**
     * Fetch from a specific source only.
     */
    public function fetchSource(string $sourceName): array
    {
        foreach ($this->feeds as $feed) {
            if (strtolower($feed['name']) === strtolower($sourceName)) {
                return $this->fetchFeed($feed['name'], $feed['url']);
            }
        }

        throw new \Exception("Unknown source: {$sourceName}");
    }
}
