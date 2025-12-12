<?php

namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Traits\DataCleaner;

class GoogleAutocompleteCrawler
{
    use DataCleaner;

    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.serpapi.api_key');
        $this->baseUrl = config('services.serpapi.base_url');
    }

    public function getAutocompleteSuggestions($keyword, $location = 'Vietnam', $limit = 15)
    {
        if (!$this->apiKey) {
            Log::warning('SerpAPI API key chưa được cấu hình');
            return [
                'success' => false,
                'error' => 'Missing SerpAPI API key',
                'note' => 'Vui lòng cấu hình SERPAPI_API_KEY trong .env'
            ];
        }

        try {
            $params = [
                'engine' => 'google_autocomplete',
                'q' => $keyword,
                'location' => $location,
                'api_key' => $this->apiKey,
                'hl' => 'vi',
            ];

            Log::info('Đang gọi Google Autocomplete API', ['keyword' => $keyword, 'location' => $location]);

            $response = Http::timeout(30)->get($this->baseUrl, $params);

            if (!$response->successful()) {
                Log::error('Google Autocomplete API failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [
                    'success' => false,
                    'error' => 'Google Autocomplete API request failed',
                    'status' => $response->status(),
                    'message' => $response->body()
                ];
            }

            $data = $response->json();
            $suggestions = $data['suggestions'] ?? [];

            $result = [
                'success' => true,
                'source' => 'google_autocomplete_serpapi',
                'keyword' => $keyword,
                'location' => $location,
                'suggestions' => array_map(function($item) {
                    return [
                        'value' => $item['value'] ?? '',
                        'relevance' => $item['relevance'] ?? 0,
                    ];
                }, $suggestions),
                'summary' => [
                    'total_suggestions' => count($suggestions),
                ]
            ];

            $result['suggestions'] = $this->cleanArrayItems($result['suggestions'], ['value']);
            $result['suggestions'] = $this->removeEmptyAndDuplicates($result['suggestions'], 'value', 0, 'relevance');

            return $result;

        } catch (\Exception $e) {
            Log::error('Google Autocomplete Exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'error' => 'Exception: ' . $e->getMessage()
            ];
        }
    }
}
