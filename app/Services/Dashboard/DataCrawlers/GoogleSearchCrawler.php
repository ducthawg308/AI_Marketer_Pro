<?php

namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Traits\DataCleaner;

class GoogleSearchCrawler
{
    use DataCleaner;

    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.serpapi.api_key');
        $this->baseUrl = config('services.serpapi.base_url');
    }

    public function searchResults($keyword, $location = 'Vietnam', $limit = 15)
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
                'engine' => 'google',
                'q' => $keyword,
                'location' => $location,
                'api_key' => $this->apiKey,
                'hl' => 'vi',
                'num' => $limit,
            ];

            Log::info('Đang gọi Google Search API', ['keyword' => $keyword, 'location' => $location]);

            $response = Http::timeout(30)->get($this->baseUrl, $params);

            if (!$response->successful()) {
                Log::error('Google Search API failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return [
                    'success' => false,
                    'error' => 'Google Search API request failed',
                    'status' => $response->status(),
                    'message' => $response->body()
                ];
            }

            $data = $response->json();
            $organicResults = $data['organic_results'] ?? [];

            $result = [
                'success' => true,
                'source' => 'google_search_serpapi',
                'keyword' => $keyword,
                'location' => $location,
                'results' => array_map(function($item) {
                    return [
                        'title' => $item['title'] ?? '',
                        'link' => $item['link'] ?? '',
                        'displayed_link' => $item['displayed_link'] ?? '',
                        'snippet' => $item['snippet'] ?? '',
                        'rich_snippet' => $item['rich_snippet'] ?? '',
                        'position' => $item['position'] ?? 0,
                    ];
                }, $organicResults),
                'summary' => [
                    'total_results' => count($organicResults),
                ]
            ];

            $result['results'] = $this->cleanArrayItems($result['results'], ['title', 'snippet']);
            $result['results'] = $this->removeEmptyAndDuplicates($result['results'], 'title', 0, 'position');

            return $result;

        } catch (\Exception $e) {
            Log::error('Google Search Exception', [
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
