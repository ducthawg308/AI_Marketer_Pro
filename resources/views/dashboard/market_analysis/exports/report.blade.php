<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Phân Tích Thị Trường - {{ $product->name }}</title>
    <style>
        @page {
            margin: 1in;
            size: A4;
        }
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #2563eb;
            font-size: 24px;
            margin: 0;
            font-weight: bold;
        }
        .header .subtitle {
            color: #6b7280;
            font-size: 14px;
            margin: 10px 0 0 0;
        }
        .product-info {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #2563eb;
        }
        .product-info h2 {
            color: #1f2937;
            font-size: 16px;
            margin: 0 0 10px 0;
            font-weight: bold;
        }
        .product-info p {
            margin: 5px 0;
            font-size: 12px;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section h3 {
            color: #1f2937;
            font-size: 16px;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            margin: 0 0 15px 0;
            font-weight: bold;
        }
        .content {
            margin-bottom: 15px;
        }
        .trend-item, .recommendation-item {
            background-color: #f9fafb;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 10px;
            border-left: 3px solid #10b981;
        }
        .trend-item.impact-high { border-left-color: #ef4444; }
        .trend-item.impact-medium { border-left-color: #f59e0b; }
        .trend-item.impact-low { border-left-color: #10b981; }
        .swot-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        .swot-item {
            display: table-cell;
            width: 25%;
            vertical-align: top;
            padding: 10px;
        }
        .swot-item h4 {
            color: #1f2937;
            font-size: 14px;
            margin: 0 0 8px 0;
            font-weight: bold;
        }
        .swot-strengths { background-color: #dcfce7; border-left: 3px solid #16a34a; }
        .swot-weaknesses { background-color: #fef2f2; border-left: 3px solid #dc2626; }
        .swot-opportunities { background-color: #dbeafe; border-left: 3px solid #2563eb; }
        .swot-threats { background-color: #fef3c7; border-left: 3px solid #d97706; }
        .recommendation-item.priority-high { border-left-color: #ef4444; }
        .recommendation-item.priority-medium { border-left-color: #f59e0b; }
        .recommendation-item.priority-low { border-left-color: #10b981; }
        .footer {
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
            margin-top: 30px;
        }
        .generated-info {
            text-align: right;
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        ul, ol {
            padding-left: 20px;
        }
        li {
            margin-bottom: 3px;
        }
    </style>
</head>
<body>
    <div class="generated-info">
        Được tạo tự động bởi AI Marketer Pro vào {{ $generatedAt }}
    </div>

    <div class="header">
        <h1>BÁO CÁO PHÂN TÍCH THỊ TRƯỜNG</h1>
        <p class="subtitle">Phân tích chuyên sâu về thị trường và xu hướng phát triển</p>
    </div>

    <div class="product-info">
        <h2>THÔNG TIN SẢN PHẨM</h2>
        <p><strong>Tên sản phẩm:</strong> {{ $product->name }}</p>
        <p><strong>Ngành nghề:</strong> {{ $product->industry }}</p>
        <p><strong>Mô tả:</strong> {{ $product->description }}</p>
        <p><strong>Loại phân tích:</strong> {{ ucfirst($analysisType) }}</p>
    </div>

    <!-- Market Overview -->
    @if(isset($data['market_size']) || isset($data['growth_rate']))
    <div class="section">
        <h2>TỔNG QUAN THỊ TRƯỜNG</h2>
        @if(isset($data['market_size']))
        <div class="content">
            <p><strong>Quy mô thị trường:</strong> {{ $data['market_size'] }}</p>
        </div>
        @endif
        @if(isset($data['growth_rate']))
        <div class="content">
            <p><strong>Tốc độ tăng trưởng:</strong> {{ $data['growth_rate'] }}</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Consumer Analysis -->
    @if(isset($data['age_range']) || isset($data['income']) || isset($data['interests']))
    <div class="section">
        <h2>PHÂN TÍCH KHÁCH HÀNG MỤC TIÊU</h2>

        @if(isset($data['age_range']))
        <div class="content">
            <p><strong>Độ tuổi mục tiêu:</strong> {{ $data['age_range'] }}</p>
        </div>
        @endif

        @if(isset($data['income']))
        <div class="content">
            <p><strong>Mức thu nhập:</strong> {{ $data['income'] }}</p>
        </div>
        @endif

        @if(isset($data['interests']) && is_array($data['interests']))
        <div class="content">
            <p><strong>Sở thích:</strong> {{ implode(', ', $data['interests']) }}</p>
        </div>
        @endif

        @if(isset($data['behaviors']) && is_array($data['behaviors']))
        <h3>Hành vi tiêu dùng:</h3>
        <ul style="margin-bottom: 15px;">
            @foreach($data['behaviors'] as $behavior)
                <li>{{ $behavior }}</li>
            @endforeach
        </ul>
        @endif

        @if(isset($data['pain_points']) && is_array($data['pain_points']))
        <h3>Vấn đề khách hàng gặp phải:</h3>
        <ul>
            @foreach($data['pain_points'] as $pain)
                <li>{{ $pain }}</li>
            @endforeach
        </ul>
        @endif
    </div>
    @endif

    <!-- Competitors Analysis -->
    @if(isset($data['competitors']) && is_array($data['competitors']))
    <div class="section">
        <h2>ĐỐI THỦ CẠNH TRANH</h2>
        @foreach($data['competitors'] as $index => $competitor)
        <div class="content" style="margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 8px;">
            <h3>Đối thủ {{ $index + 1 }}: {{ $competitor['name'] ?? 'N/A' }}</h3>

            @if(isset($competitor['url']))
            <p><strong>Website:</strong> {{ $competitor['url'] }}</p>
            @endif

            @if(isset($competitor['strengths']) && is_array($competitor['strengths']))
            <h4>Điểm mạnh:</h4>
            <ul>
                @foreach($competitor['strengths'] as $strength)
                    <li>{{ $strength }}</li>
                @endforeach
            </ul>
            @endif

            @if(isset($competitor['weaknesses']) && is_array($competitor['weaknesses']))
            <h4>Điểm yếu:</h4>
            <ul>
                @foreach($competitor['weaknesses'] as $weakness)
                    <li>{{ $weakness }}</li>
                @endforeach
            </ul>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- Current Market Analysis -->
    @if(isset($data['analysis']))
    <div class="section">
        <h3>PHÂN TÍCH THỊ TRƯỜNG HIỆN TẠI</h3>
        <div class="content">
            {!! nl2br(e($data['analysis'])) !!}
        </div>
    </div>
    @endif

    <!-- Chart Data - Thay thế cho biểu đồ không hiển thị được -->
    @if(isset($data['chart_data']) && isset($data['chart_data']['labels']))
    <div class="section">
        <h3>DỮ LIỆU BIỂU ĐỒ XU HƯỚNG THỊ TRƯỜNG</h3>
        <p style="font-size: 10px; color: #666; margin-bottom: 15px;">(Dữ liệu dùng để tạo biểu đồ xu hướng thị trường)</p>

        @if(isset($data['chart_data']['actual_data']) && isset($data['chart_data']['forecast_data']))
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 10px;">
            <thead>
                <tr style="background-color: #f8fafc;">
                    <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold;">Thời gian</th>
                    <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold;">Dữ liệu thực tế</th>
                    <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold;">Dự báo</th>
                    <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold;">Chỉ số tăng trưởng thị trường</th>
                    <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold;">Mức độ quan tâm người tiêu dùng</th>
                    <th style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; font-weight: bold;">Đánh giá xu hướng</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < count($data['chart_data']['labels']); $i++)
                <tr>
                    <td style="border: 1px solid #e5e7eb; padding: 8px; text-align: center; background-color: #f8fafc; font-weight: bold;">
                        {{ $data['chart_data']['labels'][$i] ?? '' }}
                    </td>
                    <td style="border: 1px solid #e5e7eb; padding: 8px; text-align: center;">
                        {{ ($data['chart_data']['actual_data'][$i] ?? null) !== null ? number_format($data['chart_data']['actual_data'][$i], 1) : '-' }}
                    </td>
                    <td style="border: 1px solid #e5e7eb; padding: 8px; text-align: center;">
                        {{ ($data['chart_data']['forecast_data'][$i] ?? null) !== null ? number_format($data['chart_data']['forecast_data'][$i], 1) : '-' }}
                    </td>
                    <td style="border: 1px solid #e5e7eb; padding: 8px; text-align: center;">
                        {{ isset($data['chart_data']['market_growth_index'][$i]) ? number_format($data['chart_data']['market_growth_index'][$i], 1) : '-' }}
                    </td>
                    <td style="border: 1px solid #e5e7eb; padding: 8px; text-align: center;">
                        {{ isset($data['chart_data']['consumer_interest_index'][$i]) ? number_format($data['chart_data']['consumer_interest_index'][$i], 1) : '-' }}
                    </td>
                    <td style="border: 1px solid #e5e7eb; padding: 8px; text-align: left;">
                        {{ $data['chart_data']['trend_indicators'][$i] ?? '-' }}
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>

        <div style="font-size: 10px; color: #666; margin-top: 10px; padding: 10px; background-color: #f8fafc; border-radius: 6px;">
            <strong>Chú thích:</strong><br>
            • Dữ liệu thực tế: Số liệu đã thu thập được (quá khứ và hiện tại)<br>
            • Dự báo: Số liệu dự đoán cho tương lai<br>
            • Chỉ số tăng trưởng thị trường: Đo lường sự phát triển của thị trường theo thời gian<br>
            • Mức độ quan tâm người tiêu dùng: Chỉ số đo lường sự quan tâm và tìm kiếm của người tiêu dùng
        </div>
        @endif
    </div>
    @endif

    <!-- Emerging Trends -->
    @if(isset($data['emerging_trends']) && is_array($data['emerging_trends']))
    <div class="section">
        <h3>XU HƯỚNG MỚI NỔI</h3>
        @foreach($data['emerging_trends'] as $trend)
        <div class="trend-item impact-{{ strtolower($trend['impact_level'] ?? 'low') }}">
            <h4>{{ $trend['trend'] ?? 'Xu hướng' }}</h4>
            <p><strong>Mức độ ảnh hưởng:</strong> {{ $trend['impact_level'] ?? 'Chưa xác định' }}</p>
            <p><strong>Mô tả:</strong> {{ $trend['description'] ?? '' }}</p>
            <p><strong>Thời gian:</strong> {{ $trend['timeline'] ?? 'Chưa xác định' }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Forecast -->
    @if(isset($data['forecast']))
    <div class="section">
        <h3>DỰ BÁO XU HƯỚNG</h3>
        <div class="content">
            {!! nl2br(e($data['forecast'])) !!}
        </div>
    </div>
    @endif

    <!-- SWOT Analysis -->
    @if(isset($data['swot_analysis']))
    <div class="section">
        <h3>PHÂN TÍCH SWOT</h3>
        <div class="swot-grid">
            <div class="swot-item swot-strengths">
                <h4>Điểm mạnh</h4>
                <ul>
                    @foreach($data['swot_analysis']['strengths'] ?? [] as $strength)
                        <li>{{ $strength }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="swot-item swot-weaknesses">
                <h4>Điểm yếu</h4>
                <ul>
                    @foreach($data['swot_analysis']['weaknesses'] ?? [] as $weakness)
                        <li>{{ $weakness }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="swot-item swot-opportunities">
                <h4>Cơ hội</h4>
                <ul>
                    @foreach($data['swot_analysis']['opportunities'] ?? [] as $opportunity)
                        <li>{{ $opportunity }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="swot-item swot-threats">
                <h4>Thách thức</h4>
                <ul>
                    @foreach($data['swot_analysis']['threats'] ?? [] as $threat)
                        <li>{{ $threat }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Strategic Recommendations -->
    @if(isset($data['recommendations']) && is_array($data['recommendations']))
    <div class="section">
        <h3>KHUYẾN NGHỊ CHIẾN LƯỢC</h3>
        @foreach($data['recommendations'] as $recommendation)
        <div class="recommendation-item priority-{{ strtolower($recommendation['priority'] ?? 'low') }}">
            <h4>{{ $recommendation['category'] ?? '' }} - {{ $recommendation['title'] ?? 'Khuyến nghị' }}</h4>
            <p><strong>Mô tả:</strong> {{ $recommendation['content'] ?? '' }}</p>
            <p><strong>Độ ưu tiên:</strong> {{ $recommendation['priority'] ?? 'Chưa xác định' }}</p>
            <p><strong>Tác động dự kiến:</strong> {{ $recommendation['expected_impact'] ?? '' }}</p>
            <p><strong>Thời gian thực hiện:</strong> {{ $recommendation['timeline'] ?? '' }}</p>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Risk Assessment -->
    @if(isset($data['risk_assessment']))
    <div class="section">
        <h3>ĐÁNH GIÁ RỦI RO</h3>
        <div class="content">
            {!! nl2br(e($data['risk_assessment'])) !!}
        </div>
    </div>
    @endif

    <!-- Data Sources -->
    @if(isset($data['data_sources']))
    <div class="section">
        <h3>NGUỒN DỮ LIỆU</h3>
        <div class="content">
            {{ $data['data_sources'] }}
        </div>
    </div>
    @endif

    <div class="footer">
        <p>Báo cáo được tạo tự động bởi hệ thống AI Marketer Pro</p>
        <p>Thời gian tạo: {{ $generatedAt }}</p>
    </div>
</body>
</html>
