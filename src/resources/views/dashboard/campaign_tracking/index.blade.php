<x-app-dashboard>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Theo dõi chiến dịch</h1>
            <p class="text-gray-600">Xem hiệu suất và quản lý các chiến dịch mạng xã hội của bạn</p>
        </div>

        <!-- Filter Section -->
        <div class="mb-8 bg-white rounded-xl shadow-lg p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm chiến dịch</label>
                    <div class="relative">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                               placeholder="Nhập tên chiến dịch...">
                        <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Thời gian</label>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                               data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Từ ngày">
                        <input type="text" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                               data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Đến ngày">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nền tảng</label>
                    <button id="platform-dropdown-button" data-dropdown-toggle="platform-dropdown" 
                            class="w-full p-3 border border-gray-200 rounded-lg bg-white text-gray-700 hover:bg-gray-50 transition-colors text-sm font-medium flex justify-between items-center">
                        Chọn nền tảng
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div id="platform-dropdown" class="hidden z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <ul class="py-2 text-sm text-gray-700">
                            @php
                                $platforms = [
                                    ['icon' => 'fab fa-facebook', 'color' => 'text-blue-600', 'name' => 'Facebook'],
                                    ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600', 'name' => 'Instagram'],
                                    ['icon' => 'fab fa-linkedin', 'color' => 'text-blue-700', 'name' => 'LinkedIn'],
                                    ['icon' => 'fab fa-tiktok', 'color' => 'text-gray-800', 'name' => 'TikTok'],
                                    ['icon' => 'fab fa-youtube', 'color' => 'text-red-600', 'name' => 'YouTube'],
                                    ['icon' => 'fab fa-twitter', 'color' => 'text-blue-400', 'name' => 'Twitter']
                                ];
                            @endphp
                            @foreach($platforms as $platform)
                            <li>
                                <label class="flex items-center px-4 py-2 hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-2">
                                    <i class="{{ $platform['icon'] }} {{ $platform['color'] }} mr-2"></i>
                                    {{ $platform['name'] }}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campaign Overview -->
        <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $overviewStats = [
                    [
                        'icon' => 'fas fa-bullhorn', 
                        'color' => 'text-primary-600', 
                        'bg' => 'bg-primary-100', 
                        'value' => '18', 
                        'label' => 'Chiến dịch đang chạy',
                        'trend' => '+3 so với tháng trước'
                    ],
                    [
                        'icon' => 'fas fa-eye', 
                        'color' => 'text-blue-600', 
                        'bg' => 'bg-blue-100', 
                        'value' => '2.8M', 
                        'label' => 'Lượt xem',
                        'trend' => '+15.6% so với tuần trước'
                    ],
                    [
                        'icon' => 'fas fa-heart', 
                        'color' => 'text-red-600', 
                        'bg' => 'bg-red-100', 
                        'value' => '156K', 
                        'label' => 'Lượt tương tác',
                        'trend' => '+12.3% so với tuần trước'
                    ],
                    [
                        'icon' => 'fas fa-chart-line', 
                        'color' => 'text-green-600', 
                        'bg' => 'bg-green-100', 
                        'value' => '8.2%', 
                        'label' => 'Tỷ lệ tương tác',
                        'trend' => '+0.8% so với tuần trước'
                    ]
                ];
            @endphp
            @foreach($overviewStats as $stat)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-12 h-12 {{ $stat['bg'] }} rounded-lg flex items-center justify-center">
                        <i class="{{ $stat['icon'] }} {{ $stat['color'] }} text-xl"></i>
                    </div>
                    <div class="text-xs text-green-600 bg-green-50 px-2 py-1 rounded-full">
                        {{ $stat['trend'] }}
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-800 mb-1">{{ $stat['value'] }}</div>
                <div class="text-sm text-gray-600">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>

        <!-- Additional Metrics -->
        <div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            @php
                $additionalMetrics = [
                    ['icon' => 'fas fa-thumbs-up', 'color' => 'text-blue-500', 'value' => '89K', 'label' => 'Lượt thích'],
                    ['icon' => 'fas fa-share', 'color' => 'text-green-500', 'value' => '23K', 'label' => 'Lượt chia sẻ'],
                    ['icon' => 'fas fa-comment', 'color' => 'text-purple-500', 'value' => '44K', 'label' => 'Bình luận'],
                    ['icon' => 'fas fa-bookmark', 'color' => 'text-yellow-500', 'value' => '12K', 'label' => 'Lưu bài viết'],
                    ['icon' => 'fas fa-mouse-pointer', 'color' => 'text-indigo-500', 'value' => '6.4%', 'label' => 'CTR trung bình']
                ];
            @endphp
            @foreach($additionalMetrics as $metric)
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <i class="{{ $metric['icon'] }} {{ $metric['color'] }} text-lg mb-2"></i>
                <div class="text-lg font-bold text-gray-800">{{ $metric['value'] }}</div>
                <div class="text-xs text-gray-600">{{ $metric['label'] }}</div>
            </div>
            @endforeach
        </div>

        <!-- Campaign Performance Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar mr-3 text-primary-500"></i>
                    Hiệu suất chiến dịch
                </h2>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 text-xs border border-gray-200 rounded-lg hover:bg-gray-50">7 ngày</button>
                    <button class="px-3 py-2 text-xs bg-primary-600 text-white rounded-lg">30 ngày</button>
                    <button class="px-3 py-2 text-xs border border-gray-200 rounded-lg hover:bg-gray-50">90 ngày</button>
                </div>
            </div>
            <div class="relative h-100">
                <canvas id="performanceChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Campaign List -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-list-ul mr-3 text-primary-500"></i>
                    Danh sách chiến dịch
                </h2>
                <div class="flex space-x-3">
                    <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-filter mr-2"></i>
                        Lọc
                    </button>
                    <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-download mr-2"></i>
                        Xuất báo cáo
                    </button>
                    <button class="px-4 py-2 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Thêm chiến dịch
                    </button>
                </div>
            </div>

            <!-- Campaigns Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Tên chiến dịch</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Nền tảng</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Thời gian</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Lượt xem</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Tương tác</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">CTR</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Trạng thái</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @php
                            $campaigns = [
                                [
                                    'name' => 'Black Friday 2024 - Flash Sale',
                                    'platforms' => [
                                        ['icon' => 'fab fa-facebook', 'color' => 'text-blue-600'],
                                        ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600']
                                    ],
                                    'start_date' => '15/11/2024',
                                    'end_date' => '30/11/2024',
                                    'views' => '892K',
                                    'views_trend' => '+23%',
                                    'engagements' => '67K',
                                    'engagement_trend' => '+18%',
                                    'ctr' => '7.5%',
                                    'ctr_trend' => '+0.8%',
                                    'status' => 'Đang chạy',
                                    'status_color' => 'bg-green-100 text-green-800',
                                    'budget_used' => '85%'
                                ],
                                [
                                    'name' => 'Ra mắt sản phẩm AI Assistant',
                                    'platforms' => [
                                        ['icon' => 'fab fa-linkedin', 'color' => 'text-blue-700'],
                                        ['icon' => 'fab fa-youtube', 'color' => 'text-red-600']
                                    ],
                                    'start_date' => '10/11/2024',
                                    'end_date' => '20/11/2024',
                                    'views' => '456K',
                                    'views_trend' => '+12%',
                                    'engagements' => '34K',
                                    'engagement_trend' => '+15%',
                                    'ctr' => '7.4%',
                                    'ctr_trend' => '+1.2%',
                                    'status' => 'Hoàn thành',
                                    'status_color' => 'bg-blue-100 text-blue-800',
                                    'budget_used' => '97%'
                                ],
                                [
                                    'name' => 'Content Marketing - Tips & Tricks',
                                    'platforms' => [
                                        ['icon' => 'fab fa-tiktok', 'color' => 'text-gray-800'],
                                        ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600']
                                    ],
                                    'start_date' => '05/11/2024',
                                    'end_date' => '15/11/2024',
                                    'views' => '234K',
                                    'views_trend' => '+8%',
                                    'engagements' => '28K',
                                    'engagement_trend' => '+22%',
                                    'ctr' => '12.0%',
                                    'ctr_trend' => '+2.1%',
                                    'status' => 'Hoàn thành',
                                    'status_color' => 'bg-blue-100 text-blue-800',
                                    'budget_used' => '92%'
                                ],
                                [
                                    'name' => 'Holiday Season Campaign',
                                    'platforms' => [
                                        ['icon' => 'fab fa-facebook', 'color' => 'text-blue-600']
                                    ],
                                    'start_date' => '01/12/2024',
                                    'end_date' => '31/12/2024',
                                    'views' => '0',
                                    'views_trend' => 'N/A',
                                    'engagements' => '0',
                                    'engagement_trend' => 'N/A',
                                    'ctr' => 'N/A',
                                    'ctr_trend' => 'N/A',
                                    'status' => 'Đã lên lịch',
                                    'status_color' => 'bg-yellow-100 text-yellow-800',
                                    'budget_used' => '0%'
                                ],
                                [
                                    'name' => 'Retargeting Campaign - Q4',
                                    'platforms' => [
                                        ['icon' => 'fab fa-facebook', 'color' => 'text-blue-600'],
                                        ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600'],
                                        ['icon' => 'fab fa-linkedin', 'color' => 'text-blue-700']
                                    ],
                                    'start_date' => '20/10/2024',
                                    'end_date' => '25/11/2024',
                                    'views' => '1.2M',
                                    'views_trend' => '+45%',
                                    'engagements' => '89K',
                                    'engagement_trend' => '+35%',
                                    'ctr' => '7.4%',
                                    'ctr_trend' => '+1.8%',
                                    'status' => 'Đang chạy',
                                    'status_color' => 'bg-green-100 text-green-800',
                                    'budget_used' => '78%'
                                ],
                                [
                                    'name' => 'Brand Awareness - Gen Z Focus',
                                    'platforms' => [
                                        ['icon' => 'fab fa-tiktok', 'color' => 'text-gray-800'],
                                        ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600']
                                    ],
                                    'start_date' => '01/11/2024',
                                    'end_date' => '10/11/2024',
                                    'views' => '156K',
                                    'views_trend' => '-5%',
                                    'engagements' => '8K',
                                    'engagement_trend' => '-12%',
                                    'ctr' => '5.1%',
                                    'ctr_trend' => '-0.9%',
                                    'status' => 'Cần tối ưu',
                                    'status_color' => 'bg-orange-100 text-orange-800',
                                    'budget_used' => '65%'
                                ]
                            ];
                        @endphp
                        @foreach($campaigns as $campaign)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-gray-800">{{ $campaign['name'] }}</div>
                                <div class="text-xs text-gray-500">Ngân sách đã dùng: {{ $campaign['budget_used'] }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    @foreach($campaign['platforms'] as $platform)
                                    <i class="{{ $platform['icon'] }} {{ $platform['color'] }} text-lg"></i>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-gray-800 text-xs">{{ $campaign['start_date'] }}</div>
                                <div class="text-gray-800 text-xs">{{ $campaign['end_date'] }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-gray-800">{{ $campaign['views'] }}</div>
                                @if($campaign['views_trend'] !== 'N/A')
                                <div class="text-xs {{ strpos($campaign['views_trend'], '+') !== false ? 'text-green-600' : (strpos($campaign['views_trend'], '-') !== false ? 'text-red-600' : 'text-gray-500') }}">
                                    {{ $campaign['views_trend'] }}
                                </div>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-gray-800">{{ $campaign['engagements'] }}</div>
                                @if($campaign['engagement_trend'] !== 'N/A')
                                <div class="text-xs {{ strpos($campaign['engagement_trend'], '+') !== false ? 'text-green-600' : (strpos($campaign['engagement_trend'], '-') !== false ? 'text-red-600' : 'text-gray-500') }}">
                                    {{ $campaign['engagement_trend'] }}
                                </div>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <div class="font-semibold text-gray-800">{{ $campaign['ctr'] }}</div>
                                @if($campaign['ctr_trend'] !== 'N/A')
                                <div class="text-xs {{ strpos($campaign['ctr_trend'], '+') !== false ? 'text-green-600' : (strpos($campaign['ctr_trend'], '-') !== false ? 'text-red-600' : 'text-gray-500') }}">
                                    {{ $campaign['ctr_trend'] }}
                                </div>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-3 py-1 text-xs font-medium {{ $campaign['status_color'] }} rounded-full">
                                    {{ $campaign['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    <button class="text-blue-600 hover:text-blue-800 p-1" title="Xem chi tiết">
                                        <i class="fas fa-chart-line"></i>
                                    </button>
                                    <button class="text-green-600 hover:text-green-800 p-1" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-yellow-600 hover:text-yellow-800 p-1" title="Sao chép">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                    <button class="text-gray-600 hover:text-gray-800 p-1" title="Tạm dừng">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800 p-1" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-6">
                <div class="text-sm text-gray-700">
                    Hiển thị <span class="font-medium">1</span> đến <span class="font-medium">6</span> 
                    trong tổng số <span class="font-medium">24</span> chiến dịch
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors disabled:opacity-50" disabled>Trước</button>
                    <button class="px-3 py-2 text-sm bg-primary-600 text-white rounded-lg">1</button>
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">2</button>
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">3</button>
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">4</button>
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Sau</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <script>
        // Initialize Chart.js for Performance Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('performanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['05/11', '10/11', '15/11', '20/11', '25/11', '30/11'],
                    datasets: [
                        {
                            label: 'Lượt xem',
                            data: [45000, 61000, 73000, 82000, 87000, 98000],
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Lượt tương tác',
                            data: [3200, 4200, 5100, 5700, 6000, 6700],
                            borderColor: '#ef4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 15
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        }
                    }
                }
            });
        });

        // Add interactivity to platform dropdown
        document.getElementById('platform-dropdown-button').addEventListener('click', function() {
            const dropdown = document.getElementById('platform-dropdown');
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('platform-dropdown');
            const button = document.getElementById('platform-dropdown-button');
            
            if (!dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</x-app-dashboard>