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
                            @foreach([
                                ['icon' => 'fab fa-facebook', 'color' => 'text-blue-600', 'name' => 'Facebook'],
                                ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600', 'name' => 'Instagram'],
                                ['icon' => 'fab fa-linkedin', 'color' => 'text-blue-700', 'name' => 'LinkedIn'],
                                ['icon' => 'fab fa-tiktok', 'color' => 'text-gray-800', 'name' => 'TikTok']
                            ] as $platform)
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
            @foreach([
                ['icon' => 'fas fa-bullhorn', 'color' => 'text-primary-600', 'bg' => 'bg-primary-100', 'value' => '12', 'label' => 'Chiến dịch đang chạy'],
                ['icon' => 'fas fa-eye', 'color' => 'text-blue-600', 'bg' => 'bg-blue-100', 'value' => '1.2M', 'label' => 'Lượt xem'],
                ['icon' => 'fas fa-heart', 'color' => 'text-red-600', 'bg' => 'bg-red-100', 'value' => '45K', 'label' => 'Lượt tương tác'],
                ['icon' => 'fas fa-dollar-sign', 'color' => 'text-green-600', 'bg' => 'bg-green-100', 'value' => '3.5K', 'label' => 'Doanh thu ước tính']
            ] as $stat)
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="w-12 h-12 {{ $stat['bg'] }} rounded-lg flex items-center justify-center mx-auto mb-3">
                    <i class="{{ $stat['icon'] }} {{ $stat['color'] }} text-xl"></i>
                </div>
                <div class="text-2xl font-bold text-gray-800">{{ $stat['value'] }}</div>
                <div class="text-sm text-gray-600">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>

        <!-- Campaign Performance Chart -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-chart-bar mr-3 text-primary-500"></i>
                Hiệu suất chiến dịch
            </h2>
            <canvas id="performanceChart" class="w-full h-64"></canvas>
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
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Hiệu suất</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Trạng thái</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach([
                            [
                                'name' => 'Black Friday 2024', 'platforms' => ['fab fa-facebook text-blue-600', 'fab fa-instagram text-pink-600'],
                                'start_date' => '15/11/2024', 'end_date' => '30/11/2024', 'views' => '500K', 'engagements' => '20K',
                                'status' => 'Đang chạy', 'status_color' => 'bg-green-100 text-green-800',
                                'actions' => ['edit' => 'text-blue-600', 'trash' => 'text-red-600', 'chart-line' => 'text-primary-600']
                            ],
                            [
                                'name' => 'Ra mắt sản phẩm AI', 'platforms' => ['fab fa-linkedin text-blue-700', 'fab fa-tiktok text-gray-800'],
                                'start_date' => '10/11/2024', 'end_date' => '20/11/2024', 'views' => '300K', 'engagements' => '15K',
                                'status' => 'Hoàn thành', 'status_color' => 'bg-blue-100 text-blue-800',
                                'actions' => ['chart-line' => 'text-primary-600', 'external-link-alt' => 'text-gray-600']
                            ],
                            [
                                'name' => 'Tips tối ưu sản phẩm', 'platforms' => ['fab fa-facebook text-blue-600'],
                                'start_date' => '01/11/2024', 'end_date' => '10/11/2024', 'views' => '100K', 'engagements' => '5K',
                                'status' => 'Lỗi', 'status_color' => 'bg-red-100 text-red-800',
                                'actions' => ['redo' => 'text-yellow-600', 'edit' => 'text-blue-600', 'trash' => 'text-red-600']
                            ]
                        ] as $campaign)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-4">
                                <div class="font-semibold text-gray-800">{{ $campaign['name'] }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    @foreach($campaign['platforms'] as $platform)
                                    <i class="{{ $platform }}"></i>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-gray-800">{{ $campaign['start_date'] }} - {{ $campaign['end_date'] }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-gray-600">Lượt xem: {{ $campaign['views'] }}</div>
                                <div class="text-gray-600">Tương tác: {{ $campaign['engagements'] }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-3 py-1 text-xs font-medium {{ $campaign['status_color'] }} rounded-full">
                                    {{ $campaign['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    @foreach($campaign['actions'] as $icon => $color)
                                    <button class="{{ $color }} hover:{{ str_replace('600', '800', $color) }}">
                                        <i class="fas fa-{{ $icon }}"></i>
                                    </button>
                                    @endforeach
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
                    Hiển thị <span class="font-medium">1</span> đến <span class="font-medium">3</span> 
                    trong tổng số <span class="font-medium">15</span> chiến dịch
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Trước</button>
                    <button class="px-3 py-2 text-sm bg-primary-600 text-white rounded-lg">1</button>
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">2</button>
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">3</button>
                    <button class="px-3 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">Sau</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Chart.js for Performance Chart
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('performanceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['01/11', '05/11', '10/11', '15/11', '20/11', '25/11', '30/11'],
                    datasets: [
                        {
                            label: 'Lượt xem',
                            data: [10000, 15000, 20000, 25000, 30000, 35000, 40000],
                            borderColor: '#1e9c5a', // primary-600
                            backgroundColor: 'rgba(30, 156, 90, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Tương tác',
                            data: [500, 800, 1200, 1500, 1800, 2000, 2200],
                            borderColor: '#4cba80', // primary-500
                            backgroundColor: 'rgba(76, 186, 128, 0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        });
    </script>
</x-app-dashboard>