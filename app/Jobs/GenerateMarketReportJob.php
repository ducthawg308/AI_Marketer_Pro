<?php

namespace App\Jobs;

use App\Models\Dashboard\AudienceConfig\Product;
use App\Models\Dashboard\MarketResearch\MarketReport;
use App\Services\Dashboard\MarketResearch\SerpApiService;
use App\Services\AI\AIManager;
use App\Services\AI\PromptService;
use App\Transformers\MarketResearch\ChartDataTransformer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GenerateMarketReportJob implements ShouldQueue
{
  use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  protected $product;
  protected $reportId;

  // Setting timeouts
  public $timeout = 600; // 10 minutes

  /**
   * Create a new job instance.
   */
  public function __construct(Product $product, $reportId)
  {
    $this->product = $product;
    $this->reportId = $reportId;
  }

  /**
   * Execute the job.
   */
  public function handle(SerpApiService $serpApi): void
  {
    $report = MarketReport::find($this->reportId);
    if (!$report) {
      return;
    }

    try {
      // ==========================================
      // STAGE 1: Data Acquisition (SerpApi)
      // ==========================================
      $this->updateProgress($report, 'collecting', 10, 'Đang chuẩn bị từ khóa tìm kiếm...');

      $keyword = $this->product->name;
      $industry = $this->product->industry;

      $this->updateProgress($report, 'collecting', 20, "Đang cào dữ liệu Google Search cho '{$keyword}'...");
      $searchResults = $serpApi->searchOrganic("{$keyword} thị trường OR báo cáo");
      Log::info('[MarketResearch][SerpApi] Google Search Response', [
        'is_null' => is_null($searchResults),
        'keys' => !is_null($searchResults) ? array_keys($searchResults) : [],
        'organic_count' => count($searchResults['organic_results'] ?? []),
        'error' => $searchResults['error'] ?? null,
        'search_info' => $searchResults['search_information'] ?? null,
      ]);

      $this->updateProgress($report, 'collecting', 30, "Đang cào dữ liệu Google Shopping cho '{$keyword}'...");
      $shoppingResults = $serpApi->searchShopping($keyword);
      Log::info('[MarketResearch][SerpApi] Google Shopping Response', [
        'is_null' => is_null($shoppingResults),
        'keys' => !is_null($shoppingResults) ? array_keys($shoppingResults) : [],
        'shopping_count' => count($shoppingResults['shopping_results'] ?? []),
        'error' => $shoppingResults['error'] ?? null,
        'first_item' => $shoppingResults['shopping_results'][0] ?? null,
      ]);

      $this->updateProgress($report, 'collecting', 40, "Đang phân tích xu hướng tìm kiếm Google Trends...");
      $trendsResults = $serpApi->searchTrends($keyword);
      Log::info('[MarketResearch][SerpApi] Google Trends Response', [
        'is_null' => is_null($trendsResults),
        'keys' => !is_null($trendsResults) ? array_keys($trendsResults) : [],
        'has_timeline' => isset($trendsResults['timeline_data']),
        'timeline_count' => count($trendsResults['timeline_data'] ?? []),
        'error' => $trendsResults['error'] ?? null,
        'first_timeline' => ($trendsResults['timeline_data'] ?? [])[0] ?? null,
      ]);

      // Extract core data arrays
      $trendTimeline = $this->extractTrendsTimeline($trendsResults);
      $shoppingData = $shoppingResults['shopping_results'] ?? [];
      $searchData = $searchResults['organic_results'] ?? [];

      Log::info('[MarketResearch] Raw SerpApi Data Summary', [
        'search_results_count' => count($searchData),
        'shopping_results_count' => count($shoppingData),
        'trends_timeline_count' => count($trendTimeline),
        'trends_sample' => array_slice($trendTimeline, 0, 3),
        'shopping_sample' => array_slice($shoppingData, 0, 2),
      ]);

      $rawData = [
        'search_results' => $searchData,
        'shopping_data' => $shoppingData,
        'trends_data' => $trendTimeline,
        'news_results' => [],
      ];

      $report->update([
        'raw_data' => $rawData,
        'data_collected_at' => now(),
      ]);

      // ==========================================
      // STAGE 2: Python Processing
      // ==========================================
      $this->updateProgress($report, 'analyzing', 50, 'Đang phân tích số liệu và dự báo AI (Python Agent)...');

      $pythonData = [
        'raw_data' => $rawData,
        'product' => $this->product->toArray(),
      ];

      $pythonResponse = Http::timeout(60)
        ->post(config('services.ml_microservice.url', 'http://localhost:8001') . '/api/v1/market-research/analyze', $pythonData);

      if (!$pythonResponse->successful()) {
        throw new \Exception("Python Microservice Error: " . $pythonResponse->body());
      }

      $quantitativeAnalysis = $pythonResponse->json();

      Log::info('[MarketResearch] Python Quantitative Analysis Result', [
        'trend_direction' => $quantitativeAnalysis['trend_analysis']['trend_direction'] ?? 'N/A',
        'growth_rate' => $quantitativeAnalysis['trend_analysis']['growth_rate_pct'] ?? 'N/A',
        'price_min' => $quantitativeAnalysis['price_analysis']['market_price_min'] ?? 'N/A',
        'price_max' => $quantitativeAnalysis['price_analysis']['market_price_max'] ?? 'N/A',
        'price_avg' => $quantitativeAnalysis['price_analysis']['market_price_avg'] ?? 'N/A',
        'sentiment' => $quantitativeAnalysis['sentiment_analysis']['overall_sentiment'] ?? 'N/A',
        'forecast_6m_count' => count($quantitativeAnalysis['trend_analysis']['forecast_6m'] ?? []),
      ]);

      $report->update([
        'quantitative_analysis' => $quantitativeAnalysis,
        'analysis_completed_at' => now(),
      ]);

      // ==========================================
      // STAGE 3: Insight Generation (AI Provider)
      // ==========================================
      $this->updateProgress($report, 'generating', 75, 'Đang viết báo cáo chiến lược cùng chuyên gia AI...');

      $promptService = app(PromptService::class);
      $aiClient = app(AIManager::class)->driver();

      // Preparations for Prompt
      $compStr = '';
      if (is_array($this->product->competitors)) {
          foreach ($this->product->competitors as $c) {
              if (is_array($c)) {
                  $compStr .= "- " . ($c['name'] ?? '') . " (" . ($c['url'] ?? '') . ")\n";
              }
          }
      }

      $promptVars = [
          'product_name' => $this->product->name,
          'industry' => $this->product->industry,
          'description' => $this->product->description,
          'age_range' => $this->product->target_customer_age_range,
          'income_level' => $this->product->target_customer_income_level,
          'interests' => $this->product->target_customer_interests,
          'competitors' => $compStr,
          'trend_direction' => $quantitativeAnalysis['trend_analysis']['trend_direction'] ?? 'stable',
          'growth_rate' => $quantitativeAnalysis['trend_analysis']['growth_rate_pct'] ?? 0,
          'price_min' => $quantitativeAnalysis['price_analysis']['market_price_min'] ?? 0,
          'price_max' => $quantitativeAnalysis['price_analysis']['market_price_max'] ?? 0,
          'sentiment' => $quantitativeAnalysis['sentiment_analysis']['overall_sentiment'] ?? 'neutral',
      ];

      $prompt = $promptService->getPrompt('market-research-strategic', $promptVars);
      $aiResponse = $aiClient->generate($prompt, ['json' => true]);

      if (!$aiResponse['success']) {
          throw new \Exception("AI Generation Error: " . ($aiResponse['error'] ?? 'Unknown error'));
      }

      $qualitativeAnalysis = $aiResponse['data'];

      // ==========================================
      // STAGE 4: Finalization
      // ==========================================
      $this->updateProgress($report, 'generating', 95, 'Đang tổng hợp và lưu kết quả...');

      $chartTransformer = app(ChartDataTransformer::class);
      $chartData = $chartTransformer->transform($quantitativeAnalysis);

      $report->update([
        'status' => 'completed',
        'current_step' => 'Nghiên cứu thị trường đã hoàn tất.',
        'progress_percent' => 100,
        'qualitative_analysis' => $qualitativeAnalysis,
        'chart_data' => $chartData,
        'completed_at' => now(),
      ]);

    } catch (\Exception $e) {
      Log::error('Market Research Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

      $report->update([
        'status' => 'failed',
        'current_step' => 'Có lỗi xảy ra trong quá trình nghiên cứu.',
        'error_message' => substr($e->getMessage(), 0, 500),
      ]);
    }
  }

  private function updateProgress($report, $status, $percent, $stepMsg)
  {
    $report->update([
      'status' => $status,
      'progress_percent' => $percent,
      'current_step' => $stepMsg,
    ]);
  }

  private function extractTrendsTimeline($trendsResults)
  {
    // Check both 'interest_over_time' -> 'timeline_data' AND 'timeline_data' directly
    $timelineData = $trendsResults['interest_over_time']['timeline_data'] ?? $trendsResults['timeline_data'] ?? null;

    if (empty($timelineData) || !is_array($timelineData)) {
      Log::warning('[MarketResearch] Google Trends returned no timeline_data', [
        'keys' => !empty($trendsResults) ? array_keys($trendsResults) : [],
      ]);
      return [];
    }

    $result = [];
    foreach ($timelineData as $item) {
      // SerpApi Trends date format: "Jan 1 – 7, 2023" or use timestamp field
      $timestamp = $item['timestamp'] ?? null;
      if ($timestamp) {
        // Use unix timestamp directly → format as Y-m
        $dateStr = date('Y-m', (int) $timestamp);
      } else {
        // Fallback: try to strtotime the raw date string
        $rawDate = $item['date'] ?? '';
        $parsed = strtotime($rawDate);
        $dateStr = $parsed ? date('Y-m', $parsed) : date('Y-m');
      }

      // Support both TIMESERIES (values[]) and interest_over_time structure
      $val = 0;
      if (!empty($item['values']) && is_array($item['values'])) {
        $val = $item['values'][0]['extracted_value'] ?? $item['values'][0]['value'] ?? 0;
      } elseif (isset($item['value'])) {
        $val = $item['value'];
      }

      $result[] = ['date' => $dateStr, 'value' => (int) $val];
    }


    Log::info('[MarketResearch] Trends Timeline Extracted', [
      'count' => count($result),
      'first' => $result[0] ?? null,
      'last' => end($result) ?: null,
    ]);

    return $result;
  }


}
