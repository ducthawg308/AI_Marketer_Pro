<?php

namespace App\Jobs;

use App\Models\Dashboard\CampaignTracking\CommentAiAnalysis;
use App\Models\Dashboard\CampaignTracking\CommentAutoReply;
use App\Models\Dashboard\CampaignTracking\CampaignAnalytics;
use App\Models\Facebook\UserPage;
use App\Traits\GeminiApiTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessCommentForAutoReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, GeminiApiTrait;

    protected $commentData;
    protected $campaignAnalyticsId;

    public function __construct($commentData, $campaignAnalyticsId)
    {
        $this->commentData = $commentData;
        $this->campaignAnalyticsId = $campaignAnalyticsId;
    }

    public function handle()
    {
        $commentId = $this->commentData['id'] ?? 'unknown';
        $commentMessage = $this->commentData['message'] ?? '';

        try {
            // Step 1: Check if comment already analyzed
            if (CommentAiAnalysis::where('comment_id', $commentId)->exists()) {
                return;
            }

            // Step 2: Call Python microservice for analysis
            $analysisResult = $this->analyzeCommentWithPython($this->commentData);

            if (!$analysisResult['success']) {
                return;
            }

            // Step 3: Save analysis result
            $analysis = CommentAiAnalysis::create([
                'comment_id' => $commentId,
                'message' => $commentMessage,
                'sentiment' => $analysisResult['data']['sentiment'],
                'type' => $analysisResult['data']['type'],
                'should_reply' => $analysisResult['data']['should_reply'],
                'priority' => $analysisResult['data']['priority'],
                'confidence' => $analysisResult['data']['confidence'],
            ]);

            // Step 4: Check if should reply
            if ($analysis->should_reply) {
                $this->processAutoReply($analysis);
            }
        } catch (\Exception $e) {
            // Error handling without logging
        }
    }


    protected function analyzeCommentWithPython($commentData)
    {
        try {
            // Try the dict endpoint first
            $response = Http::timeout(30)
                ->post(config('services.ml_microservice.url') . '/analyze-comments-dict', $commentData);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()[0]];
            }

            // If the dict endpoint fails, try the raw endpoint
            $response = Http::timeout(30)
                ->post(config('services.ml_microservice.url') . '/analyze-comments-raw', [
                    'comments' => [$commentData]
                ]);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()[0]];
            }

            // If the raw endpoint fails, try the old endpoint
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

    protected function processAutoReply(CommentAiAnalysis $analysis)
    {
        $commentId = $analysis->comment_id;
        
        try {
            // Generate reply using Gemini
            $replyText = $this->generateReplyWithGemini($analysis);

            if (!$replyText) {
                return;
            }

            // Get campaign analytics to find the page
            $campaignAnalytics = CampaignAnalytics::find($this->campaignAnalyticsId);
            if (!$campaignAnalytics || !$campaignAnalytics->adSchedule) {
                return;
            }

            $userPage = $campaignAnalytics->adSchedule->userPage;
            if (!$userPage || !$userPage->page_access_token) {
                return;
            }

            // Send reply to Facebook
            // Add random delay (5-30 seconds) to avoid spam detection
            $delay = rand(5, 30);
            sleep($delay);

            $replyResult = $this->sendReplyToFacebook($commentId, $replyText, $userPage);

            // Save reply result
            CommentAutoReply::create([
                'comment_id' => $commentId,
                'reply_text' => $replyText,
                'status' => $replyResult['success'] ? 'success' : 'failed',
                'response_fb' => $replyResult['response'] ?? null,
            ]);
        } catch (\Exception $e) {
            // Error handling without logging
        }
    }

    protected function generateReplyWithGemini(CommentAiAnalysis $analysis)
    {
        $prompt = "Bạn là chuyên viên chăm sóc khách hàng chuyên nghiệp. Hãy viết câu trả lời cho comment sau bằng tiếng Việt, ngắn gọn 1-3 câu, thân thiện và có thể chốt sale nhẹ nếu phù hợp:\n\nComment: \"{$analysis->message}\"\n\nSentiment: {$analysis->sentiment}\nType: {$analysis->type}\n\nHãy trả lời bằng tiếng Việt, không giải thích, chỉ trả về nội dung câu trả lời dưới dạng JSON: {\"reply\": \"nội dung trả lời\"}";

        // Use the trait method directly
        $result = $this->callGeminiApi($prompt);

        if ($result['success'] && isset($result['data']['reply'])) {
            return $result['data']['reply'];
        }

        // Fallback template
        return $this->getFallbackReply($analysis);
    }

    protected function sendReplyToFacebook($commentId, $message, UserPage $userPage)
    {
        try {
            // Add random delay (5-30 seconds) to avoid spam detection
            $delay = rand(5, 30);
            sleep($delay);

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
}