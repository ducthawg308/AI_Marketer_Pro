{{-- resources/views/research/market-trend.blade.php --}}
<div class="p-6 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-2xl shadow-xl">
    <!-- Header Section -->
    <div class="flex flex-col mb-8 gap-6">
        <!-- Header Section -->
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl mr-4">
                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-3xl md:text-2xl font-bold text-gray-800">Xu hướng thị trường</h2>
                <p class="text-gray-600 text-lg">Phát hiện xu hướng mới nổi và cơ hội đầu tư tiềm năng</p>
            </div>
        </div>

        <!-- Export Actions -->
        <div class="flex flex-col sm:flex-row gap-3 w-full mb-4">
            <div class="flex gap-2">
                <a href="{{ route('dashboard.market_analysis.export', 'pdf') }}"
                   class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414l-5-5H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"/>
                    </svg>
                    Xuất PDF
                </a>
                <a href="{{ route('dashboard.market_analysis.export', 'word') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"/>
                    </svg>
                    Xuất Word
                </a>
            </div>
            <p class="text-sm text-gray-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Xuất báo cáo từ kết quả phân tích hiện tại
            </p>
        </div>

        <!-- Market Overview Stats -->
        <div class="flex flex-col sm:flex-row gap-4 w-full">
            <div class="bg-white/80 backdrop-blur-sm rounded-xl px-6 py-4 shadow-lg border border-white/20">
                <p class="text-sm font-medium text-gray-500 mb-1">Quy mô thị trường</p>
                <p class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    {{ $data['data']['market_size'] ?? 'N/A' }}
                </p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-xl px-6 py-4 shadow-lg border border-white/20">
                <p class="text-sm font-medium text-gray-500 mb-1">Tăng trưởng/năm</p>
                <p class="text-xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                    {{ $data['data']['growth_rate'] ?? 'N/A' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Market Trend Chart - Full Width -->
    <div class="mb-8">
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Biểu đồ xu hướng thị trường</h3>
                    <p class="text-gray-600 text-sm">Dữ liệu thực tế và dự báo xu hướng tương lai</p>
                </div>
                <div class="flex flex-wrap gap-4">
                    <div class="flex items-center bg-blue-50 px-3 py-2 rounded-lg">
                        <div class="w-4 h-4 bg-gradient-to-r from-blue-500 to-blue-600 rounded-full mr-2"></div>
                        <span class="text-sm font-medium text-blue-700">Dữ liệu thực tế</span>
                    </div>
                    <div class="flex items-center bg-red-50 px-3 py-2 rounded-lg">
                        <div class="w-4 h-4 bg-gradient-to-r from-red-500 to-red-600 rounded-full mr-2"></div>
                        <span class="text-sm font-medium text-red-700">Dự báo</span>
                    </div>
                </div>
            </div>

    <!-- Chart Container with full width -->
    <div class="relative bg-gradient-to-br from-gray-50 to-white rounded-xl p-4 border">
        <canvas id="marketTrendChart" style="height: 450px; width: 100%;"></canvas>

        <!-- Chart data as JSON for AJAX loading -->
        <script type="application/json" id="chartDataJson">
            {!! json_encode($data['data']['chart_data'] ?? []) !!}
        </script>
    </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 gap-8">
        <!-- Left Column: Trends -->
        <div class="space-y-8">
            <!-- Emerging Trends - Enhanced design -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="bg-gradient-to-r from-orange-400 to-red-500 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    Xu hướng mới nổi
                </h3>

                @if(isset($data['data']['emerging_trends']) && is_array($data['data']['emerging_trends']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($data['data']['emerging_trends'] as $trend)
                        <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="font-bold text-gray-800 text-lg">{{ $trend['trend'] ?? 'Xu hướng' }}</h4>
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    {{ ($trend['impact_level'] ?? '') === 'Cao' ? 'bg-gradient-to-r from-red-100 to-red-200 text-red-800' :
                                    (($trend['impact_level'] ?? '') === 'Trung bình' ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800' : 'bg-gradient-to-r from-green-100 to-green-200 text-green-800') }}">
                                    {{ $trend['impact_level'] ?? 'Chưa xác định' }}
                                </span>
                            </div>
                            <p class="text-gray-600 mb-4 leading-relaxed">{{ $trend['description'] ?? '' }}</p>
                            <div class="flex items-center text-blue-600 font-medium">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                {{ $trend['timeline'] ?? 'Chưa xác định' }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 italic">Chưa có dữ liệu xu hướng mới nổi</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: SWOT Analysis -->
        <div class="space-y-8">
            <!-- SWOT Analysis - Enhanced layout -->
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    Phân tích SWOT
                </h3>

                @if(isset($data['data']['swot_analysis']))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Strengths -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-6">
                        <h4 class="font-bold text-green-800 mb-4 flex items-center text-lg">
                            <div class="bg-green-500 rounded-lg p-1 mr-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            Điểm mạnh
                        </h4>
                        <ul class="space-y-2">
                            @foreach($data['data']['swot_analysis']['strengths'] ?? [] as $strength)
                                <li class="flex items-start text-green-700">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                    <span>{{ $strength }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Weaknesses -->
                    <div class="bg-gradient-to-br from-red-50 to-pink-50 border-2 border-red-200 rounded-xl p-6">
                        <h4 class="font-bold text-red-800 mb-4 flex items-center text-lg">
                            <div class="bg-red-500 rounded-lg p-1 mr-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            Điểm yếu
                        </h4>
                        <ul class="space-y-2">
                            @foreach($data['data']['swot_analysis']['weaknesses'] ?? [] as $weakness)
                                <li class="flex items-start text-red-700">
                                    <div class="w-2 h-2 bg-red-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                    <span>{{ $weakness }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Opportunities -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 border-2 border-blue-200 rounded-xl p-6">
                        <h4 class="font-bold text-blue-800 mb-4 flex items-center text-lg">
                            <div class="bg-blue-500 rounded-lg p-1 mr-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            Cơ hội
                        </h4>
                        <ul class="space-y-2">
                            @foreach($data['data']['swot_analysis']['opportunities'] ?? [] as $opportunity)
                                <li class="flex items-start text-blue-700">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                    <span>{{ $opportunity }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Threats -->
                    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 border-2 border-yellow-200 rounded-xl p-6">
                        <h4 class="font-bold text-yellow-800 mb-4 flex items-center text-lg">
                            <div class="bg-yellow-500 rounded-lg p-1 mr-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            Thách thức
                        </h4>
                        <ul class="space-y-2">
                            @foreach($data['data']['swot_analysis']['threats'] ?? [] as $threat)
                                <li class="flex items-start text-yellow-700">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                    <span>{{ $threat }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @else
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 italic">Chưa có dữ liệu phân tích SWOT</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Analysis Row - Nhận định, Dự đoán, Đánh giá rủi ro -->
    <div class="mt-8 grid grid-cols-1 gap-8">
        <!-- Market Analysis -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                Nhận định thị trường
            </h3>
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 text-gray-700 leading-relaxed">
                {!! nl2br(e($data['data']['analysis'] ?? 'Chưa có dữ liệu phân tích')) !!}
            </div>
        </div>

        <!-- Forecast -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                Dự đoán xu hướng
            </h3>
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 text-gray-700 leading-relaxed">
                {!! nl2br(e($data['data']['forecast'] ?? 'Chưa có dữ liệu dự báo')) !!}
            </div>
        </div>

        <!-- Risk Assessment -->
        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
            <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                <div class="bg-gradient-to-r from-orange-500 to-red-600 p-2 rounded-lg mr-3">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                Đánh giá rủi ro
            </h3>
            <div class="bg-gradient-to-r from-orange-50 to-red-50 border border-orange-200 rounded-xl p-6 text-gray-700 leading-relaxed">
                {!! nl2br(e($data['data']['risk_assessment'] ?? 'Chưa có dữ liệu đánh giá rủi ro')) !!}
            </div>
        </div>
    </div>

    <!-- AI Predictive Analytics Section -->
    @if(isset($data['data']['predictive_analytics']))
    <div class="mt-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-8 flex items-center">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-xl mr-4">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M14.828 14.828a1 1 0 01-1.414 0L12 13.414l-1.414 1.414a1 1 0 11-1.414-1.414L10.586 12 9.172 10.586a1 1 0 101.414 1.414L12 13.414l1.414-1.414a1 1 0 011.414 1.414L13.414 14zM2 4a2 2 0 012-2h12a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V4zm4 6a2 2 0 012-2h4a2 2 0 012 2v2a2 2 0 01-2 2H8a2 2 0 01-2-2v-2z" clip-rule="evenodd"/>
                </svg>
            </div>
            AI Predictive Analytics
        </h3>

        <div class="grid grid-cols-1 gap-8">
            <!-- Forecasting Results -->
            @if(isset($data['data']['predictive_analytics']['forecast']))
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
                <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="bg-gradient-to-r from-cyan-500 to-teal-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    Dự báo xu hướng 2-3 tháng tới
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($data['data']['predictive_analytics']['forecast']['dates'] ?? [] as $index => $date)
                    <div class="bg-gradient-to-br from-cyan-50 to-teal-50 border border-cyan-200 rounded-xl p-4">
                        <h5 class="font-semibold text-cyan-800 mb-2">{{ $date }}</h5>
                        <div class="space-y-1">
                            <p class="text-sm text-cyan-700">Giá trị dự báo:
                                <span class="font-bold">
                                    {{ number_format($data['data']['predictive_analytics']['forecast']['predicted_values'][$index] ?? 0, 2) }}
                                </span>
                            </p>
                            <p class="text-sm text-cyan-600">Khoảng tin cậy:
                                <span class="font-medium">
                                    {{ number_format($data['data']['predictive_analytics']['forecast']['lower_bounds'][$index] ?? 0, 2) }} -
                                    {{ number_format($data['data']['predictive_analytics']['forecast']['upper_bounds'][$index] ?? 0, 2) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <p class="text-blue-800 font-medium">
                        Xu hướng tăng trưởng dự kiến:
                        <span class="{{ ($data['data']['predictive_analytics']['forecast']['growth_trend'] ?? 0) > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ number_format(($data['data']['predictive_analytics']['forecast']['growth_trend'] ?? 0) * 100, 2) }}%
                        </span>
                    </p>
                </div>
            </div>
            @endif

            <!-- Opportunity Scores by Demographics -->
            @if(isset($data['data']['predictive_analytics']['opportunity_scores']))
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
                <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    Điểm số cơ hội theo nhóm tuổi (AI Phân tích)
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach($data['data']['predictive_analytics']['opportunity_scores'] ?? [] as $segment => $score)
                    @php
                        $bgColor = $score >= 90 ? 'from-green-100 to-green-200 border-green-300' :
                                  ($score >= 80 ? 'from-blue-100 to-blue-200 border-blue-300' :
                                  ($score >= 70 ? 'from-yellow-100 to-yellow-200 border-yellow-300' :
                                  'from-red-100 to-red-200 border-red-300'));
                        $textColor = $score >= 90 ? 'text-green-800' :
                                    ($score >= 80 ? 'text-blue-800' :
                                    ($score >= 70 ? 'text-yellow-800' : 'text-red-800'));
                    @endphp
                    <div class="bg-gradient-to-br {{ $bgColor }} border rounded-xl p-4 text-center">
                        <h5 class="font-bold {{ $textColor }} mb-2">{{ $segment }}</h5>
                        <div class="text-2xl font-bold {{ $textColor }}">{{ $score }}</div>
                        <div class="mt-1">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-current {{ $textColor }} h-2 rounded-full" style="width: {{ $score }}%"></div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-1">Điểm cơ hội</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Top Opportunity Segments -->
            @if(isset($data['data']['predictive_analytics']['top_segments']) && !empty($data['data']['predictive_analytics']['top_segments']))
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border border-white/20">
                <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <div class="bg-gradient-to-r from-amber-500 to-orange-600 p-2 rounded-lg mr-3">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    Nhóm khách hàng tiềm năng nhất
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($data['data']['predictive_analytics']['top_segments'] as $segment)
                    <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="font-bold text-amber-800 text-lg">{{ $segment['segment'] ?? 'Segment' }}</h5>
                            <span class="px-3 py-1 bg-amber-200 text-amber-800 rounded-full font-semibold">
                                #{{ $segment['rank'] ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-amber-700">{{ $segment['timeline'] ?? 'Trong 2-3 tháng tới' }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 00-1.414 1.414L9 10.586V13a1 1 0 102 0v-2.414l1.293-1.293a1 1 0 001.414 1.414z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-sm text-amber-700">{{ $segment['impact'] ?? 'Tăng tỷ lệ chuyển đổi' }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Data Sources -->
    @if(isset($data['data']['data_sources']))
    <div class="mt-8 p-6 bg-white/60 backdrop-blur-sm rounded-xl border border-white/30">
        <div class="flex items-center mb-2">
            <svg class="w-5 h-5 text-gray-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
            </svg>
            <span class="font-semibold text-gray-700">Nguồn dữ liệu</span>
        </div>
        <p class="text-sm text-gray-600">{{ $data['data']['data_sources'] }}</p>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('marketTrendChart');
        if (!ctx) {
            console.error('Canvas element with id "marketTrendChart" not found');
            return;
        }

        // Ensure Chart.js is loaded
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded');
            return;
        }

        try {
            // Safely get chart data with fallbacks
            const chartData = {!! json_encode($data['data']['chart_data'] ?? []) !!};

            if (!chartData || typeof chartData !== 'object') {
                console.error('Chart data is missing or invalid');
                return;
            }

            const labels = chartData.labels || [];
            const marketGrowth = chartData.market_growth_index || [];
            const consumerInterest = chartData.consumer_interest_index || [];
            const actualData = chartData.actual_data || [];
            const forecastData = chartData.forecast_data || [];
            const trendIndicators = chartData.trend_indicators || [];

            console.log('Chart data loaded:', {
                labels: labels.length,
                marketGrowth: marketGrowth.length,
                consumerInterest: consumerInterest.length,
                actual: actualData.length,
                forecast: forecastData.length,
                indicators: trendIndicators.length
            });

            if (labels.length === 0) {
                console.error('No chart labels found');
                return;
            }

            // Get 2D context
            const chartCtx = ctx.getContext('2d');

            // Create gradients
            const growthGradient = chartCtx.createLinearGradient(0, 0, 0, 400);
            growthGradient.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
            growthGradient.addColorStop(1, 'rgba(34, 197, 94, 0.05)');

            const interestGradient = chartCtx.createLinearGradient(0, 0, 0, 400);
            interestGradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
            interestGradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

            // Prepare combined dataset with actual/forecast logic
            const marketGrowthDataset = [];
            const consumerInterestDataset = [];

            // Combine actual and forecast data for each index
            labels.forEach((label, index) => {
                // For market growth - use actual data if available, forecast if not
                const growthValue = actualData[index] !== undefined && actualData[index] !== null
                    ? actualData[index]
                    : (forecastData[index] !== undefined ? forecastData[index] : marketGrowth[index]);

                marketGrowthDataset.push({
                    x: index,
                    y: growthValue,
                    label: label,
                    isForecast: forecastData[index] !== undefined && forecastData[index] !== null,
                    indicator: trendIndicators[index] || ''
                });

                // Consumer interest data
                consumerInterestDataset.push({
                    x: index,
                    y: consumerInterest[index],
                    label: label,
                    isForecast: false,
                    indicator: trendIndicators[index] || ''
                });
            });

            // Create chart
            new Chart(chartCtx, {
                type: 'line',
                data:
