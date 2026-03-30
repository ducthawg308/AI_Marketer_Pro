<?php

namespace App\Services\Dashboard\MarketResearch;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SerpApiService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.serpapi.api_key');
        $this->baseUrl = config('services.serpapi.base_url', 'https://serpapi.com/search');
    }

    /**
     * Tìm kiếm chung (Google Search)
     */
    public function searchOrganic($q)
    {
        return $this->callApi([
            'q' => $q,
            'engine' => 'google',
            'gl' => 'vn',
            'hl' => 'vi',
            'num' => 10,
        ]);
    }

    /**
     * Tìm kiếm Shopping (Google Shopping)
     */
    public function searchShopping($q)
    {
        return $this->callApi([
            'q' => $q,
            'engine' => 'google_shopping',
            'gl' => 'vn',
            'hl' => 'vi',
            'num' => 20, // get more for pricing
        ]);
    }

    /**
     * Tìm kiếm xu hướng (Google Trends)
     */
    public function searchTrends($q)
    {
        return $this->callApi([
            'q' => $q,
            'engine' => 'google_trends',
            'data_type' => 'TIMESERIES',
            'date' => 'today 5-y', // Get last 5 years data to have enough points for Prophet
            'tz' => '-420', // Vietnam GMT+7
        ]);
    }

    private function callApi(array $params)
    {
        if (empty($this->apiKey)) {
            Log::error('SerpApiService: Missing API Key');
            return null;
        }

        $params['api_key'] = $this->apiKey;

        try {
            $response = Http::timeout(30)->get($this->baseUrl, $params);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('SerpApiService API failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('SerpApiService Exception', ['message' => $e->getMessage()]);
            return null;
        }
    }
}
