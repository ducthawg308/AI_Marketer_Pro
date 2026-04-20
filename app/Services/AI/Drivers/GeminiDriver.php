<?php

namespace App\Services\AI\Drivers;

use App\Services\AI\Contracts\AIProviderInterface;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiDriver implements AIProviderInterface
{
  protected array $apiKeys;
  protected array $models;

  public function __construct()
  {
    // Convert comma-separated string from config to array if needed, 
    // but traits showed it might already be an array or handled.
    $keys = config('services.gemini.api_keys');
    $this->apiKeys = is_array($keys) ? $keys : explode(',', $keys);

    $this->models = ['gemini-2.5-flash'];
  }

  public function generate(string $prompt, array $options = []): array
  {
    Log::info('GeminiDriver: Starting generation');
    Log::info('GeminiDriver: Prompt received', ['prompt' => $prompt]);

    $lastError = null;
    foreach ($this->apiKeys as $keyIndex => $apiKey) {
      foreach ($this->models as $modelIndex => $model) {
        try {
          $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key=" . trim($apiKey);

          $response = Http::timeout(120)
            ->retry(3, 2000)
            ->post($url, [
              'contents' => [
                ['parts' => [['text' => $prompt]]]
              ]
            ]);

          Log::info("GeminiDriver: Attempt (Key #" . ($keyIndex + 1) . ", Model: $model) - Status: " . $response->status());

          if ($response->successful()) {
            $result = $response->json();
            $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

            Log::info("GeminiDriver: Response successfully received", [
                'model' => $model,
                'response_text' => $responseText
            ]);

            // Logic to extract JSON if requested in options or just return text
            $data = $responseText;
            if ($options['json'] ?? true) {
              $jsonStart = strpos($responseText, '{');
              $jsonEnd = strrpos($responseText, '}');

              if ($jsonStart !== false && $jsonEnd !== false) {
                $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
                $data = json_decode($jsonData, true) ?: $responseText;
              }
            }

            return [
              'success' => true,
              'content' => $responseText,
              'data' => $data,
              'model' => $model
            ];
          }

          $lastError = [
            'http_code' => $response->status(),
            'response' => $response->json(),
            'model' => $model
          ];

        } catch (\Exception $e) {
          Log::error("GeminiDriver Exception: " . $e->getMessage());
          $lastError = ['error' => $e->getMessage()];
        }
      }
    }

    return [
      'success' => false,
      'error' => 'All Gemini attempts failed',
      'details' => $lastError
    ];
  }
}
