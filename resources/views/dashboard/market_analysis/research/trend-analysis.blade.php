{{-- resources/views/research/market-trend.blade.php --}}
<div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-lg">
    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 flex items-center">
                <svg class="w-8 h-8 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                </svg>
                Xu hướng thị trường
            </h2>
            <p class="text-gray-600 mt-1">Phát hiện xu hướng mới nổi và cơ hội đầu tư</p>
        </div>
        
        <!-- Market Overview Stats -->
        <div class="flex space-x-4">
            <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                <p class="text-xs text-gray-500">Quy mô thị trường</p>
                <p class="text-lg font-bold text-blue-600">{{ $data['data']['market_size'] ?? 'N/A' }}</p>
            </div>
            <div class="bg-white rounded-lg px-4 py-2 shadow-sm">
                <p class="text-xs text-gray-500">Tăng trưởng/năm</p>
                <p class="text-lg font-bold text-green-600">{{ $data['data']['growth_rate'] ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Column: Chart and Trends -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Market Trend Chart -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Biểu đồ xu hướng thị trường</h3>
                    <div class="flex space-x-2">
                        <span class="flex items-center text-sm">
                            <div class="w-3 h-3 bg-blue-500 rounded mr-2"></div>
                            Dữ liệu thực tế
                        </span>
                        <span class="flex items-center text-sm">
                            <div class="w-3 h-3 bg-red-500 rounded mr-2"></div>
                            Dự báo
                        </span>
                    </div>
                </div>
                <canvas id="marketTrendChart" class="w-full h-80"></canvas>
            </div>

            <!-- Emerging Trends -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                    </svg>
                    Xu hướng mới nổi
                </h3>
                
                @if(isset($data['data']['emerging_trends']) && is_array($data['data']['emerging_trends']))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($data['data']['emerging_trends'] as $trend)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-800">{{ $trend['trend'] ?? 'Xu hướng' }}</h4>
                                <span class="px-2 py-1 text-xs rounded-full 
                                    {{ ($trend['impact_level'] ?? '') === 'Cao' ? 'bg-red-100 text-red-800' : 
                                       (($trend['impact_level'] ?? '') === 'Trung bình' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                    {{ $trend['impact_level'] ?? 'Chưa xác định' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-2">{{ $trend['description'] ?? '' }}</p>
                            <p class="text-xs text-blue-600">⏱ {{ $trend['timeline'] ?? 'Chưa xác định' }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Chưa có dữ liệu xu hướng mới nổi</p>
                @endif
            </div>

            <!-- SWOT Analysis -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Phân tích SWOT</h3>
                
                @if(isset($data['data']['swot_analysis']))
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Strengths -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h4 class="font-medium text-green-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Điểm mạnh
                        </h4>
                        <ul class="text-sm text-green-700 space-y-1">
                            @foreach($data['data']['swot_analysis']['strengths'] ?? [] as $strength)
                                <li>• {{ $strength }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Weaknesses -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <h4 class="font-medium text-red-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            Điểm yếu
                        </h4>
                        <ul class="text-sm text-red-700 space-y-1">
                            @foreach($data['data']['swot_analysis']['weaknesses'] ?? [] as $weakness)
                                <li>• {{ $weakness }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Opportunities -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-medium text-blue-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 01-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            Cơ hội
                        </h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            @foreach($data['data']['swot_analysis']['opportunities'] ?? [] as $opportunity)
                                <li>• {{ $opportunity }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Threats -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <h4 class="font-medium text-yellow-800 mb-2 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Thách thức
                        </h4>
                        <ul class="text-sm text-yellow-700 space-y-1">
                            @foreach($data['data']['swot_analysis']['threats'] ?? [] as $threat)
                                <li>• {{ $threat }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @else
                    <p class="text-gray-500 italic">Chưa có dữ liệu phân tích SWOT</p>
                @endif
            </div>
        </div>

        <!-- Right Column: Analysis and Recommendations -->
        <div class="space-y-6">
            
            <!-- Market Analysis -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Nhận định thị trường
                </h3>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 text-gray-700 text-sm leading-relaxed">
                    {!! nl2br(e($data['data']['analysis'] ?? 'Chưa có dữ liệu phân tích')) !!}
                </div>
            </div>

            <!-- Forecast -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    Dự đoán xu hướng
                </h3>
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-gray-700 text-sm leading-relaxed">
                    {!! nl2br(e($data['data']['forecast'] ?? 'Chưa có dữ liệu dự báo')) !!}
                </div>
            </div>

            <!-- Risk Assessment -->
            @if(isset($data['data']['risk_assessment']))
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    Đánh giá rủi ro
                </h3>
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 text-gray-700 text-sm leading-relaxed">
                    {!! nl2br(e($data['data']['risk_assessment'])) !!}
                </div>
            </div>
            @endif

        </div>
    </div>

    <!-- Strategic Recommendations -->
    @if(isset($data['data']['recommendations']) && is_array($data['data']['recommendations']))
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-3 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
            </svg>
            Khuyến nghị chiến lược
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($data['data']['recommendations'] as $recommendation)
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                        {{ ($recommendation['category'] ?? '') === 'Ngắn hạn' ? 'bg-red-100 text-red-800' : 
                           (($recommendation['category'] ?? '') === 'Trung hạn' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ $recommendation['category'] ?? 'Chưa phân loại' }}
                    </span>
                    <span class="px-2 py-1 text-xs rounded-full 
                        {{ ($recommendation['priority'] ?? '') === 'Cao' ? 'bg-red-100 text-red-800' : 
                           (($recommendation['priority'] ?? '') === 'Trung bình' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                        {{ $recommendation['priority'] ?? 'Chưa xác định' }}
                    </span>
                </div>
                
                <h4 class="font-semibold text-gray-800 mb-2">{{ $recommendation['title'] ?? 'Khuyến nghị' }}</h4>
                <p class="text-sm text-gray-600 mb-3">{{ $recommendation['content'] ?? '' }}</p>
                
                @if(isset($recommendation['expected_impact']))
                <div class="text-xs text-blue-600 mb-1">
                    <strong>Tác động:</strong> {{ $recommendation['expected_impact'] }}
                </div>
                @endif
                
                @if(isset($recommendation['timeline']))
                <div class="text-xs text-gray-500">
                    <strong>Thời gian:</strong> {{ $recommendation['timeline'] }}
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Data Sources -->
    @if(isset($data['data']['data_sources']))
    <div class="mt-6 p-4 bg-gray-50 rounded-lg border">
        <p class="text-xs text-gray-600">
            <strong>Nguồn dữ liệu:</strong> {{ $data['data']['data_sources'] }}
        </p>
    </div>
    @endif
</div>

<!-- Enhanced Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('marketTrendChart').getContext('2d');
        
        const chartData = {!! json_encode($data['data']['chart_data'] ?? []) !!};
        const labels = chartData.labels || [];
        const actualData = chartData.actual_data || [];
        const forecastData = chartData.forecast_data || [];
        
        // Combine datasets
        const combinedActual = actualData.map((value, index) => 
            forecastData[index] === null ? value : null
        );
        const combinedForecast = forecastData.map((value, index) => 
            value !== null ? value : null
        );
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Dữ liệu thực tế',
                        data: combinedActual,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(59, 130, 246)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    },
                    {
                        label: 'Dự báo',
                        data: combinedForecast,
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 3,
                        borderDash: [10, 5],
                        fill: false,
                        tension: 0.4,
                        pointBackgroundColor: 'rgb(239, 68, 68)',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Xu hướng và Dự báo Thị trường',
                        font: {
                            size: 16,
                            weight: 'bold'
                        },
                        padding: 20
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: 'white',
                        bodyColor: 'white',
                        borderColor: 'rgba(255, 255, 255, 0.1)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            title: function(context) {
                                return 'Thời gian: ' + context[0].label;
                            },
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('vi-VN').format(context.parsed.y);
                                }
                                return label;
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
                            }
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                            font: {
                                size: 11
                            }
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Chỉ số thị trường',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            callback: function(value, index, values) {
                                return new Intl.NumberFormat('vi-VN').format(value);
                            },
                            font: {
                                size: 11
                            }
                        },
                        beginAtZero: false
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                elements: {
                    point: {
                        hoverBackgroundColor: 'rgba(255, 255, 255, 0.8)'
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
    });
</script>