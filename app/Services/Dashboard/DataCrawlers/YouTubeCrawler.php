<?php
namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class YouTubeCrawler
{
    protected $apiKey;
    protected $baseUrl = 'https://www.googleapis.com/youtube/v3';

    public function __construct()
    {
        $this->apiKey = config('services.youtube.api_key');
    }

    /**
     * Tìm kiếm videos theo keyword
     */
    public function searchVideos($keyword, $maxResults = 25, $regionCode = 'VN')
    {
        if (!$this->apiKey) {
            return ['success' => false, 'error' => 'Missing YouTube API key'];
        }

        try {
            $url = "{$this->baseUrl}/search";
            
            $response = Http::get($url, [
                'part' => 'snippet',
                'q' => $keyword,
                'maxResults' => $maxResults,
                'type' => 'video',
                'regionCode' => $regionCode,
                'relevanceLanguage' => 'vi',
                'order' => 'relevance', // relevance, date, viewCount, rating
                'key' => $this->apiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $items = $data['items'] ?? [];
                
                // Lấy thống kê chi tiết cho mỗi video
                $videoIds = implode(',', array_column(array_column($items, 'id'), 'videoId'));
                $statistics = $this->getVideoStatistics($videoIds);
                
                return [
                    'success' => true,
                    'source' => 'youtube',
                    'keyword' => $keyword,
                    'videos' => array_map(function($item) use ($statistics) {
                        $videoId = $item['id']['videoId'] ?? '';
                        $stats = $statistics[$videoId] ?? [];
                        
                        return [
                            'video_id' => $videoId,
                            'title' => $item['snippet']['title'] ?? '',
                            'description' => $item['snippet']['description'] ?? '',
                            'channel' => $item['snippet']['channelTitle'] ?? '',
                            'published_at' => $item['snippet']['publishedAt'] ?? '',
                            'thumbnail' => $item['snippet']['thumbnails']['high']['url'] ?? '',
                            'url' => "https://www.youtube.com/watch?v={$videoId}",
                            'view_count' => $stats['viewCount'] ?? 0,
                            'like_count' => $stats['likeCount'] ?? 0,
                            'comment_count' => $stats['commentCount'] ?? 0,
                        ];
                    }, $items),
                    'summary' => [
                        'total_videos' => count($items),
                        'total_views' => array_sum(array_column($statistics, 'viewCount')),
                        'avg_views' => count($statistics) > 0 ? 
                            round(array_sum(array_column($statistics, 'viewCount')) / count($statistics)) : 0
                    ]
                ];
            }

            return ['success' => false, 'error' => 'YouTube API failed'];
            
        } catch (\Exception $e) {
            Log::error('YouTube API error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Lấy thống kê video
     */
    private function getVideoStatistics($videoIds)
    {
        if (empty($videoIds)) return [];

        try {
            $url = "{$this->baseUrl}/videos";
            
            $response = Http::get($url, [
                'part' => 'statistics',
                'id' => $videoIds,
                'key' => $this->apiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $items = $data['items'] ?? [];
                
                $result = [];
                foreach ($items as $item) {
                    $videoId = $item['id'] ?? '';
                    $stats = $item['statistics'] ?? [];
                    $result[$videoId] = [
                        'viewCount' => (int)($stats['viewCount'] ?? 0),
                        'likeCount' => (int)($stats['likeCount'] ?? 0),
                        'commentCount' => (int)($stats['commentCount'] ?? 0),
                    ];
                }
                
                return $result;
            }

            return [];
            
        } catch (\Exception $e) {
            Log::error('YouTube statistics error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Lấy trending videos
     */
    public function getTrendingVideos($regionCode = 'VN', $maxResults = 25)
    {
        if (!$this->apiKey) {
            return ['success' => false, 'error' => 'Missing API key'];
        }

        try {
            $url = "{$this->baseUrl}/videos";
            
            $response = Http::get($url, [
                'part' => 'snippet,statistics',
                'chart' => 'mostPopular',
                'regionCode' => $regionCode,
                'maxResults' => $maxResults,
                'key' => $this->apiKey
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return [
                    'success' => true,
                    'source' => 'youtube_trending',
                    'data' => $data
                ];
            }

            return ['success' => false, 'error' => 'Failed to fetch trending'];
            
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}