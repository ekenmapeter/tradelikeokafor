<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageGeneratorService
{
    /**
     * Generate an image based on tags/title and save it locally.
     *
     * @param array $tags
     * @param string|null $title
     * @return string|null The saved image path relative to the public storage disk (e.g. 'posts/filename.jpg')
     */
    public function generateForDraft(array $tags, ?string $title = null): ?string
    {
        $driver = config('forex.image_driver', 'pexels');
        Log::info("ImageGenerator: Generating image using driver '{$driver}'");

        $query = $this->getSearchQuery($tags, $title);
        Log::info("ImageGenerator: Built search query: '{$query}'");

        $imageUrl = null;
        $imageBytes = null;

        try {
            switch ($driver) {
                case 'pexels':
                    $imageUrl = $this->fetchFromPexels($query);
                    break;
                case 'pixabay':
                    $imageUrl = $this->fetchFromPixabay($query);
                    break;
                case 'unsplash':
                    $imageUrl = $this->fetchFromUnsplash($query);
                    break;
                case 'siliconflow':
                    $imageUrl = $this->fetchFromSiliconFlow($query, $tags, $title);
                    break;
                case 'getimg':
                    $imageBytes = $this->fetchFromGetImg($query, $tags, $title);
                    break;
                case 'pollinations':
                    $imageUrl = $this->fetchFromPollinations($query, $tags, $title);
                    break;
                default:
                    Log::error("ImageGenerator: Unsupported driver '{$driver}'");
                    return null;
            }

            // If we got a URL and no bytes yet, download the image bytes
            if ($imageUrl && !$imageBytes) {
                $client = Http::timeout(60);
                if (!config('forex.verify_ssl', true)) {
                    $client = $client->withoutVerifying();
                }
                $downloadResponse = $client->get($imageUrl);
                if ($downloadResponse->successful()) {
                    $imageBytes = $downloadResponse->body();
                } else {
                    Log::error("ImageGenerator: Failed to download image from URL: {$imageUrl}");
                    return null;
                }
            }

            if (empty($imageBytes)) {
                Log::error("ImageGenerator: No image bytes received or downloaded.");
                return null;
            }

            // Ensure directory exists
            if (!Storage::disk('public')->exists('posts')) {
                Storage::disk('public')->makeDirectory('posts');
            }

            // Save image
            $filename = 'generated_' . Str::random(10) . '_' . time() . '.jpg';
            $relativePath = 'posts/' . $filename;

            Storage::disk('public')->put($relativePath, $imageBytes);
            Log::info("ImageGenerator: Image saved successfully to {$relativePath} using driver '{$driver}'");

            return $relativePath;

        } catch (\Exception $e) {
            Log::error("ImageGenerator: Exception during image generation for driver '{$driver}': " . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Build a search query from tags and title keywords.
     */
    protected function getSearchQuery(array $tags, ?string $title): string
    {
        $keywords = [];

        foreach ($tags as $tag) {
            $clean = trim(preg_replace('/[^a-zA-Z0-9\s]/', '', $tag));
            if ($clean && strlen($clean) > 2) {
                $keywords[] = $clean;
            }
        }

        if (empty($keywords) && $title) {
            $titleWords = explode(' ', $title);
            $stopWords = ['how', 'to', 'the', 'and', 'for', 'in', 'of', 'on', 'with', 'a', 'an', 'is', 'are', 'by', 'at'];
            foreach ($titleWords as $word) {
                $cleanWord = strtolower(trim(preg_replace('/[^a-zA-Z0-9]/', '', $word)));
                if ($cleanWord && strlen($cleanWord) > 3 && !in_array($cleanWord, $stopWords)) {
                    $keywords[] = $cleanWord;
                }
            }
        }

        if (empty($keywords)) {
            return 'forex trading';
        }

        // Return first 3 keywords joined by space
        return implode(' ', array_slice($keywords, 0, 3));
    }

    /**
     * Base HTTP client configured with SSL verification flag.
     */
    protected function httpClient()
    {
        $client = Http::timeout(30);
        if (!config('forex.verify_ssl', true)) {
            $client = $client->withoutVerifying();
        }
        return $client;
    }

    /**
     * Fetch random image URL from Pexels matching query.
     */
    protected function fetchFromPexels(string $query): ?string
    {
        $apiKey = config('forex.pexels_api_key');
        if (empty($apiKey)) {
            Log::warning("ImageGenerator (Pexels): PEXELS_API_KEY is not set.");
            return null;
        }

        $response = $this->httpClient()
            ->withHeaders(['Authorization' => $apiKey])
            ->get('https://api.pexels.com/v1/search', [
                'query' => $query,
                'per_page' => 15,
                'orientation' => 'landscape'
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $photos = $data['photos'] ?? [];
            if (!empty($photos)) {
                $randomPhoto = $photos[array_rand($photos)];
                return $randomPhoto['src']['landscape'] ?? $randomPhoto['src']['large2x'] ?? $randomPhoto['src']['large'] ?? null;
            }
            Log::warning("ImageGenerator (Pexels): No photos found for query: '{$query}'");
        } else {
            Log::error("ImageGenerator (Pexels): Request failed", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }

        return null;
    }

    /**
     * Fetch random image URL from Pixabay matching query.
     */
    protected function fetchFromPixabay(string $query): ?string
    {
        $apiKey = config('forex.pixabay_api_key');
        if (empty($apiKey)) {
            Log::warning("ImageGenerator (Pixabay): PIXABAY_API_KEY is not set.");
            return null;
        }

        $response = $this->httpClient()
            ->get('https://pixabay.com/api/', [
                'key' => $apiKey,
                'q' => $query,
                'image_type' => 'photo',
                'orientation' => 'horizontal',
                'per_page' => 15
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $hits = $data['hits'] ?? [];
            if (!empty($hits)) {
                $randomHit = $hits[array_rand($hits)];
                return $randomHit['largeImageURL'] ?? $randomHit['webformatURL'] ?? null;
            }
            Log::warning("ImageGenerator (Pixabay): No images found for query: '{$query}'");
        } else {
            Log::error("ImageGenerator (Pixabay): Request failed", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }

        return null;
    }

    /**
     * Fetch random image URL from Unsplash matching query.
     */
    protected function fetchFromUnsplash(string $query): ?string
    {
        $apiKey = config('forex.unsplash_api_key');
        if (empty($apiKey)) {
            Log::warning("ImageGenerator (Unsplash): UNSPLASH_API_KEY is not set.");
            return null;
        }

        $response = $this->httpClient()
            ->get('https://api.unsplash.com/search/photos', [
                'client_id' => $apiKey,
                'query' => $query,
                'per_page' => 15,
                'orientation' => 'landscape'
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $results = $data['results'] ?? [];
            if (!empty($results)) {
                $randomResult = $results[array_rand($results)];
                return $randomResult['urls']['regular'] ?? $randomResult['urls']['full'] ?? null;
            }
            Log::warning("ImageGenerator (Unsplash): No images found for query: '{$query}'");
        } else {
            Log::error("ImageGenerator (Unsplash): Request failed", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }

        return null;
    }

    /**
     * Generate image via SiliconFlow AI.
     */
    protected function fetchFromSiliconFlow(string $query, array $tags, ?string $title): ?string
    {
        $apiKey = config('forex.siliconflow_api_key');
        if (empty($apiKey)) {
            Log::warning("ImageGenerator (SiliconFlow): SILICONFLOW_API_KEY is not set.");
            return null;
        }

        $prompt = $this->buildAiPrompt($tags, $title);

        $response = $this->httpClient()
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json'
            ])
            ->post('https://api.siliconflow.cn/v1/images/generations', [
                'model' => 'black-forest-labs/FLUX.1-schnell',
                'prompt' => $prompt,
                'width' => 1024,
                'height' => 576
            ]);

        if ($response->successful()) {
            $data = $response->json();
            return $data['images'][0]['url'] ?? null;
        } else {
            Log::error("ImageGenerator (SiliconFlow): Generation failed", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }

        return null;
    }

    /**
     * Generate image via getimg.ai AI.
     */
    protected function fetchFromGetImg(string $query, array $tags, ?string $title): ?string
    {
        $apiKey = config('forex.getimg_api_key');
        if (empty($apiKey)) {
            Log::warning("ImageGenerator (getimg): GETIMG_API_KEY is not set.");
            return null;
        }

        $prompt = $this->buildAiPrompt($tags, $title);

        $response = $this->httpClient()
            ->withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json'
            ])
            ->post('https://api.getimg.ai/v1/essential/text-to-image', [
                'model' => 'essential-v2',
                'prompt' => $prompt,
                'width' => 1024,
                'height' => 576,
                'output_format' => 'jpeg'
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $base64 = $data['image'] ?? null;
            if ($base64) {
                return base64_decode($base64);
            }
        } else {
            Log::error("ImageGenerator (getimg): Generation failed", [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
        }

        return null;
    }

    /**
     * Generate image via Pollinations.ai.
     */
    protected function fetchFromPollinations(string $query, array $tags, ?string $title): ?string
    {
        $prompt = $this->buildAiPrompt($tags, $title);
        $encodedPrompt = rawurlencode($prompt);
        return "https://image.pollinations.ai/prompt/{$encodedPrompt}?width=1024&height=576&nologo=true&private=true&enhance=false";
    }

    /**
     * Build descriptive AI prompt.
     */
    protected function buildAiPrompt(array $tags, ?string $title): string
    {
        $keywordList = count($tags) > 0 ? implode(', ', $tags) : 'forex trading, stock charts';
        return "Clean professional forex financial chart graphic showing {$keywordList}, modern high-tech trading theme, minimalist aesthetic, vector illustration style, dark green and blue color palette, ultra detailed, cinematic lighting, 8k resolution, no text";
    }
}
