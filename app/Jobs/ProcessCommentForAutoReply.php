<?php

namespace App\Jobs;

use App\Models\Dashboard\CampaignTracking\CampaignAnalytics;
use App\Models\Dashboard\CampaignTracking\CommentAiAnalysis;
use App\Models\Dashboard\CampaignTracking\CommentAutoReply;
use App\Models\Dashboard\CampaignTracking\PostComment;
use App\Models\Facebook\UserPage;
use App\Services\AI\AIManager;
use App\Services\AI\PromptService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ProcessCommentForAutoReply implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected PostComment $postComment;
    protected int $campaignAnalyticsId;

    /**
     * @param PostComment $postComment  The normalized PostComment model
     * @param int         $campaignAnalyticsId
     */
    public function __construct(PostComment $postComment, int $campaignAnalyticsId)
    {
        $this->postComment          = $postComment;
        $this->campaignAnalyticsId  = $campaignAnalyticsId;
    }

    public function handle()
    {
        try {
            // Step 1: Check if already analyzed (post_comment_id unique constraint guards this)
            if (CommentAiAnalysis::where('post_comment_id', $this->postComment->id)->exists()) {
                return;
            }

            // Step 2: Call Python microservice for analysis
            $commentData = [
                'id'      => $this->postComment->facebook_comment_id,
                'message' => $this->postComment->message,
            ];

            $analysisResult = $this->analyzeCommentWithPython($commentData);

            if (!$analysisResult['success']) {
                return;
            }

            // Step 3: Save analysis result — linked to PostComment via integer FK
            $analysis = CommentAiAnalysis::create([
                'post_comment_id'      => $this->postComment->id,
                'facebook_comment_id'  => $this->postComment->facebook_comment_id,
                'message'              => $this->postComment->message,
                'sentiment'            => $analysisResult['data']['sentiment'],
                'type'                 => $analysisResult['data']['type'],
                'should_reply'         => $analysisResult['data']['should_reply'],
                'priority'             => $analysisResult['data']['priority'],
                'confidence'           => $analysisResult['data']['confidence'],
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
            $response = Http::timeout(30)
                ->post(config('services.ml_microservice.url') . '/analyze-comments-dict', $commentData);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()[0]];
            }

            $response = Http::timeout(30)
                ->post(config('services.ml_microservice.url') . '/analyze-comments-raw', [
                    'comments' => [$commentData]
                ]);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()[0]];
            }

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
        try {
            // Get campaign analytics for page token and post_message context
            $campaignAnalytics = CampaignAnalytics::find($this->campaignAnalyticsId);
            if (!$campaignAnalytics || !$campaignAnalytics->adSchedule) {
                return;
            }

            $userPage = $campaignAnalytics->adSchedule->userPage;
            if (!$userPage || !$userPage->page_access_token) {
                return;
            }

            // Generate reply with post context for better AI responses
            $postMessage = $campaignAnalytics->post_message ?? '';
            $replyText   = $this->generateReplyWithAi($analysis, $postMessage);

            if (!$replyText) {
                return;
            }

            // Add random delay (5-30 seconds) to avoid spam detection
            sleep(rand(5, 30));

            $facebookCommentId = $this->postComment->facebook_comment_id;
            $replyResult       = $this->sendReplyToFacebook($facebookCommentId, $replyText, $userPage);

            // Save reply — using integer FK to analysis
            CommentAutoReply::create([
                'comment_ai_analysis_id' => $analysis->id,
                'reply_text'             => $replyText,
                'status'                 => $replyResult['success'] ? 'success' : 'failed',
                'response_fb'            => $replyResult['response'] ?? null,
            ]);
        } catch (\Exception $e) {
            // Error handling without logging
        }
    }

    protected function generateReplyWithAi(CommentAiAnalysis $analysis, string $postMessage = '')
    {
        $postContext = $postMessage
            ? "Nội dung bài đăng (post): \"{$postMessage}\"\n\n"
            : '';

        $promptService = app(PromptService::class);
        $aiClient = app(AIManager::class)->driver();

        $promptVars = [
            'context' => $postContext,
            'message' => $analysis->message,
            'sentiment' => $analysis->sentiment,
            'type' => $analysis->type,
        ];

        $prompt = $promptService->getPrompt('comment-reply-standard', $promptVars);
        $result = $aiClient->generate($prompt, ['json' => true]);

        if ($result['success'] && isset($result['data']['reply'])) {
            return $result['data']['reply'];
        }

        return $this->getFallbackReply($analysis);
    }

    protected function sendReplyToFacebook($commentId, $message, UserPage $userPage)
    {
        try {
            sleep(rand(5, 30));

            $response = Http::post("https://graph.facebook.com/v25.0/{$commentId}/comments", [
                'message'      => $message,
                'access_token' => $userPage->page_access_token,
            ]);

            return [
                'success'  => $response->successful(),
                'response' => $response->json(),
            ];

        } catch (\Exception $e) {
            return [
                'success'  => false,
                'response' => ['error' => $e->getMessage()],
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