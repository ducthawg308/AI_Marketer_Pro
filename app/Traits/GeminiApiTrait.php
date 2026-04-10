<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait GeminiApiTrait
{
  private function callGeminiApi(string $prompt): array
  {
    Log::info('GeminiApiTrait: Starting Gemini API call');
    Log::info('GeminiApiTrait: Prompt: ' . $prompt);

    $apiKeys = config('services.gemini.api_keys');
    if (empty($apiKeys)) {
      Log::error('GeminiApiTrait: No API Keys configured');
      return ['success' => false, 'error' => 'No API Keys configured'];
    }

    // List of models to try in order of preference
    $models = ['gemini-2.5-flash', 'gemini-2.0-flash', 'gemini-flash-latest'];

    $lastError = null;
    foreach ($apiKeys as $keyIndex => $apiKey) {
      foreach ($models as $modelIndex => $model) {
        $attemptCount = ($keyIndex * count($models)) + ($modelIndex + 1);
        Log::info("GeminiApiTrait: Attempt #$attemptCount (Key #" . ($keyIndex + 1) . ", Model: $model)");

        $url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";
        $data = [
          "contents" => [
            ["parts" => [["text" => $prompt]]]
          ]
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_POST => true,
          CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_TIMEOUT => 120,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        Log::info("GeminiApiTrait: Result - HTTP Code: $httpCode");

        if ($httpCode === 200) {
          Log::info("GeminiApiTrait: Successfully got response with Key #" . ($keyIndex + 1) . " and Model $model");
          $result = json_decode($response, true);
          $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

          $jsonStart = strpos($responseText, '{');
          $jsonEnd = strrpos($responseText, '}');

          if ($jsonStart === false || $jsonEnd === false) {
            Log::error('GeminiApiTrait: Invalid JSON response from AI');
            return ['success' => false, 'error' => "Phản hồi không hợp lệ từ AI"];
          }

          $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
          $parsedData = json_decode($jsonData, true);
          return ['success' => true, 'data' => $parsedData];
        }

        $lastError = [
          'message' => 'Lỗi khi gọi API AI',
          'http_code' => $httpCode,
          'response' => json_decode($response, true),
          'curl_error' => $curlError,
          'key_index' => $keyIndex + 1,
          'model' => $model
        ];

        Log::warning("GeminiApiTrait: Attempt failed. Error: " . json_encode($lastError));

        // If it's a 429 or 503, try the next model/key
        // If it's another error (like 400), we might want to stop or continue? 
        // For now, we continue to the next candidate.
      }
    }

    Log::error('GeminiApiTrait: All API keys and models failed');
    return ['success' => false, 'error' => $lastError];
  }
}