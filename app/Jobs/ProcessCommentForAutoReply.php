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
use Illuminate\Support\Facades\Log;

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
        
        Log::info("ProcessCommentForAutoReply: Starting job for comment ID: {$commentId}");
        $this->logStep("=== PROCESSING COMMENT: {$commentId} ===");
        $this->logStep("Comment message: {$commentMessage}");

        try {
            // Step 1: Check if comment already analyzed
            $this->logStep("Step 1: Checking if comment already analyzed...");
            if (CommentAiAnalysis::where('comment_id', $commentId)->exists()) {
                $this->logStep("Comment already analyzed, skipping...");
                Log::info("ProcessCommentForAutoReply: Comment {$commentId} already analyzed, skipping");
                return;
            }
            $this->logStep("Comment not analyzed yet, proceeding...");

            // Step 2: Call Python microservice for analysis
            $this->logStep("Step 2: Calling Python microservice for analysis...");
            Log::info("ProcessCommentForAutoReply: Calling Python service for comment {$commentId}");
            
            $analysisResult = $this->analyzeCommentWithPython($this->commentData);

            if (!$analysisResult['success']) {
                $this->logStep("Failed to analyze comment with Python service");
                Log::error('ProcessCommentForAutoReply: Failed to analyze comment with Python service', [
                    'comment_id' => $commentId,
                    'error' => $analysisResult['error']
                ]);
                return;
            }

            $this->logStep("Python analysis successful");
            $this->logStep("Analysis result: " . json_encode($analysisResult['data']));

            // Step 3: Save analysis result
            $this->logStep("Step 3: Saving analysis result to database...");
            Log::info("ProcessCommentForAutoReply: Saving analysis for comment {$commentId}");
            
            $analysis = CommentAiAnalysis::create([
                'comment_id' => $commentId,
                'message' => $commentMessage,
                'sentiment' => $analysisResult['data']['sentiment'],
                'type' => $analysisResult['data']['type'],
                'should_reply' => $analysisResult['data']['should_reply'],
                'priority' => $analysisResult['data']['priority'],
                'confidence' => $analysisResult['data']['confidence'],
            ]);

            $this->logStep("Analysis saved successfully with ID: {$analysis->id}");

            // Step 4: Check if should reply
            $this->logStep("Step 4: Checking if comment should be replied to...");
            if ($analysis->should_reply) {
                $this->logStep("Comment should be replied to (priority: {$analysis->priority})");
                $this->processAutoReply($analysis);
            } else {
                $this->logStep("Comment should NOT be replied to (type: {$analysis->type})");
            }

        } catch (\Exception $e) {
            $this->logStep("ERROR: Exception occurred during processing");
            Log::error('ProcessCommentForAutoReply: Error processing comment', [
                'comment_id' => $commentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * Log step with consistent formatting
     */
    private function logStep($message)
    {
        Log::info("ProcessCommentForAutoReply: {$message}");
    }

    protected function analyzeCommentWithPython($commentData)
    {
        try {
            $this->logStep("Making request to Python microservice with comment data: " . json_encode($commentData));
            
            // Try the dict endpoint first
            $response = Http::timeout(30)
                ->post(config('services.ml_microservice.url') . '/analyze-comments-dict', $commentData);

            $this->logStep("Python microservice response status: {$response->status()}");
            $this->logStep("Python microservice response body: " . $response->body());

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()[0]];
            }

            // If the dict endpoint fails, try the raw endpoint
            $this->logStep("Dict endpoint failed, trying raw endpoint...");
            $response = Http::timeout(30)
                ->post(config('services.ml_microservice.url') . '/analyze-comments-raw', [
                    'comments' => [$commentData]
                ]);

            $this->logStep("Python microservice response status: {$response->status()}");
            $this->logStep("Python microservice response body: " . $response->body());

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()[0]];
            }

            // If the raw endpoint fails, try the old endpoint
            $this->logStep("Raw endpoint failed, trying old endpoint...");
            $response = Http::timeout(30)
                ->post(config('services.ml_microservice.url') . '/analyze-comments', [
                    'comments' => [$commentData]
                ]);

            $this->logStep("Python microservice response status: {$response->status()}");
            $this->logStep("Python microservice response body: " . $response->body());

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()[0]];
            }

            return ['success' => false, 'error' => $response->body()];

        } catch (\Exception $e) {
            $this->logStep("Exception occurred while calling Python microservice: {$e->getMessage()}");
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    protected function processAutoReply(CommentAiAnalysis $analysis)
    {
        $commentId = $analysis->comment_id;
        
        $this->logStep("=== PROCESSING AUTO-REPLY FOR COMMENT: {$commentId} ===");
        $this->logStep("Step 1: Generating reply with Gemini API...");

        try {
            // Generate reply using Gemini
            $replyText = $this->generateReplyWithGemini($analysis);

            if (!$replyText) {
                $this->logStep("Failed to generate reply with Gemini");
                Log::error('ProcessCommentForAutoReply: Failed to generate reply with Gemini', [
                    'comment_id' => $commentId
                ]);
                return;
            }

            $this->logStep("Gemini reply generated successfully");
            $this->logStep("Generated reply: {$replyText}");

            // Get campaign analytics to find the page
            $this->logStep("Step 2: Getting campaign analytics and page info...");
            $campaignAnalytics = CampaignAnalytics::find($this->campaignAnalyticsId);
            if (!$campaignAnalytics || !$campaignAnalytics->adSchedule) {
                $this->logStep("Campaign analytics or ad schedule not found");
                Log::warning('ProcessCommentForAutoReply: Campaign analytics or ad schedule not found', [
                    'comment_id' => $commentId,
                    'campaign_analytics_id' => $this->campaignAnalyticsId
                ]);
                return;
            }

            $userPage = $campaignAnalytics->adSchedule->userPage;
            if (!$userPage || !$userPage->page_access_token) {
                $this->logStep("User page or page access token not found");
                Log::warning('ProcessCommentForAutoReply: User page or page access token not found', [
                    'comment_id' => $commentId,
                    'page_id' => $userPage->page_id ?? 'unknown'
                ]);
                return;
            }

            $this->logStep("Page info retrieved successfully (Page ID: {$userPage->page_id})");

            // Send reply to Facebook
            $this->logStep("Step 3: Sending reply to Facebook...");
            $this->logStep("Adding random delay (5-30 seconds) to avoid spam detection...");
            
            // Add random delay (5-30 seconds) to avoid spam detection
            $delay = rand(5, 30);
            sleep($delay);
            $this->logStep("Delay completed ({$delay} seconds)");

            $replyResult = $this->sendReplyToFacebook($commentId, $replyText, $userPage);

            $this->logStep("Facebook API response: " . json_encode($replyResult));

            // Save reply result
            $this->logStep("Step 4: Saving reply result to database...");
            CommentAutoReply::create([
                'comment_id' => $commentId,
                'reply_text' => $replyText,
                'status' => $replyResult['success'] ? 'success' : 'failed',
                'response_fb' => $replyResult['response'] ?? null,
            ]);

            if ($replyResult['success']) {
                $this->logStep("Auto-reply completed successfully!");
            } else {
                $this->logStep("Auto-reply failed, but result saved to database");
            }

        } catch (\Exception $e) {
            $this->logStep("ERROR: Exception occurred during auto-reply processing");
            Log::error('ProcessCommentForAutoReply: Error processing auto-reply', [
                'comment_id' => $commentId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    protected function generateReplyWithGemini(CommentAiAnalysis $analysis)
    {
        $commentId = $analysis->comment_id;
        $this->logStep("Generating reply with Gemini API for comment: {$commentId}");
        
        $prompt = "Bạn là chuyên viên chăm sóc khách hàng chuyên nghiệp. Hãy viết câu trả lời cho comment sau bằng tiếng Việt, ngắn gọn 1-3 câu, thân thiện và có thể chốt sale nhẹ nếu phù hợp:\n\nComment: \"{$analysis->message}\"\n\nSentiment: {$analysis->sentiment}\nType: {$analysis->type}\n\nHãy trả lời bằng tiếng Việt, không giải thích, chỉ trả về nội dung câu trả lời dưới dạng JSON: {\"reply\": \"nội dung trả lời\"}";

        $this->logStep("Gemini prompt: {$prompt}");

        // Use the trait method directly
        $result = $this->callGeminiApi($prompt);

        $this->logStep("Gemini API response: " . json_encode($result));

        if ($result['success'] && isset($result['data']['reply'])) {
            $this->logStep("Gemini reply generated successfully");
            return $result['data']['reply'];
        }

        $this->logStep("Gemini API failed or returned invalid response, using fallback template");
        // Fallback template
        return $this->getFallbackReply($analysis);
    }

    protected function sendReplyToFacebook($commentId, $message, UserPage $userPage)
    {
        $this->logStep("Sending reply to Facebook for comment: {$commentId}");
        $this->logStep("Reply message: {$message}");
        $this->logStep("Page ID: {$userPage->page_id}");
        
        try {
            // Add random delay (5-30 seconds) to avoid spam detection
            $delay = rand(5, 30);
            $this->logStep("Adding delay of {$delay} seconds to avoid spam detection...");
            sleep($delay);

            $this->logStep("Making Facebook API request...");
            $response = Http::post("https://graph.facebook.com/v25.0/{$commentId}/comments", [
                'message' => $message,
                'access_token' => $userPage->page_access_token,
            ]);

            $this->logStep("Facebook API response status: {$response->status()}");
            $this->logStep("Facebook API response body: " . $response->body());

            return [
                'success' => $response->successful(),
                'response' => $response->json()
            ];

        } catch (\Exception $e) {
            $this->logStep("Facebook API request failed with exception: {$e->getMessage()}");
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