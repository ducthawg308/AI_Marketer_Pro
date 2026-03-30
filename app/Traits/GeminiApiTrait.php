<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait GeminiApiTrait
{
  private function callGeminiApi(string $prompt): array
  {
    Log::info('GeminiApiTrait: Starting Gemini API call');
    Log::info('GeminiApiTrait: Prompt: ' . $prompt);

    $apiKeysString = config('services.gemini.api_keys');
    if (!$apiKeysString) {
      Log::error('GeminiApiTrait: Missing API Keys config');
      return ['success' => false, 'error' => 'Missing API Keys'];
    }

    // Extract keys from comma-separated string
    $apiKeys = array_filter(array_map('trim', explode(',', $apiKeysString)));
    if (empty($apiKeys)) {
      Log::error('GeminiApiTrait: API Keys list is empty');
      return ['success' => false, 'error' => 'API Keys list is empty'];
    }

    // Shuffle keys to distribute load evenly across keys
    shuffle($apiKeys);

    $data = [
      "contents" => [
        ["parts" => [["text" => $prompt]]]
      ]
    ];

    Log::info('GeminiApiTrait: Request data: ' . json_encode($data));

    $httpCode = null;
    $response = null;
    $curlError = null;

    foreach ($apiKeys as $index => $apiKey) {
      Log::info("GeminiApiTrait: Trying API Key (index {$index})...");
      $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$apiKey";

      Log::info('GeminiApiTrait: Request URL: ' . $url);

      $ch = curl_init();
      curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_HTTPHEADER => ["Content-Type: application/json"],
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_TIMEOUT => 120,
      ]);

      Log::info('GeminiApiTrait: Executing cURL request...');
      $response = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $curlError = curl_error($ch);
      curl_close($ch);

      Log::info('GeminiApiTrait: cURL request completed');
      Log::info('GeminiApiTrait: HTTP Code: ' . $httpCode);
      Log::info('GeminiApiTrait: cURL Error: ' . $curlError);

      if ($httpCode !== 200) {
        Log::warning("GeminiApiTrait: API call failed with key index {$index}. HTTP Code: {$httpCode}");
        Log::error("GeminiApiTrait: API Error Response: " . $response);
        // Continue to next key in loop
        continue;
      }

      Log::info('GeminiApiTrait: API call successful, parsing response...');
      $result = json_decode($response, true);
      $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

      Log::info('GeminiApiTrait: Raw response text: ' . $responseText);

      $jsonStart = strpos($responseText, '{');
      $jsonEnd = strrpos($responseText, '}');
      if ($jsonStart === false || $jsonEnd === false) {
        Log::error('GeminiApiTrait: Invalid JSON response from AI');
        return ['success' => false, 'error' => "Phản hồi không hợp lệ từ AI"];
      }

      $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
      $parsedData = json_decode($jsonData, true);

      Log::info('GeminiApiTrait: Parsed response data: ' . json_encode($parsedData));
      Log::info('GeminiApiTrait: Gemini API call completed successfully');

      return ['success' => true, 'data' => $parsedData];
    }

    Log::error('GeminiApiTrait: All API keys failed.');
    return [
      'success' => false,
      'error' => [
        'message' => 'Lỗi khi gọi API AI (thử tất cả các key đều thất bại)',
        'http_code' => $httpCode ?? 500,
        'response' => isset($response) ? json_decode($response, true) : null,
        'curl_error' => $curlError ?? 'Unknown Error'
      ]
    ];
  }
}
