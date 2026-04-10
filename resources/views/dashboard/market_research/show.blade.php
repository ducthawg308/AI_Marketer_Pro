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
            <span id="report-status-badge"
              class="{{ $report->status == 'completed' ? 'text-green-600' : 'text-orange-500' }} font-semibold uppercase">
              {{ $report->status }}
            </span>
          </span>
          <span>Hoàn thành lúc: <span
              id="completed-time">{{ $report->completed_at ? $report->completed_at->format('d/m/Y H:i') : 'Đang xử lý...' }}</span></span>
        </div>
      </div>

      @if($report->status == 'completed')
        <div class="flex gap-3">
          <a href="{{ route('dashboard.market_research.export.word', $report->id) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
            Tải Word (DOCX)
          </a>
          <a href="{{ route('dashboard.market_research.export.pdf', $report->id) }}"
            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
              </path>
            </svg>
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
            <svg class="animate-spin h-12 w-12 text-primary-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
              </path>
            </svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-2">Hệ Thống AI Đang Xử Lý</h3>
          <p id="progress-text" class="text-gray-600 mb-6">{{ $report->current_step ?? 'Đang khởi chạy...' }}</p>

          <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
            <div id="progress-bar" class="bg-primary-600 h-3 rounded-full transition-all duration-500"
              style="width: {{ $report->progress_percent }}%"></div>
          </div>
          <p class="text-sm font-semibold text-primary-700" id="progress-percentage">{{ $report->progress_percent }}%</p>
          <p class="text-xs text-gray-400 mt-4 italic">Vui lòng không đóng trang này. Báo cáo sẽ tự động hiển thị khi hoàn
            thành (khoảng 1-3 phút).</p>
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
        <h2 class="text-xl font-bold text-gray-900 mb-4 border-l-4 border-primary-500 pl-3">1. TÓM TẮT CHIẾN LƯỢC
          (EXECUTIVE SUMMARY)</h2>
        <div class="prose max-w-none text-gray-700 leading-relaxed text-justify">
          {{ $qualitative['executive_summary'] ?? 'Không có dữ liệu.' }}
        </div>
      </div>

      <!-- 2. Charts Dashboard (Quantitative) -->
      <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6 border-l-4 border-primary-500 pl-3 uppercase tracking-tight">2.
          PHÂN TÍCH DỮ LIỆU ĐỊNH LƯỢNG (QUANTITATIVE DATA)</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
          <!-- Trend Chart - Full Row -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <div class="flex items-center gap-2 mb-4">
              <div class="p-1.5 bg-indigo-100 text-indigo-600 rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                </svg>
              </div>
              <h3 class="font-bold text-gray-800 text-lg">Dự Báo Xu Hướng Tìm Kiếm 6 Tháng Tới</h3>
            </div>
            <div class="relative h-80 w-full mb-4">
              <canvas id="trendChart"></canvas>
            </div>
            <div class="bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
              <p class="text-sm text-indigo-900 leading-relaxed italic">
                💡 <strong>Gợi ý:</strong> Biểu đồ này giúp bạn xác định nhịp độ thị trường. Vùng dự báo (nét đứt) cho
                biết sức mua có khả năng tăng trưởng hay bão hòa trong ngắn hạn để tối ưu ngân sách quảng cáo.
              </p>
            </div>
          </div>

          <!-- Price Distribution -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col lg:col-span-2">
            <div class="flex items-center gap-2 mb-6">
              <div class="p-1.5 bg-emerald-100 text-emerald-600 rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                  </path>
                </svg>
              </div>
              <h3 class="font-bold text-gray-800 text-lg">Phân Bố Phân Khúc Giá Đối Thủ & Định Vị (Google Shopping)</h3>
            </div>

            @php
              $price = $report->quantitative_analysis['price_analysis'] ?? null;
            @endphp

            @if($price)
              <!-- 1. Core Price Metrics Row -->
              <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="p-4 bg-emerald-50 rounded-xl border border-emerald-100">
                  <span class="text-xs text-emerald-700 font-bold uppercase block mb-1">Giá Sàn (Min)</span>
                  <span
                    class="text-lg font-extrabold text-emerald-900">{{ number_format($price['market_price_min'], 0, ',', '.') }}đ</span>
                </div>
                <div class="p-4 bg-rose-50 rounded-xl border border-rose-100">
                  <span class="text-xs text-rose-700 font-bold uppercase block mb-1">Giá Trần (Max)</span>
                  <span
                    class="text-lg font-extrabold text-rose-900">{{ number_format($price['market_price_max'], 0, ',', '.') }}đ</span>
                </div>
                <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                  <span class="text-xs text-indigo-700 font-bold uppercase block mb-1">Giá Trình Bình (Avg)</span>
                  <span
                    class="text-lg font-extrabold text-indigo-900">{{ number_format($price['market_price_avg'], 0, ',', '.') }}đ</span>
                </div>
                <div class="p-4 bg-amber-50 rounded-xl border border-amber-100">
                  <span class="text-xs text-amber-700 font-bold uppercase block mb-1">Trung Vị (Median)</span>
                  <span
                    class="text-lg font-extrabold text-amber-900">{{ number_format($price['market_price_median'], 0, ',', '.') }}đ</span>
                </div>
              </div>

              <!-- 2. Chart Section -->
              <div class="mb-6">
                <h4 class="text-sm font-bold text-gray-700 mb-4 px-1 uppercase tracking-wider">Cấu trúc thị trường & Phân bổ
                  phân khúc giá</h4>
                <div class="relative h-72 w-full bg-gray-50/30 rounded-xl p-4 border border-gray-100">
                  <canvas id="priceChart"></canvas>
                </div>
              </div>

              <!-- 3. Insights/Rationale footer -->
              <div class="bg-emerald-50/50 p-4 rounded-xl border border-emerald-100">
                <p class="text-sm text-emerald-900 leading-relaxed italic">
                  💡 <strong>Gợi ý:</strong> Thị trường đang tập trung ở phân khúc
                  <strong>{{ collect($price['price_segments'])->sortByDesc('count')->keys()->first() == 'mid_range' ? 'Trung cấp' : (collect($price['price_segments'])->sortByDesc('count')->keys()->first() == 'budget' ? 'Giá rẻ' : 'Cao cấp') }}</strong>.
                  Hãy so sánh giá đề xuất của bạn với các đối thủ trên để xác định mức lợi nhuận tối ưu.
                </p>
              </div>
            @endif
          </div>

          <!-- Sentiment Donut -->
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col lg:col-span-2">
            <div class="flex items-center gap-2 mb-4">
              <div class="p-1.5 bg-rose-100 text-rose-600 rounded">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
              </div>
              <h3 class="font-bold text-gray-800 text-lg">Phân Tích Cảm Xúc Khách Hàng (Sentiment)</h3>
            </div>
            <div class="relative h-64 w-full flex justify-center mb-4">
              <canvas id="sentimentChart"></canvas>
            </div>
            <div class="bg-rose-50/50 p-4 rounded-xl border border-rose-100 flex-1">
              <p class="text-sm text-rose-900 leading-relaxed italic">
                💡 <strong>Gợi ý:</strong> Tỉ lệ cảm xúc tiêu cực là kho báu để tìm ra sai lầm của đối thủ. Hãy xoáy sâu
                vào các điểm khách hàng không hài lòng để làm nổi bật sản phẩm của bạn.
              </p>
            </div>
          </div>

          <!-- Market Overview Stats -->
          <div
            class="bg-gradient-to-br from-primary-50 to-blue-50 rounded-2xl shadow-sm p-8 border border-primary-100 lg:col-span-2 flex flex-col justify-center">
            <h3 class="text-lg font-bold text-primary-900 mb-6 text-center uppercase tracking-widest">Tổng Quan Ngành
              (Market Size)</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div class="bg-white p-6 rounded-xl shadow-sm border border-primary-50 flex flex-col items-center">
                <span class="text-gray-500 text-xs font-bold uppercase mb-2">Quy mô thị trường</span>
                <span class="text-xl text-gray-900">{{ $qualitative['market_overview']['market_size'] ?? 'N/A' }}</span>
              </div>
              <div class="bg-white p-6 rounded-xl shadow-sm border border-primary-50 flex flex-col items-center">
                <span class="text-gray-500 text-xs font-bold uppercase mb-2">Tăng trưởng (CAGR)</span>
                <span class="text-xl text-green-600">{{ $qualitative['market_overview']['cagr'] ?? 'N/A' }}</span>
              </div>
              <div class="bg-white p-6 rounded-xl shadow-sm border border-primary-50 flex flex-col items-center">
                <span class="text-gray-500 text-xs font-bold uppercase mb-2">Giai đoạn</span>
                <span
                  class="text-xl text-primary-600 uppercase">{{ $qualitative['market_overview']['market_maturity'] ?? 'N/A' }}</span>
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
            <h3 class="text-green-800 font-bold text-lg mb-3 flex items-center"><span class="text-2xl mr-2">💪</span> Điểm
              mạnh (Strengths)</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
              @foreach($qualitative['swot_analysis']['strengths'] ?? [] as $item)
                <li>{{ $item }}</li>
              @endforeach
            </ul>
          </div>
          <div class="bg-red-50 p-6 rounded-xl border border-red-200 shadow-sm">
            <h3 class="text-red-800 font-bold text-lg mb-3 flex items-center"><span class="text-2xl mr-2">⚠️</span> Điểm
              yếu (Weaknesses)</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
              @foreach($qualitative['swot_analysis']['weaknesses'] ?? [] as $item)
                <li>{{ $item }}</li>
              @endforeach
            </ul>
          </div>
          <div class="bg-blue-50 p-6 rounded-xl border border-blue-200 shadow-sm">
            <h3 class="text-blue-800 font-bold text-lg mb-3 flex items-center"><span class="text-2xl mr-2">🌟</span> Cơ
              hội (Opportunities)</h3>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
              @foreach($qualitative['swot_analysis']['opportunities'] ?? [] as $item)
                <li>{{ $item }}</li>
              @endforeach
            </ul>
          </div>
          <div class="bg-orange-50 p-6 rounded-xl border border-orange-200 shadow-sm">
            <h3 class="text-orange-800 font-bold text-lg mb-3 flex items-center"><span class="text-2xl mr-2">⚡</span>
              Thách thức (Threats)</h3>
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
            <p><strong>Chiến lược đề xuất:</strong> {{ $qualitative['pricing_strategy']['recommended_strategy'] ?? '' }}
            </p>
            <p><strong>Khoảng giá khuyến nghị:</strong> <span
                class="text-green-600 font-bold">{{ $qualitative['pricing_strategy']['recommended_price_range'] ?? '' }}</span>
            </p>
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
        <h2 class="text-xl font-bold text-gray-900 mb-6 border-l-4 border-primary-500 pl-3">6. KẾ HOẠCH HÀNH ĐỘNG 90 NGÀY
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Phase 1 -->
          <div class="relative">
            <div
              class="bg-primary-50 rounded-t-lg p-3 border-b-2 border-primary-500 text-center font-bold text-primary-800">
              Giai đoạn 1 (1 - 30 ngày)</div>
            <div class="bg-white border border-t-0 p-4 rounded-b-lg shadow-sm h-full">
              <ul class="space-y-3">
                @foreach($qualitative['action_plan']['phase_1_30_days'] ?? [] as $task)
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-green-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm text-gray-700">{{ $task }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>

          <!-- Phase 2 -->
          <div class="relative">
            <div class="bg-blue-50 rounded-t-lg p-3 border-b-2 border-blue-500 text-center font-bold text-blue-800">Giai
              đoạn 2 (31 - 60 ngày)</div>
            <div class="bg-white border border-t-0 p-4 rounded-b-lg shadow-sm h-full">
              <ul class="space-y-3">
                @foreach($qualitative['action_plan']['phase_2_60_days'] ?? [] as $task)
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                      </path>
                    </svg>
                    <span class="text-sm text-gray-700">{{ $task }}</span>
                  </li>
                @endforeach
              </ul>
            </div>
          </div>

          <!-- Phase 3 -->
          <div class="relative">
            <div class="bg-purple-50 rounded-t-lg p-3 border-b-2 border-purple-500 text-center font-bold text-purple-800">
              Giai đoạn 3 (61 - 90 ngày)</div>
            <div class="bg-white border border-t-0 p-4 rounded-b-lg shadow-sm h-full">
              <ul class="space-y-3">
                @foreach($qualitative['action_plan']['phase_3_90_days'] ?? [] as $task)
                  <li class="flex items-start">
                    <svg class="w-5 h-5 text-purple-500 mr-2 shrink-0" fill="none" stroke="currentColor"
                      viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
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
        document.addEventListener('DOMContentLoaded', function () {
          const chartsData = @json($charts);

          if (chartsData) {
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.color = '#64748b';

            // 1. Trend Line Chart
            if (chartsData.trend_chart) {
              const ctx = document.getElementById('trendChart').getContext('2d');
              const gradient = ctx.createLinearGradient(0, 0, 0, 400);
              gradient.addColorStop(0, 'rgba(99, 102, 241, 0.4)');
              gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

              new Chart(ctx, {
                type: 'line',
                data: {
                  labels: chartsData.trend_chart.labels,
                  datasets: chartsData.trend_chart.datasets.map(ds => ({
                    ...ds,
                    tension: 0.3,
                    fill: ds.label === 'Dự báo xu hướng' ? false : true,
                    backgroundColor: ds.label === 'Dự báo xu hướng' ? 'transparent' : gradient,
                    pointRadius: 0, // Ẩn các điểm chấm để mượt hơn
                    pointHoverRadius: 6,
                    borderWidth: 2
                  }))
                },
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  interaction: { intersect: false, mode: 'index' },
                  plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25 } },
                    tooltip: {
                      backgroundColor: 'rgba(255, 255, 255, 0.9)',
                      titleColor: '#1e293b',
                      bodyColor: '#475569',
                      borderColor: '#e2e8f0',
                      borderWidth: 1,
                      padding: 12,
                      displayColors: true,
                      callbacks: {
                        label: function (context) {
                          return ` ${context.dataset.label}: ${context.parsed.y} điểm`;
                        }
                      }
                    }
                  },
                  scales: {
                    y: {
                      beginAtZero: true,
                      grid: { color: '#f1f5f9', display: true }, // Hiện lưới ngang
                      title: { display: true, text: 'Mức độ quan tâm' }
                    },
                    x: {
                      grid: { color: '#f1f5f9', display: true }, // Hiện lưới dọc
                      ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 12 }
                    }
                  }
                }
              });
            }

            // 2. Price Bar Chart
            if (chartsData.price_distribution_chart) {
              new Chart(document.getElementById('priceChart'), {
                type: 'bar',
                data: {
                  labels: ['Giá rẻ', 'Tầm trung', 'Cao cấp'],
                  datasets: chartsData.price_distribution_chart.datasets.map(ds => ({
                    ...ds,
                    borderRadius: 8,
                    maxBarThickness: 50
                  }))
                },
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                    legend: { display: false },
                    tooltip: {
                      callbacks: {
                        label: function (context) { return ` Số lượng: ${context.parsed.y} sản phẩm đối thủ`; }
                      }
                    }
                  },
                  scales: {
                    y: { beginAtZero: true, grid: { borderDash: [2, 2] }, title: { display: true, text: 'Số lượng sản phẩm' } },
                    x: { grid: { display: false } }
                  }
                }
              });
            }

            // 3. Sentiment Donut
            if (chartsData.sentiment_donut_chart) {
              new Chart(document.getElementById('sentimentChart'), {
                type: 'doughnut',
                data: {
                  labels: ['Tích cực', 'Trung lập', 'Tiêu cực'],
                  datasets: chartsData.sentiment_donut_chart.datasets.map(ds => ({
                    ...ds,
                    cutout: '65%',
                    hoverOffset: 15,
                    borderWidth: 0
                  }))
                },
                options: {
                  responsive: true,
                  maintainAspectRatio: false,
                  plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } },
                    tooltip: {
                      padding: 12,
                      callbacks: {
                        label: function (context) {
                          const total = context.dataset.data.reduce((a, b) => a + b, 0);
                          const val = context.parsed;
                          const pct = ((val / total) * 100).toFixed(1);
                          return ` ${context.label}: ${val} phản hồi (${pct}%)`;
                        }
                      }
                    }
                  }
                }
              });
            }
          }
        });
      </script>
    @endif
  </div>
</x-app-dashboard>