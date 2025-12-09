<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait GeminiApiTrait
{
    private function callGeminiApi(string $prompt): array
    {
        $apiKey = config('services.gemini.api_key');
        if (!$apiKey) {
            return ['success' => false, 'error' => 'Missing API Key'];
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$apiKey";
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
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($httpCode !== 200) {
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

        $result = json_decode($response, true);
        $responseText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $jsonStart = strpos($responseText, '{');
        $jsonEnd = strrpos($responseText, '}');
        if ($jsonStart === false || $jsonEnd === false) {
            return ['success' => false, 'error' => "Phản hồi không hợp lệ từ AI"];
        }

        $jsonData = substr($responseText, $jsonStart, $jsonEnd - $jsonStart + 1);
        $parsedData = json_decode($jsonData, true);

        return ['success' => true, 'data' => $parsedData];
    }
}
