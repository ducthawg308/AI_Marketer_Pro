<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Báo cáo Market Research</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 14px; line-height: 1.5; color: #333; }
        h1 { font-size: 24px; color: #1a56db; text-align: center; margin-bottom: 20px; }
        h2 { font-size: 18px; color: #2563eb; margin-top: 30px; border-bottom: 2px solid #e5e7eb; padding-bottom: 5px; }
        h3 { font-size: 16px; color: #4b5563; }
        .product-info { background: #f3f4f6; p-4; border-radius: 5px; padding: 15px; margin-bottom: 20px;}
        .section { margin-bottom: 20px; }
        ul { margin-top: 5px; margin-bottom: 10px; padding-left: 20px; }
        li { margin-bottom: 5px; }
        .text-justify { text-align: justify; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    @php
        $qualitative = $report->qualitative_analysis;
    @endphp

    <h1>BÁO CÁO NGHIÊN CỨU THỊ TRƯỜNG</h1>
    
    <div class="product-info">
        <h3>Thông tin dự án</h3>
        <p><strong>Tên sản phẩm:</strong> {{ $report->product->name }}</p>
        <p><strong>Ngày tạo:</strong> {{ $report->completed_at ? $report->completed_at->format('d/m/Y') : now()->format('d/m/Y') }}</p>
    </div>

    <!-- 1. Executive Summary -->
    <div class="section">
        <h2>1. Tóm tắt chiến lược</h2>
        <div class="text-justify">
            {{ $qualitative['executive_summary'] ?? 'N/A' }}
        </div>
    </div>

    <!-- 2. SWOT -->
    @if(isset($qualitative['swot_analysis']))
    <div class="section">
        <h2>2. Phân tích SWOT</h2>
        
        <h3>Điểm mạnh (Strengths)</h3>
        <ul>
            @foreach($qualitative['swot_analysis']['strengths'] ?? [] as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>

        <h3>Điểm yếu (Weaknesses)</h3>
        <ul>
            @foreach($qualitative['swot_analysis']['weaknesses'] ?? [] as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>

        <h3>Cơ hội (Opportunities)</h3>
        <ul>
            @foreach($qualitative['swot_analysis']['opportunities'] ?? [] as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>

        <h3>Thách thức (Threats)</h3>
        <ul>
            @foreach($qualitative['swot_analysis']['threats'] ?? [] as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- 3. GTM & Pricing -->
    @if(isset($qualitative['pricing_strategy']))
    <div class="section">
        <h2>3. Chiến lược Giá & Go-to-market</h2>
        <p><strong>Chiến lược giá:</strong> {{ $qualitative['pricing_strategy']['recommended_strategy'] ?? '' }}</p>
        <p><strong>Khoảng giá:</strong> {{ $qualitative['pricing_strategy']['recommended_price_range'] ?? '' }}</p>
        
        @if(isset($qualitative['pricing_strategy']['pricing_tiers']))
        <table>
            <thead>
                <tr>
                    <th>Phân khúc</th>
                    <th>Mức giá</th>
                    <th>Sản phẩm</th>
                </tr>
            </thead>
            <tbody>
                @foreach($qualitative['pricing_strategy']['pricing_tiers'] as $tier)
                <tr>
                    <td>{{ $tier['tier'] ?? '' }}</td>
                    <td>{{ $tier['price_range'] ?? '' }}</td>
                    <td>{{ $tier['products'] ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <br>
        <p><strong>Kênh phân phối / Marketing chính:</strong></p>
        <ul>
            @foreach($qualitative['go_to_market_strategy']['primary_channels'] ?? [] as $ch)
                <li>{{ $ch }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- 4. Action Plan -->
    @if(isset($qualitative['action_plan']))
    <div class="section">
        <h2>4. Kế hoạch hành động 90 ngày</h2>
        
        <h3>Giai đoạn 1 (30 ngày)</h3>
        <ul>
            @foreach($qualitative['action_plan']['phase_1_30_days'] ?? [] as $task)
                <li>{{ $task }}</li>
            @endforeach
        </ul>

        <h3>Giai đoạn 2 (60 ngày)</h3>
        <ul>
            @foreach($qualitative['action_plan']['phase_2_60_days'] ?? [] as $task)
                <li>{{ $task }}</li>
            @endforeach
        </ul>

        <h3>Giai đoạn 3 (90 ngày)</h3>
        <ul>
            @foreach($qualitative['action_plan']['phase_3_90_days'] ?? [] as $task)
                <li>{{ $task }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</body>
</html>
