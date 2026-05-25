<?php

namespace App\Services;

use App\Models\ForexBlogDraft;
use App\Models\ForexRawArticle;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HuggingFaceRewriterService
{
    protected string $apiToken;
    protected string $model;
    protected string $fallbackModel;
    protected array $ctaMapping;

    public function __construct()
    {
        $this->apiToken = config('forex.huggingface_api_token');
        $this->model = config('forex.huggingface_model');
        $this->fallbackModel = config('forex.huggingface_fallback_model');
        $this->ctaMapping = config('forex.cta_mapping', []);
    }

    /**
     * Rewrite a raw article into a professional forex blog draft.
     */
    public function rewrite(ForexRawArticle $article): ?ForexBlogDraft
    {
        $prompt = $this->buildPrompt($article);
        $cta = $this->determineCta($article->raw_title . ' ' . $article->raw_content);

        // Try primary model first
        $response = $this->callApi($prompt, $this->model);

        // Fallback to secondary model if primary fails
        if (!$response) {
            Log::warning("HuggingFace: Primary model failed, trying fallback", [
                'primary' => $this->model,
                'fallback' => $this->fallbackModel,
            ]);
            $response = $this->callApi($prompt, $this->fallbackModel);
        }

        if (!$response) {
            Log::error('HuggingFace: Both models failed for article', [
                'article_id' => $article->id,
            ]);
            return null;
        }

        // Parse the AI response
        $parsed = $this->parseResponse($response['text']);

        if (!$parsed) {
            Log::error('HuggingFace: Failed to parse AI response', [
                'article_id' => $article->id,
                'response_snippet' => mb_substr($response['text'], 0, 200),
            ]);
            return null;
        }

        // Create the draft
        $draft = ForexBlogDraft::create([
            'raw_article_id' => $article->id,
            'ai_title' => mb_substr($parsed['title'], 0, 255),
            'ai_content' => $parsed['content'],
            'ai_excerpt' => mb_substr($parsed['excerpt'] ?? '', 0, 500),
            'ai_tags' => $parsed['tags'] ?? [],
            'ai_meta_description' => mb_substr($parsed['meta_description'] ?? '', 0, 255),
            'lead_cta' => $cta,
            'status' => 'draft',
            'generation_model' => $response['model'],
            'generation_tokens' => $response['tokens'] ?? null,
        ]);

        // Mark raw article as used
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

        $response = $this->callApi($prompt, $this->model);
        if (!$response) {
            $response = $this->callApi($prompt, $this->fallbackModel);
        }

        if (!$response) {
            return null;
        }

        $parsed = $this->parseResponse($response['text']);
        if (!$parsed) {
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
            'generation_model' => $response['model'],
            'generation_tokens' => $response['tokens'] ?? null,
            'reviewed_at' => null,
            'moderator_id' => null,
            'reject_reason' => null,
        ]);

        return $draft->fresh();
    }

    /**
     * Build the rewriting prompt for the AI model.
     */
    protected function buildPrompt(ForexRawArticle $article, bool $isRegeneration = false): string
    {
        $regenerationNote = $isRegeneration
            ? "\nIMPORTANT: This is a regeneration request. Write a completely different angle and perspective from any previous version."
            : '';

        return <<<PROMPT
<s>[INST] You are a professional forex trading analyst and financial writer writing for tradelikeokafor.com. Write with authority, clarity, and insight like a seasoned market analyst. Never copy source text verbatim. Always rewrite from scratch using only the facts provided.{$regenerationNote}

INSTRUCTIONS:
1. Write a compelling SEO headline (maximum 60 characters)
2. Write an expert-level 600-800 word article covering these sections in order:
   - Market Context: What's happening and why it matters
   - Key Data & Analysis: The numbers, levels, and technical/fundamental factors
   - Trader Implications: What this means for retail forex traders
   - Outlook: What to watch next and potential scenarios
3. End with a natural, non-salesy closing paragraph that mentions tradelikeokafor.com
4. Write a 2-sentence excerpt for the blog listing page
5. Generate 3-5 relevant SEO tags
6. Write a meta description (max 155 characters)

OUTPUT FORMAT - Return ONLY valid JSON, no other text:
{"title": "Your headline here", "content": "Full article with HTML paragraphs using <p> tags and <h3> for subheadings", "excerpt": "2 sentence summary", "tags": ["tag1", "tag2", "tag3"], "meta_description": "SEO meta description"}

SOURCE ARTICLE TO REWRITE:
Title: {$article->raw_title}
Source: {$article->source_name}
Published: {$article->published_at?->format('Y-m-d H:i')}
Content: {$article->raw_content}
[/INST]</s>
PROMPT;
    }

    /**
     * Call the HuggingFace Inference API with retry logic.
     */
    protected function callApi(string $prompt, string $model, int $maxRetries = 3): ?array
    {
        $url = "https://api-inference.huggingface.co/models/{$model}";

        for ($attempt = 1; $attempt <= $maxRetries; $attempt++) {
            try {
                $response = Http::timeout(120)
                    ->withHeaders([
                        'Authorization' => "Bearer {$this->apiToken}",
                        'Content-Type' => 'application/json',
                    ])
                    ->post($url, [
                        'inputs' => $prompt,
                        'parameters' => [
                            'max_new_tokens' => 2048,
                            'temperature' => 0.7,
                            'top_p' => 0.9,
                            'do_sample' => true,
                            'return_full_text' => false,
                        ],
                    ]);

                // Handle model loading (503)
                if ($response->status() === 503) {
                    $body = $response->json();
                    $waitTime = $body['estimated_time'] ?? 30;
                    Log::info("HuggingFace: Model loading, waiting {$waitTime}s", ['model' => $model]);
                    sleep(min((int) ceil($waitTime), 60));
                    continue;
                }

                // Handle rate limiting (429)
                if ($response->status() === 429) {
                    $waitTime = pow(2, $attempt) * 5; // Exponential backoff
                    Log::warning("HuggingFace: Rate limited, waiting {$waitTime}s", ['model' => $model]);
                    sleep($waitTime);
                    continue;
                }

                if (!$response->successful()) {
                    Log::error("HuggingFace: API error", [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'model' => $model,
                    ]);
                    continue;
                }

                $data = $response->json();

                // Extract generated text
                $generatedText = '';
                if (is_array($data) && isset($data[0]['generated_text'])) {
                    $generatedText = $data[0]['generated_text'];
                } elseif (is_array($data) && isset($data['generated_text'])) {
                    $generatedText = $data['generated_text'];
                } elseif (is_string($data)) {
                    $generatedText = $data;
                }

                if (empty($generatedText)) {
                    Log::warning('HuggingFace: Empty response', ['model' => $model, 'data' => $data]);
                    continue;
                }

                return [
                    'text' => $generatedText,
                    'model' => $model,
                    'tokens' => $data[0]['details']['generated_tokens'] ?? null,
                ];

            } catch (\Exception $e) {
                Log::error("HuggingFace: Request failed (attempt {$attempt}/{$maxRetries})", [
                    'model' => $model,
                    'error' => $e->getMessage(),
                ]);

                if ($attempt < $maxRetries) {
                    sleep(pow(2, $attempt) * 2);
                }
            }
        }

        return null;
    }

    /**
     * Parse the AI response — try JSON first, then regex fallback.
     */
    protected function parseResponse(string $text): ?array
    {
        // Try to extract JSON from the response
        $json = $this->extractJson($text);

        if ($json && $this->validateParsedContent($json)) {
            return $json;
        }

        // Fallback: try regex extraction
        return $this->regexFallbackParse($text);
    }

    /**
     * Extract JSON from AI response text.
     */
    protected function extractJson(string $text): ?array
    {
        // Try direct JSON parse
        $decoded = json_decode($text, true);
        if ($decoded && isset($decoded['title']) && isset($decoded['content'])) {
            return $decoded;
        }

        // Try to find JSON within the text (AI sometimes adds text around JSON)
        if (preg_match('/\{[\s\S]*"title"[\s\S]*"content"[\s\S]*\}/U', $text, $matches)) {
            // Get the last match (most complete JSON)
            $jsonStr = $matches[0];

            // Fix common JSON issues from AI
            $jsonStr = preg_replace('/,\s*}/', '}', $jsonStr); // trailing commas
            $jsonStr = preg_replace('/,\s*]/', ']', $jsonStr); // trailing commas in arrays

            $decoded = json_decode($jsonStr, true);
            if ($decoded && isset($decoded['title'])) {
                return $decoded;
            }
        }

        // Try a more aggressive search
        if (preg_match('/\{[^{}]*"title"\s*:\s*"[^"]+"/s', $text)) {
            // Find the outermost JSON object
            $start = strpos($text, '{');
            if ($start !== false) {
                $depth = 0;
                $end = $start;
                for ($i = $start; $i < strlen($text); $i++) {
                    if ($text[$i] === '{') $depth++;
                    if ($text[$i] === '}') $depth--;
                    if ($depth === 0) {
                        $end = $i;
                        break;
                    }
                }

                $jsonStr = substr($text, $start, $end - $start + 1);
                $decoded = json_decode($jsonStr, true);
                if ($decoded && isset($decoded['title'])) {
                    return $decoded;
                }
            }
        }

        return null;
    }

    /**
     * Fallback regex-based parsing when JSON extraction fails.
     */
    protected function regexFallbackParse(string $text): ?array
    {
        $result = [
            'title' => '',
            'content' => '',
            'excerpt' => '',
            'tags' => [],
            'meta_description' => '',
        ];

        // Try to find a title (first line that looks like a headline)
        if (preg_match('/(?:title|headline|heading)[\s:]*["\']?([^"\'\n]{10,80})/i', $text, $m)) {
            $result['title'] = trim($m[1]);
        } elseif (preg_match('/^(?:#+\s*)?(.{10,80})$/m', $text, $m)) {
            $result['title'] = trim($m[1]);
        }

        // Get the main content (everything after first significant paragraph)
        $lines = explode("\n", $text);
        $contentLines = [];
        $started = false;

        foreach ($lines as $line) {
            $line = trim($line);
            if (!$started && strlen($line) > 50) {
                $started = true;
            }
            if ($started && !empty($line)) {
                $contentLines[] = "<p>{$line}</p>";
            }
        }

        $result['content'] = implode("\n", $contentLines);
        $result['excerpt'] = mb_substr(strip_tags($result['content']), 0, 300);

        // Only return if we got meaningful content
        if (strlen($result['title']) > 5 && strlen($result['content']) > 200) {
            return $result;
        }

        return null;
    }

    /**
     * Validate that parsed content meets minimum quality standards.
     */
    protected function validateParsedContent(array $parsed): bool
    {
        if (empty($parsed['title']) || strlen($parsed['title']) < 5) {
            return false;
        }

        if (empty($parsed['content']) || strlen($parsed['content']) < 200) {
            return false;
        }

        return true;
    }

    /**
     * Determine the best CTA based on article content keywords.
     */
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
