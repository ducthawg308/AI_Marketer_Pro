<?php

namespace App\Services\Dashboard\CampaignTracking;

use App\Models\Dashboard\CampaignTracking\CommentAiAnalysis;
use App\Models\Dashboard\CampaignTracking\CommentAutoReply;
use App\Models\Dashboard\CampaignTracking\CampaignAnalytics;
use App\Models\Facebook\UserPage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AutoReplyService
{
    /**
     * Process auto-reply for a specific comment
     */
    public function processCommentReply($commentData, $campaignAnalyticsId)
    {
        try {
            // Check if comment already analyzed
            if (CommentAiAnalysis::where('comment_id', $commentData['id'])->exists()) {
                return ['success' => false, 'message' => 'Comment already analyzed'];
            }

            // Analyze comment using Python microservice
            $analysisResult = $this->analyzeCommentWithPython($commentData);

            if (!$analysisResult['success']) {
                Log::error('Failed to analyze comment with Python service', [
                    'comment_id' => $commentData['id'],
                    'error' => $analysisResult['error']
                ]);
                return ['success' => false, 'error' => $analysisResult['error']];
            }

            // Save analysis result
            $analysis = CommentAiAnalysis::create([
                'comment_id' => $commentData['id'],
                'message' => $commentData['message'],
                'sentiment' => $analysisResult['data']['sentiment'],
                'type' => $analysisResult['data']['type'],
                'should_reply' => $analysisResult['data']['should_reply'],
                'priority' => $analysisResult['data']['priority'],
                'confidence' => $analysisResult['data']['confidence'],
            ]);

            // If should reply, generate reply and send to Facebook
            if ($analysis->should_reply) {
                return $this->processAutoReply($analysis, $campaignAnalyticsId);
            }

            return ['success' => true, 'message' => 'Comment analyzed, no reply needed'];

        } catch (\Exception $e) {
            Log::error('Error processing comment for auto-reply', [
                'comment_id' => $commentData['id'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Process auto-reply for an analyzed comment
     */
    protected function processAutoReply(CommentAiAnalysis $analysis, $campaignAnalyticsId)
    {
        try {
            // Generate reply using Gemini
            $replyText = $this->generateReplyWithGemini($analysis);

            if (!$replyText) {
                Log::error('Failed to generate reply with Gemini', [
                    'comment_id' => $analysis->comment_id
                ]);
                return ['success' => false, 'error' => 'Failed to generate reply'];
            }

            // Get campaign analytics to find the page
            $campaignAnalytics = CampaignAnalytics::find($campaignAnalyticsId);
            if (!$campaignAnalytics || !$campaignAnalytics->adSchedule) {
                return ['success' => false, 'error' => 'Campaign analytics not found'];
            }

            $userPage = $campaignAnalytics->adSchedule->userPage;
            if (!$userPage || !$userPage->page_access_token) {
                return ['success' => false, 'error' => 'Page access token not found'];
            }

            // Send reply to Facebook
            $replyResult = $this->sendReplyToFacebook($analysis->comment_id, $replyText, $userPage);

            // Save reply result
            CommentAutoReply::create([
                'comment_id' => $analysis->comment_id,
                'reply_text' => $replyText,
                'status' => $replyResult['success'] ? 'success' : 'failed',
                'response_fb' => $replyResult['response'] ?? null,
            ]);

            return [
                'success' => $replyResult['success'],
                'message' => $replyResult['success'] ? 'Reply sent successfully' : 'Failed to send reply',
                'reply_text' => $replyText,
                'response' => $replyResult['response']
            ];

        } catch (\Exception $e) {
            Log::error('Error processing auto-reply', [
                'comment_id' => $analysis->comment_id,
                'error' => $e->getMessage()
            ]);
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Analyze comment with Python microservice
     */
    protected function analyzeCommentWithPython($commentData)
    {
        try {
            $response = Http::timeout(30)
                ->post(config('services.ml_microservice.url') . '/analyze-comments', [
                    'comments' => [$commentData]
                ]);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()[0]];
            }

            return ['success' => false, 'error' => $response->body()];

        } catch (\Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Generate reply with Gemini API
     */
    protected function generateReplyWithGemini(CommentAiAnalysis $analysis)
    {
        $prompt = "Bạn là chuyên viên chăm sóc khách hàng chuyên nghiệp. Hãy viết câu trả lời cho comment sau bằng tiếng Việt, ngắn gọn 1-3 câu, thân thiện và có thể chốt sale nhẹ nếu phù hợp:\n\nComment: \"{$analysis->message}\"\n\nSentiment: {$analysis->sentiment}\nType: {$analysis->type}\n\nHãy trả lời bằng tiếng Việt, không giải thích, chỉ trả về nội dung câu trả lời dưới dạng JSON: {\"reply\": \"nội dung trả lời\"}";

        // Use the trait method
        $result = app('App\Traits\GeminiApiTrait')->callGeminiApi($prompt);

        if ($result['success'] && isset($result['data']['reply'])) {
            return $result['data']['reply'];
        }

        // Fallback template
        return $this->getFallbackReply($analysis);
    }

    /**
     * Send reply to Facebook
     */
    protected function sendReplyToFacebook($commentId, $message, UserPage $userPage)
    {
        try {
            // Add random delay (5-30 seconds) to avoid spam detection
            sleep(rand(5, 30));

            $response = Http::post("https://graph.facebook.com/v25.0/{$commentId}/comments", [
                'message' => $message,
                'access_token' => $userPage->page_access_token,
            ]);

            return [
                'success' => $response->successful(),
                'response' => $response->json()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'response' => ['error' => $e->getMessage()]
            ];
        }
    }

    /**
     * Get fallback reply template
     */
    protected function getFallbackReply(CommentAiAnalysis $analysis)
    {
        switch ($analysis->type) {
            case 'hoi_gia':
                return "Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn chi tiết về giá cả nhé!";
            case 'hoi_thong_tin':
                return "Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn chi tiết hơn nhé!";
            case 'khieu_nai':
                return "Rất xin lỗi bạn về trải nghiệm chưa tốt. Vui lòng inbox để bên mình hỗ trợ nhanh hơn nhé!";
            case 'khen_ngoi':
                return "Cảm ơn bạn đã ủng hộ! Chúc bạn một ngày tốt lành!";
            default:
                return "Cảm ơn bạn đã quan tâm! Vui lòng inbox để được tư vấn thêm nhé!";
        }
    }

    /**
     * Get reply statistics
     */
    public function getReplyStatistics($campaignId = null)
    {
        $query = CommentAiAnalysis::query();

        if ($campaignId) {
            $query->whereHas('campaignAnalytics', function ($q) use ($campaignId) {
                $q->where('campaign_id', $campaignId);
            });
        }

        $totalComments = $query->count();
        $shouldReply = $query->where('should_reply', true)->count();
        $replied = CommentAutoReply::whereHas('campaignAnalytics', function ($q) use ($campaignId) {
            if ($campaignId) {
                $q->where('campaign_id', $campaignId);
            }
        })->where('status', 'success')->count();

        return [
            'total_comments' => $totalComments,
            'should_reply' => $shouldReply,
            'replied' => $replied,
            'reply_rate' => $totalComments > 0 ? round(($replied / $totalComments) * 100, 2) : 0,
            'should_reply_rate' => $totalComments > 0 ? round(($shouldReply / $totalComments) * 100, 2) : 0,
        ];
    }

    /**
     * Get reply performance by type
     */
    public function getReplyPerformanceByType($campaignId = null)
    {
        $query = CommentAiAnalysis::query();

        if ($campaignId) {
            $query->whereHas('campaignAnalytics', function ($q) use ($campaignId) {
                $q->where('campaign_id', $campaignId);
            });
        }

        return $query->select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->get()
            ->pluck('total', 'type')
            ->toArray();
    }
}