<?php

namespace App\Services;

use App\Models\ForexBlogDraft;
use App\Models\ForexRawArticle;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqRewriterService
{
    protected string $apiKey;
    protected string $model;
    protected array $ctaMapping;

    public function __construct()
    {
        $this->apiKey = config('forex.groq_api_key');
        $this->model = config('forex.groq_model');
        $this->ctaMapping = config('forex.cta_mapping', []);
    }

    /**
     * Rewrite a raw article into a professional forex blog draft.
     */
    public function rewrite(ForexRawArticle $article): ?ForexBlogDraft
    {
        $prompt = $this->buildPrompt($article);
        $cta = $this->determineCta($article->raw_title . ' ' . $article->raw_content);

        $response = $this->callApi($prompt);
        if (!$response) {
            Log::error('Groq: API request failed', ['article_id' => $article->id]);
            return null;
        }

        $parsed = $this->parseResponse($response['content'] ?? '');
        if (!$parsed) {
            Log::error('Groq: Failed to parse response', ['article_id' => $article->id, 'raw' => $response['content'] ?? '']);
            return null;
        }

        $draft = ForexBlogDraft::create([
            'raw_article_id' => $article->id,
            'ai_title' => mb_substr($parsed['title'], 0, 255),
            'ai_content' => $parsed['content'],
            'ai_excerpt' => mb_substr($parsed['excerpt'] ?? '', 0, 500),
            'ai_tags' => $parsed['tags'] ?? [],
            'ai_meta_description' => mb_substr($parsed['meta_description'] ?? '', 0, 255),
            'lead_cta' => $cta,
            'status' => 'draft',
            'generation_model' => $response['model'] ?? $this->model,
            'generation_tokens' => $response['tokens'] ?? null,
        ]);

        $article->update(['status' => 'used']);
        return $draft;
    }

    /**
     * Regenerate a draft with fresh AI content.
     */
    public function regenerate(ForexBlogDraft $draft): ?ForexBlogDraft
    {
        $article = $draft->rawArticle;
        if (!$article) {
            return null;
        }
        $prompt = $this->buildPrompt($article, true);
        $cta = $this->determineCta($article->raw_title . ' ' . $article->raw_content);
        $response = $this->callApi($prompt);
        if (!$response) {
            Log::error('Groq: Regeneration API request failed', ['draft_id' => $draft->id]);
            return null;
        }
        $parsed = $this->parseResponse($response['content'] ?? '');
        if (!$parsed) {
            Log::error('Groq: Failed to parse regeneration response', ['draft_id' => $draft->id]);
            return null;
        }
        $draft->update([
            'ai_title' => mb_substr($parsed['title'], 0, 255),
            'ai_content' => $parsed['content'],
            'ai_excerpt' => mb_substr($parsed['excerpt'] ?? '', 0, 500),
            'ai_tags' => $parsed['tags'] ?? [],
            'ai_meta_description' => mb_substr($parsed['meta_description'] ?? '', 0, 255),
            'lead_cta' => $cta,
            'status' => 'draft',
            'generation_model' => $response['model'] ?? $this->model,
            'generation_tokens' => $response['tokens'] ?? null,
            'reviewed_at' => null,
            'moderator_id' => null,
            'reject_reason' => null,
        ]);
        return $draft->fresh();
    }

    protected function buildPrompt(ForexRawArticle $article, bool $isRegeneration = false): string
    {
        $regenerationNote = $isRegeneration
            ? "\nIMPORTANT: This is a regeneration request. Write a completely different angle and perspective from any previous version."
            : '';
        return "[INST] You are a professional forex trading analyst and financial writer writing for tradelikeokafor.com. Write with authority, clarity, and insight. Never copy source text verbatim.{$regenerationNote}\n".
            "INSTRUCTIONS:\n1. Write a compelling SEO headline (max 60 chars).\n2. Write a 600-800 word article with HTML <h3> subheadings and <p> paragraphs covering market context, key data, trader implications, outlook.\n3. End with a natural closing paragraph mentioning tradelikeokafor.com.\n4. Provide a 2-sentence excerpt.\n5. Generate 3-5 SEO tags.\n6. Provide a meta description (max 155 chars).\n\n".
            "OUTPUT FORMAT: Return ONLY a single compact JSON object on one line. Do NOT use literal newlines inside the JSON string values — use \\n for line breaks in the content field instead. No markdown, no code blocks, no extra text before or after the JSON.\n".
            "Example: {\"title\":\"Headline here\",\"content\":\"<h3>Section</h3>\\n<p>Text</p>\",\"excerpt\":\"Two sentence summary.\",\"tags\":[\"tag1\",\"tag2\"],\"meta_description\":\"Short SEO description.\"}\n\n".
            "SOURCE ARTICLE:\nTitle: {$article->raw_title}\nSource: {$article->source_name}\nPublished: {$article->published_at?->format('Y-m-d H:i')}\nContent:\n{$article->raw_content}\n[/INST]";
    }

    protected function callApi(string $prompt, int $maxRetries = 3): ?array
    {
        $url = 'https://api.groq.com/openai/v1/chat/completions';
        $payload = [
            'model' => $this->model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ];
        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])->timeout(120)->post($url, $payload);

                if (!$response->successful()) {
                    Log::warning('Groq API request unsuccessful', ['status' => $response->status(), 'attempt' => $attempt]);
                    if ($attempt < $maxRetries) {
                        sleep(pow(2, $attempt));
                    }
                    continue;
                }

                $data = $response->json();
                $choice = $data['choices'][0] ?? null;
                if ($choice && isset($choice['message']['content'])) {
                    return [
                        'content' => $choice['message']['content'],
                        'model' => $this->model,
                        'tokens' => $data['usage']['total_tokens'] ?? null,
                    ];
                }
                Log::error('Groq: Unexpected response structure', ['response' => $data]);
                return null;
            } catch (\Exception $e) {
                Log::error('Groq API exception', ['message' => $e->getMessage(), 'attempt' => $attempt]);
                if ($attempt < $maxRetries) {
                    sleep(pow(2, $attempt));
                }
            }
        }
        return null;
    }

    protected function parseResponse(string $text): ?array
    {
        $json = $this->extractJson($text);
        if ($json && $this->validateParsedContent($json)) {
            return $json;
        }
        return $this->regexFallbackParse($text);
    }

    protected function extractJson(string $text): ?array
    {
        // 1. Strip markdown code fences if present
        $text = preg_replace('/```(?:json)?\s*/i', '', $text);
        $text = preg_replace('/```/', '', $text);

        // 2. Direct parse attempt
        $decoded = json_decode($text, true);
        if ($decoded && isset($decoded['title']) && isset($decoded['content'])) {
            return $decoded;
        }

        // 3. Extract the JSON block by walking brace depth (handles multiline)
        $start = strpos($text, '{');
        if ($start !== false) {
            $depth   = 0;
            $inStr   = false;
            $escaped = false;
            $end     = null;

            for ($i = $start, $len = strlen($text); $i < $len; $i++) {
                $ch = $text[$i];
                if ($escaped)         { $escaped = false; continue; }
                if ($ch === '\\' && $inStr) { $escaped = true; continue; }
                if ($ch === '"')      { $inStr = !$inStr; continue; }
                if (!$inStr) {
                    if ($ch === '{') $depth++;
                    if ($ch === '}') { $depth--; if ($depth === 0) { $end = $i; break; } }
                }
            }

            if ($end !== null) {
                $jsonStr = substr($text, $start, $end - $start + 1);

                // 4. Sanitize: replace literal newlines/tabs inside JSON string values
                $sanitized = preg_replace_callback(
                    '/"(?:[^"\\\\]|\\\\.)*"/s',
                    function ($m) {
                        return str_replace(["\n", "\r", "\t"], ['\\n', '\\r', '\\t'], $m[0]);
                    },
                    $jsonStr
                );

                // 5. Fix trailing commas
                $sanitized = preg_replace('/,\s*}/', '}', $sanitized);
                $sanitized = preg_replace('/,\s*]/', ']', $sanitized);

                $decoded = json_decode($sanitized, true);
                if ($decoded && isset($decoded['title']) && isset($decoded['content'])) {
                    return $decoded;
                }
            }
        }

        return null;
    }

    protected function regexFallbackParse(string $text): ?array
    {
        $result = ['title' => '', 'content' => '', 'excerpt' => '', 'tags' => [], 'meta_description' => ''];
        if (preg_match('/(?:title|headline|heading)[\s:]*["\']?([^"\'\n]{10,80})/i', $text, $m)) {
            $result['title'] = trim($m[1]);
        }
        $lines = explode("\n", $text);
        $contentLines = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (strlen($line) > 50) {
                $contentLines[] = "<p>{$line}</p>";
            }
        }
        $result['content'] = implode("\n", $contentLines);
        $result['excerpt'] = mb_substr(strip_tags($result['content']), 0, 300);
        if (strlen($result['title']) > 5 && strlen($result['content']) > 200) {
            return $result;
        }
        return null;
    }

    protected function validateParsedContent(array $parsed): bool
    {
        return !empty($parsed['title']) && strlen($parsed['title']) >= 5 && !empty($parsed['content']) && strlen($parsed['content']) >= 200;
    }

    protected function determineCta(string $text): string
    {
        $textLower = strtolower($text);
        $bestMatch = 'default';
        $bestScore = 0;
        foreach ($this->ctaMapping as $key => $mapping) {
            if ($key === 'default') continue;
            $score = 0;
            foreach ($mapping['keywords'] as $keyword) {
                if (str_contains($textLower, strtolower($keyword))) {
                    $score++;
                }
            }
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $key;
            }
        }
        return $this->ctaMapping[$bestMatch]['cta'] ?? $this->ctaMapping['default']['cta'];
    }
}
?>
