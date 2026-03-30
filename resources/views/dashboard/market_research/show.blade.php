<x-app-dashboard title="Báo cáo: {{ $report->product->name }}">
    <!-- Tailwind Print Utilities can be added natively or inline, here focusing on screen view -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-bold border-b-4 border-primary-500 inline-block pb-2 mb-2 text-gray-900">
                    BÁO CÁO NGHIÊN CỨU THỊ TRƯỜNG
                </h1>
                <p class="text-gray-600 mt-2">Dự án: <strong class="text-primary-700">{{ $report->product->name }}</strong></p>
                <div class="text-sm text-gray-500 mt-1 flex items-center gap-4">
                    <span>Trạng thái: 
                        <span id="report-status-badge" class="{{ $report->status == 'completed' ? 'text-green-600' : 'text-orange-500' }} font-semibold uppercase">
                            {{ $report->status }}
                        </span>
                    </span>
                    <span>Hoàn thành lúc: <span id="completed-time">{{ $report->completed_at ? $report->completed_at->format('d/m/Y H:i') : 'Đang xử lý...' }}</span></span>
                </div>
            </div>
            
            @if($report->status == 'completed')
            <div class="flex gap-3">
                <a href="{{ route('dashboard.market_research.export.word', $report->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Tải Word (DOCX)
                </a>
                <a href="{{ route('dashboard.market_research.export.pdf', $report->id) }}" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Tải PDF
                </a>
            </div>
            @endif
        </div>

        @if($report->status !== 'completed' && $report->status !== 'failed')
        <!-- Progress Bar for ongoing jobs -->
        <div id="progress-container" class="bg-white rounded-xl shadow-lg p-8 mb-8 text-center border border-gray-100">
            <div class="max-w-md mx-auto">
                <div class="mb-4">
                    <svg class="animate-spin h-12 w-12 text-primary-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hệ Thống AI Đang Xử Lý</h3>
                <p id="progress-text" class="text-gray-600 mb-6">{{ $report->current_step ?? 'Đang khởi chạy...' }}</p>
                
                <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
                    <div id="progress-bar" class="bg-primary-600 h-3 rounded-full transition-all duration-500" style="width: {{ $report->progress_percent }}%"></div>
                </div>
                <p class="text-sm font-semibold text-primary-700" id="progress-percentage">{{ $report->progress_percent }}%</p>
                <p class="text-xs text-gray-400 mt-4 italic">Vui lòng không đóng trang này. Báo cáo sẽ tự động hiển thị khi hoàn thành (khoảng 1-3 phút).</p>
            </div>
            
            <script>
                // Polling function
                function checkStatus() {
                    fetch('{{ route("dashboard.market_research.status", $report->id) }}')
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('progress-bar').style.width = data.progress_percent + '%';
                            document.getElementById('progress-percentage').innerText = data.progress_percent + '%';
                            document.getElementById('progress-text').innerText = data.current_step;
                            document.getElementById('report-status-badge').innerText = data.status;
                            
                            if (data.status === 'completed' || data.status === 'failed') {
                                window.location.reload();
                            } else {
                                setTimeout(checkStatus, 3000); // Check every 3s
                            }
                        });
                }
                setTimeout(checkStatus, 3000);
            </script>
        </div>
        @elseif($report->status == 'failed')
        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-lg mb-8">
            <h3 class="text-red-800 font-bold text-xl mb-2">Lỗi xử lý báo cáo</h3>
            <p class="text-red-700">{{ $report->error_message }}</p>
            <p class="mt-4 text-sm text-red-600">Vui lòng thử lại sau.</p>
        </div>
        @else
        <!-- COMPLETED REPORT VIEW -->
        @php
            $qualitative = $report->qualitative_analysis;
            $charts = $report->chart_data;
        @endphp

        <!-- 1. Executive Summary -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8 border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-4 border-l-4 border-primary-500 pl-3">1. TÓM TẮT CHIẾN LƯỢC (EXECUTIVE SUMMARY)</h2>
            <div class="prose max-w-none text-gray-700 leading-relaxed text-justify">
                {{ $qualitative['executive_summary'] ?? 'Không có dữ liệu.' }}
            </div>
        </div>

        <!-- 2. Charts Dashboard (Quantitative) -->
        <div class="mb-8">
             <h2 class="text-xl font-bold text-gray-900 mb-4 border-l-4 border-primary-500 pl-3">2. PHÂN TÍCH DỮ LIỆU ĐỊNH LƯỢNG (QUANTITATIVE DATA)</h2>
             <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                 <!-- Trend Chart -->
                 <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                     <h3 class="text-base font-bold text-gray-800 mb-4 text-center">Dự Báo Xu Hướng Tìm Kiếm (6 Tháng Tới)</h3>
                     <div class="relative h-64 w-full">
                         <canvas id="trendChart"></canvas>
                     </div>
                 </div>
                 
                 <!-- Price Distribution -->
                 <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                     <h3 class="text-base font-bold text-gray-800 mb-4 text-center">Phân Bố Phân Khúc Giá Đối Thủ</h3>
                     <div class="relative h-64 w-full">
                         <canvas id="priceChart"></canvas>
                     </div>
                 </div>

                 <!-- Sentiment Donut -->
                 <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                     <h3 class="text-base font-bold text-gray-800 mb-4 text-center">Phân Tích Cảm Xúc Khách Hàng (Sentiment)</h3>
                     <div class="relative h-64 w-full flex justify-center">
                         <canvas id="sentimentChart"></canvas>
                     </div>
                 </div>
                 
                 <!-- Market Overview Stats -->
                 <div class="bg-gradient-to-br from-primary-50 to-blue-50 rounded-xl shadow-md p-6 border border-primary-100 flex flex-col justify-center">
                      <h3 class="text-base font-bold text-primary-900 mb-4 text-center">Tổng Quan Ngành (Market Size)</h3>
                      <div class="space-y-4">
                          <div class="flex justify-between items-center bg-white p-3 rounded shadow-sm">
                              <span class="text-gray-600 font-medium">Quy mô thị trường:</span>
                              <span class="font-bold text-gray-900">{{ $qualitative['market_overview']['market_size'] ?? 'N/A' }}</span>
                          </div>
                          <div class="flex justify-between items-center bg-white p-3 rounded shadow-sm">
                              <span class="text-gray-600 font-medium">Tốc độ tăng trưởng (CAGR):</span>
                              <span class="font-bold text-green-600">{{ $qualitative['market_overview']['cagr'] ?? 'N/A' }}</span>
                          </div>
                          <div class="flex justify-between items-center bg-white p-3 rounded shadow-sm">
                              <span class="text-gray-600 font-medium">Giai đoạn:</span>
                              <span class="font-bold text-primary-600 uppercase">{{ $qualitative['market_overview']['market_maturity'] ?? 'N/A' }}</span>
                          </div>
                      </div>
                 </div>
             </div>
        </div>

        <!-- 3. SWOT Analysis -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4 border-l-4 border-primary-500 pl-3">3. MA TRẬN SWOT</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-green-50 p-6 rounded-xl border border-green-200 shadow-sm">
                     <h3 class="text-green-800 font-bold text-lg mb-3 flex items-center"><span class="text-2xl mr-2">💪</span> Điểm mạnh (Strengths)</h3>
                     <ul class="list-disc list-inside text-gray-700 space-y-1">
                         @foreach($qualitative['swot_analysis']['strengths'] ?? [] as $item)
                            <li>{{ $item }}</li>
                         @endforeach
                     </ul>
                </div>
                <div class="bg-red-50 p-6 rounded-xl border border-red-200 shadow-sm">
                     <h3 class="text-red-800 font-bold text-lg mb-3 flex items-center"><span class="text-2xl mr-2">⚠️</span> Điểm yếu (Weaknesses)</h3>
                     <ul class="list-disc list-inside text-gray-700 space-y-1">
                         @foreach($qualitative['swot_analysis']['weaknesses'] ?? [] as $item)
                            <li>{{ $item }}</li>
                         @endforeach
                     </ul>
                </div>
                <div class="bg-blue-50 p-6 rounded-xl border border-blue-200 shadow-sm">
                     <h3 class="text-blue-800 font-bold text-lg mb-3 flex items-center"><span class="text-2xl mr-2">🌟</span> Cơ hội (Opportunities)</h3>
                     <ul class="list-disc list-inside text-gray-700 space-y-1">
                         @foreach($qualitative['swot_analysis']['opportunities'] ?? [] as $item)
                            <li>{{ $item }}</li>
                         @endforeach
                     </ul>
                </div>
                <div class="bg-orange-50 p-6 rounded-xl border border-orange-200 shadow-sm">
                     <h3 class="text-orange-800 font-bold text-lg mb-3 flex items-center"><span class="text-2xl mr-2">⚡</span> Thách thức (Threats)</h3>
                     <ul class="list-disc list-inside text-gray-700 space-y-1">
                         @foreach($qualitative['swot_analysis']['threats'] ?? [] as $item)
                            <li>{{ $item }}</li>
                         @endforeach
                     </ul>
                </div>
            </div>
        </div>

        <!-- 4. Strategic Recommendations -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Pricing Strategy -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-4 border-l-4 border-primary-500 pl-3">4. CHIẾN LƯỢC GIÁ</h2>
                <div class="prose max-w-none text-gray-700">
                    <p><strong>Chiến lược đề xuất:</strong> {{ $qualitative['pricing_strategy']['recommended_strategy'] ?? '' }}</p>
                    <p><strong>Khoảng giá khuyến nghị:</strong> <span class="text-green-600 font-bold">{{ $qualitative['pricing_strategy']['recommended_price_range'] ?? '' }}</span></p>
                    <p class="mt-2 text-sm text-gray-600 italic">"{{ $qualitative['pricing_strategy']['rationale'] ?? '' }}"</p>
                    
                    @if(isset($qualitative['pricing_strategy']['pricing_tiers']))
                    <table class="min-w-full mt-4 bg-gray-50 text-sm">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-2 text-left">Phân khúc</th>
                                <th class="p-2 text-left">Mức giá</th>
                                <th class="p-2 text-left">Gói sản phẩm</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($qualitative['pricing_strategy']['pricing_tiers'] as $tier)
                            <tr class="border-b">
                                <td class="p-2 font-medium">{{ $tier['tier'] ?? '' }}</td>
                                <td class="p-2 text-primary-600 font-bold">{{ $tier['price_range'] ?? '' }}</td>
                                <td class="p-2">{{ $tier['products'] ?? '' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>

            <!-- Go to Market -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <h2 class="text-xl font-bold text-gray-900 mb-4 border-l-4 border-primary-500 pl-3">5. GO-TO-MARKET (GTM)</h2>
                <div class="prose max-w-none text-gray-700">
                    <div class="mb-4">
                        <strong>Thông điệp Launch:</strong> 
                        <div class="bg-primary-50 p-3 rounded border border-primary-200 text-primary-800 font-medium italic mt-2">
                            "{{ $qualitative['go_to_market_strategy']['launch_message'] ?? '' }}"
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <strong>Kênh phân phối / Marketing chính:</strong>
                        <ul class="list-disc pl-5 mt-1">
                            @foreach($qualitative['go_to_market_strategy']['primary_channels'] ?? [] as $ch)
                                <li>{{ $ch }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div>
                        <strong>Nội dung chủ đạo (Content Pillars):</strong>
                        <div class="flex flex-wrap gap-2 mt-2">
                            @foreach($qualitative['go_to_market_strategy']['content_pillars'] ?? [] as $cp)
                                <span class="px-3 py-1 bg-gray-100 rounded-full text-xs font-medium text-gray-700">{{ $cp }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 6. Action Plan -->
        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 border-l-4 border-primary-500 pl-3">6. KẾ HOẠCH HÀNH ĐỘNG 90 NGÀY</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                 <!-- Phase 1 -->
                 <div class="relative">
                    <div class="bg-primary-50 rounded-t-lg p-3 border-b-2 border-primary-500 text-center font-bold text-primary-800">Giai đoạn 1 (1 - 30 ngày)</div>
                    <div class="bg-white border border-t-0 p-4 rounded-b-lg shadow-sm h-full">
                        <ul class="space-y-3">
                            @foreach($qualitative['action_plan']['phase_1_30_days'] ?? [] as $task)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-green-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-sm text-gray-700">{{ $task }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                 </div>

                 <!-- Phase 2 -->
                 <div class="relative">
                    <div class="bg-blue-50 rounded-t-lg p-3 border-b-2 border-blue-500 text-center font-bold text-blue-800">Giai đoạn 2 (31 - 60 ngày)</div>
                    <div class="bg-white border border-t-0 p-4 rounded-b-lg shadow-sm h-full">
                        <ul class="space-y-3">
                            @foreach($qualitative['action_plan']['phase_2_60_days'] ?? [] as $task)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <span class="text-sm text-gray-700">{{ $task }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                 </div>

                 <!-- Phase 3 -->
                 <div class="relative">
                    <div class="bg-purple-50 rounded-t-lg p-3 border-b-2 border-purple-500 text-center font-bold text-purple-800">Giai đoạn 3 (61 - 90 ngày)</div>
                    <div class="bg-white border border-t-0 p-4 rounded-b-lg shadow-sm h-full">
                        <ul class="space-y-3">
                            @foreach($qualitative['action_plan']['phase_3_90_days'] ?? [] as $task)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 text-purple-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    <span class="text-sm text-gray-700">{{ $task }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                 </div>
            </div>
        </div>

        <!-- Setup Chart.js Render -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const chartsData = @json($charts);
                
                if (chartsData) {
                    // 1. Trend Line Chart
                    if (chartsData.trend_chart) {
                        new Chart(document.getElementById('trendChart'), {
                            type: chartsData.trend_chart.type,
                            data: {
                                labels: chartsData.trend_chart.labels,
                                datasets: chartsData.trend_chart.datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { position: 'bottom' } }
                            }
                        });
                    }

                    // 2. Price Bar Chart
                    if (chartsData.price_distribution_chart) {
                        new Chart(document.getElementById('priceChart'), {
                            type: chartsData.price_distribution_chart.type,
                            data: {
                                labels: chartsData.price_distribution_chart.labels,
                                datasets: chartsData.price_distribution_chart.datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { display: false } }
                            }
                        });
                    }

                    // 3. Sentiment Donut
                    if (chartsData.sentiment_donut_chart) {
                        new Chart(document.getElementById('sentimentChart'), {
                            type: chartsData.sentiment_donut_chart.type,
                            data: {
                                labels: chartsData.sentiment_donut_chart.labels,
                                datasets: chartsData.sentiment_donut_chart.datasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: { legend: { position: 'right' } }
                            }
                        });
                    }
                }
            });
        </script>
        @endif
    </div>
</x-app-dashboard>
