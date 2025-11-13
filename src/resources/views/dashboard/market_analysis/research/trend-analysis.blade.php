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

    <!-- Strategic Recommendations - Full width enhanced section -->
    @if(isset($data['data']['recommendations']) && is_array($data['data']['recommendations']))
    <div class="mt-12">
        <h3 class="text-2xl font-bold text-gray-800 mb-8 flex items-center">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-xl mr-4">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                </svg>
            </div>
            Khuyến nghị chiến lược
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($data['data']['recommendations'] as $recommendation)
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-xl p-8 border-l-4 border-purple-500 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center justify-between mb-6">
                    <span class="px-4 py-2 text-sm font-bold rounded-full 
                        {{ ($recommendation['category'] ?? '') === 'Ngắn hạn' ? 'bg-gradient-to-r from-red-100 to-red-200 text-red-800' : 
                        (($recommendation['category'] ?? '') === 'Trung hạn' ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800' : 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800') }}">
                        {{ $recommendation['category'] ?? 'Chưa phân loại' }}
                    </span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                        {{ ($recommendation['priority'] ?? '') === 'Cao' ? 'bg-gradient-to-r from-red-100 to-red-200 text-red-800' : 
                        (($recommendation['priority'] ?? '') === 'Trung bình' ? 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800' : 'bg-gradient-to-r from-green-100 to-green-200 text-green-800') }}">
                        {{ $recommendation['priority'] ?? 'Chưa xác định' }}
                    </span>
                </div>
                
                <h4 class="font-bold text-gray-800 mb-4 text-lg">{{ $recommendation['title'] ?? 'Khuyến nghị' }}</h4>
                <p class="text-gray-600 mb-6 leading-relaxed">{{ $recommendation['content'] ?? '' }}</p>
                
                @if(isset($recommendation['expected_impact']))
                <div class="bg-blue-50 rounded-lg p-3 mb-3">
                    <div class="flex items-center text-blue-700 font-medium mb-1">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
                        </svg>
                        Tác động dự kiến
                    </div>
                    <p class="text-sm text-blue-600">{{ $recommendation['expected_impact'] }}</p>
                </div>
                @endif
                
                @if(isset($recommendation['timeline']))
                <div class="bg-gray-50 rounded-lg p-3">
                    <div class="flex items-center text-gray-700 font-medium mb-1">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        Thời gian thực hiện
                    </div>
                    <p class="text-sm text-gray-600">{{ $recommendation['timeline'] }}</p>
                </div>
                @endif
            </div>
            @endforeach
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
        if (!ctx) return;
        
        const chartData = {!! json_encode($data['data']['chart_data'] ?? []) !!};
        const labels = chartData.labels || [];
        const actualData = chartData.actual_data || [];
        const forecastData = chartData.forecast_data || [];
        
        // Combine datasets properly for better visualization
        const combinedActual = actualData.map((value, index) => 
            forecastData[index] === null ? value : null
        );
        const combinedForecast = forecastData.map((value, index) => 
            value !== null ? value : null
        );
        
        // Create gradient for actual data
        const actualGradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        actualGradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
        actualGradient.addColorStop(1, 'rgba(59, 130, 246, 0.02)');
        
        // Create gradient for forecast data
        const forecastGradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
        forecastGradient.addColorStop(0, 'rgba(239, 68, 68, 0.2)');
        forecastGradient.addColorStop(1, 'rgba(239, 68, 68, 0.02)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Dữ liệu thực tế',
                        data: combinedActual,
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: actualGradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3
                    },
                    {
                        label: 'Dự báo',
                        data: combinedForecast,
                        borderColor: 'rgba(239, 68, 68, 1)',
                        backgroundColor: forecastGradient,
                        borderWidth: 3,
                        borderDash: [10, 5],
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: 'rgba(239, 68, 68, 1)',
                        pointHoverBorderColor: '#ffffff',
                        pointHoverBorderWidth: 3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    title: {
                        display: false
                    },
                    legend: {
                        display: false // We're using custom legend above the chart
                    },
                    tooltip: {
                        enabled: true,
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.9)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        displayColors: true,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        padding: 12,
                        caretPadding: 8,
                        callbacks: {
                            title: function(context) {
                                return 'Thời điểm: ' + context[0].label;
                            },
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('vi-VN', {
                                        style: 'decimal',
                                        minimumFractionDigits: 0,
                                        maximumFractionDigits: 2
                                    }).format(context.parsed.y);
                                }
                                return label;
                            },
                            afterBody: function(context) {
                                if (context.length > 0) {
                                    const dataIndex = context[0].dataIndex;
                                    if (forecastData[dataIndex] !== null) {
                                        return ['', '⚠️ Dữ liệu dự báo - có thể thay đổi'];
                                    }
                                }
                                return [];
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Thời gian',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: '#374151'
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                            font: {
                                size: 12
                            },
                            color: '#6B7280',
                            padding: 8
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Giá trị chỉ số',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: '#374151'
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                return new Intl.NumberFormat('vi-VN', {
                                    notation: 'compact',
                                    compactDisplay: 'short'
                                }).format(value);
                            },
                            font: {
                                size: 12
                            },
                            color: '#6B7280',
                            padding: 8
                        },
                        border: {
                            display: false
                        },
                        beginAtZero: false
                    }
                },
                elements: {
                    point: {
                        hoverBackgroundColor: 'rgba(255, 255, 255, 1)'
                    },
                    line: {
                        borderJoinStyle: 'round',
                        borderCapStyle: 'round'
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart',
                    onProgress: function(animation) {
                        // Add a subtle loading effect
                        if (animation.currentStep === 0) {
                            console.log('Chart animation started');
                        }
                    },
                    onComplete: function() {
                        console.log('Chart loaded successfully');
                    }
                },
                onHover: (event, activeElements) => {
                    event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                }
            }
        });
    });
</script>