<?php

namespace App\Transformers\MarketResearch;

class ChartDataTransformer
{
    /**
     * Transform quantitative analysis into Chart.js datasets.
     *
     * @param array $quant
     * @return array
     */
    public function transform(array $quant): array
    {
        return [
            'trend_chart' => $this->buildTrendChart($quant),
            'price_distribution_chart' => $this->buildPriceChart($quant),
            'sentiment_donut_chart' => $this->buildSentimentChart($quant),
        ];
    }

    protected function buildTrendChart(array $quant): array
    {
        $trend = $quant['trend_analysis'] ?? [];
        $hist  = collect($trend['historical_data'] ?? []);
        $fore  = collect($trend['forecast_6m'] ?? []);

        $labels = $hist->pluck('month')->concat($fore->pluck('month'))->unique()->values()->toArray();

        $histData = [];
        $foreData = [];

        foreach ($labels as $label) {
            $hVal = $hist->firstWhere('month', $label);
            $histData[] = $hVal ? $hVal['value'] : null;

            $fVal = $fore->firstWhere('month', $label);
            $foreData[] = $fVal ? $fVal['predicted'] : null;
        }

        return [
            'type' => 'line',
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Lịch sử',
                    'data' => $histData,
                    'borderColor' => '#6366f1',
                ],
                [
                    'label' => 'Dự báo xu hướng',
                    'data' => $foreData,
                    'borderColor' => '#10b981',
                    'borderDash' => [5, 5],
                ],
            ],
        ];
    }

    protected function buildPriceChart(array $quant): array
    {
        return [
            'type' => 'bar',
            'labels' => ['Budget', 'Mid-Range', 'Premium'],
            'datasets' => [
                [
                    'label' => 'Sản phẩm đối thủ',
                    'data' => [
                        $quant['price_analysis']['price_segments']['budget']['count'] ?? 0,
                        $quant['price_analysis']['price_segments']['mid_range']['count'] ?? 0,
                        $quant['price_analysis']['price_segments']['premium']['count'] ?? 0,
                    ],
                    'backgroundColor' => ['#3b82f6', '#6366f1', '#8b5cf6'],
                ],
            ],
        ];
    }

    protected function buildSentimentChart(array $quant): array
    {
        return [
            'type' => 'doughnut',
            'labels' => ['Tích cực', 'Trung tính', 'Tiêu cực'],
            'datasets' => [
                [
                    'data' => [
                        $quant['sentiment_analysis']['positive_count'] ?? 0,
                        $quant['sentiment_analysis']['neutral_count'] ?? 0,
                        $quant['sentiment_analysis']['negative_count'] ?? 0,
                    ],
                    'backgroundColor' => ['#10b981', '#6b7280', '#ef4444'],
                ],
            ],
        ];
    }
}
