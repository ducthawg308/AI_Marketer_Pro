<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait GeminiApiTrait
{
  private function callGeminiApi(string $prompt): array
  {
    Log::info('GeminiApiTrait: Starting Gemini API call');
    Log::info('GeminiApiTrait: Prompt: ' . $prompt);

    $apiKey = config('services.gemini.api_key');
    if (!$apiKey) {
      Log::error('GeminiApiTrait: Missing API Key');
      return ['success' => false, 'error' => 'Missing API Key'];
    }

    Log::info('GeminiApiTrait: API Key found, making request...');
    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$apiKey";
    $data = [
      "contents" => [
        ["parts" => [["text" => $prompt]]]
      ]
    ];

    Log::info('GeminiApiTrait: Request URL: ' . $url);
    Log::info('GeminiApiTrait: Request data: ' . json_encode($data));

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
    Log::info('GeminiApiTrait: Response: ' . $response);
    Log::info('GeminiApiTrait: cURL Error: ' . $curlError);

    if ($httpCode !== 200) {
      Log::error('GeminiApiTrait: API call failed');
      return [
        'success' => false,
        'error' => [
          'message' => 'Lỗi khi gọi API AI',
          'http_code' => $httpCode,
          'response' => json_decode($response, true),
          'curl_error' => $curlError
        ]
      ];
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
}