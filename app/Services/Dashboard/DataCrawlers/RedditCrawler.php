<?php
namespace App\Services\Dashboard\DataCrawlers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RedditCrawler
{
    protected $baseUrl = 'https://www.reddit.com';
    
    /**
     * Tìm kiếm posts liên quan đến keyword
     */
    public function searchPosts($keyword, $limit = 25, $timeRange = 'month')
    {
        try {
            $url = "{$this->baseUrl}/search.json";
            
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; MarketResearch/1.0)'
            ])->get($url, [
                'q' => $keyword,
                'limit' => $limit,
                'sort' => 'relevance',
                't' => $timeRange, // hour, day, week, month, year, all
                'type' => 'link'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $posts = $data['data']['children'] ?? [];
                
                return [
                    'success' => true,
                    'source' => 'reddit',
                    'keyword' => $keyword,
                    'posts' => array_map(function($post) {
                        $p = $post['data'];
                        return [
                            'title' => $p['title'] ?? '',
                            'text' => $p['selftext'] ?? '',
                            'score' => $p['score'] ?? 0,
                            'num_comments' => $p['num_comments'] ?? 0,
                            'upvote_ratio' => $p['upvote_ratio'] ?? 0,
                            'subreddit' => $p['subreddit'] ?? '',
                            'url' => 'https://reddit.com' . ($p['permalink'] ?? ''),
                            'created' => date('Y-m-d H:i:s', $p['created_utc'] ?? 0),
                        ];
                    }, $posts),
                    'summary' => [
                        'total_posts' => count($posts),
                        'avg_score' => $this->calculateAvgScore($posts),
                        'total_comments' => $this->calculateTotalComments($posts),
                        'top_subreddits' => $this->getTopSubreddits($posts)
                    ]
                ];
            }

            return ['success' => false, 'error' => 'Reddit API failed'];
            
        } catch (\Exception $e) {
            Log::error('Reddit API error: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Lấy trending topics từ subreddit cụ thể
     */
    public function getTrendingFromSubreddit($subreddit, $limit = 25)
    {
        try {
            $url = "{$this->baseUrl}/r/{$subreddit}/hot.json";
            
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0'
            ])->get($url, ['limit' => $limit]);

            if ($response->successful()) {
                $data = $response->json();
                $posts = $data['data']['children'] ?? [];
                
                return [
                    'success' => true,
                    'source' => 'reddit',
                    'subreddit' => $subreddit,
                    'trending_posts' => array_map(function($post) {
                        $p = $post['data'];
                        return [
                            'title' => $p['title'] ?? '',
                            'score' => $p['score'] ?? 0,
                            'num_comments' => $p['num_comments'] ?? 0,
                            'url' => 'https://reddit.com' . ($p['permalink'] ?? ''),
                        ];
                    }, $posts)
                ];
            }

            return ['success' => false, 'error' => 'Failed to fetch subreddit'];
            
        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    private function calculateAvgScore($posts)
    {
        if (empty($posts)) return 0;
        $total = array_sum(array_column(array_column($posts, 'data'), 'score'));
        return round($total / count($posts), 2);
    }

    private function calculateTotalComments($posts)
    {
        return array_sum(array_column(array_column($posts, 'data'), 'num_comments'));
    }

    private function getTopSubreddits($posts)
    {
        $subreddits = [];
        foreach ($posts as $post) {
            $sub = $post['data']['subreddit'] ?? '';
            if ($sub) {
                $subreddits[$sub] = ($subreddits[$sub] ?? 0) + 1;
            }
        }
        arsort($subreddits);
        return array_slice($subreddits, 0, 5, true);
    }
}