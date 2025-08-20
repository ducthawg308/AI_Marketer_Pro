<x-app-dashboard>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Lên lịch đăng bài tự động</h1>
            <p class="text-gray-600">Quản lý và lên lịch đăng bài cho các nền tảng mạng xã hội một cách dễ dàng</p>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-10">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center border-b border-gray-200">
                <li class="me-2">
                    <button class="inline-flex items-center p-4 border-b-2 rounded-t-lg border-primary-600 text-primary-600 font-semibold" 
                            id="normal-tab" type="button" role="tab" onclick="switchTab('normal')">
                        <i class="fas fa-clock mr-2"></i>
                        Lên lịch bình thường
                    </button>
                </li>
                <li class="me-2">
                    <button class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 text-gray-500" 
                            id="campaign-tab" type="button" role="tab" onclick="switchTab('campaign')">
                        <i class="fas fa-bullhorn mr-2"></i>
                        Lên lịch theo chiến dịch
                    </button>
                </li>
            </ul>
        </div>

        <!-- Normal Scheduling Tab -->
        <div id="normal-content" class="tab-content">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Panel - Content Selection -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-file-alt mr-3 text-primary-500"></i>
                        Chọn nội dung
                    </h2>
                    
                    <!-- Content Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm nội dung</label>
                        <div class="relative">
                            <input type="text" id="search-input" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                placeholder="Nhập từ khóa...">
                            <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Content List -->
                    <div id="content-list" class="space-y-4 max-h-96 overflow-y-auto pr-2">
                        @foreach($ads as $ad)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer transition-colors duration-200" data-title="{{ $ad->ad_title }}" data-content="{{ $ad->ad_content }}">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800">{{ $ad->ad_title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ \Str::limit($ad->ad_content, 100) }}</p>
                                    <div class="flex items-center mt-2 text-xs text-gray-500 space-x-3">
                                        @if($ad->type === 'link' && $ad->link)
                                            <span><i class="fas fa-link mr-1"></i>1 liên kết</span>
                                        @elseif($ad->hashtags)
                                            <span><i class="fas fa-hashtag mr-1"></i>{{ count(explode(',', $ad->hashtags)) }} hashtag</span>
                                        @elseif($ad->emojis)
                                            <span><i class="fas fa-smile mr-1"></i>{{ count(explode(',', $ad->emojis)) }} emoji</span>
                                        @endif
                                        <span><i class="fas fa-calendar mr-1"></i>Tạo: {{ $ad->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Panel - Scheduling Options -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-cog mr-3 text-primary-500"></i>
                        Cài đặt lịch đăng
                    </h2>

                    <!-- Platform Selection -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Chọn nền tảng</label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach([
                                ['icon' => 'fab fa-facebook', 'color' => 'text-blue-600', 'name' => 'Facebook', 'id' => 'facebook-platform'],
                                ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600', 'name' => 'Instagram'],
                                ['icon' => 'fab fa-linkedin', 'color' => 'text-blue-700', 'name' => 'LinkedIn'],
                                ['icon' => 'fab fa-tiktok', 'color' => 'text-gray-800', 'name' => 'TikTok']
                            ] as $platform)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" 
                                       id="{{ $platform['id'] ?? '' }}" data-platform="{{ $platform['name'] }}">
                                <i class="{{ $platform['icon'] }} {{ $platform['color'] }} mr-2"></i>
                                <span class="text-sm font-medium">{{ $platform['name'] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Scheduling Type -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Loại lịch đăng</label>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="schedule-type" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3">
                                <span class="text-sm font-medium">Đăng ngay</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="schedule-type" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" checked>
                                <span class="text-sm font-medium">Lên lịch đăng</span>
                            </label>
                        </div>
                    </div>

                    <!-- Date & Time -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ngày đăng</label>
                            <input type="text" id="normal-datepicker" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Giờ đăng</label>
                            <input type="time" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <!-- Repeat Options -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Lặp lại</label>
                        <select class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            <option>Không lặp lại</option>
                            <option>Hàng ngày</option>
                            <option>Hàng tuần</option>
                            <option>Hàng tháng</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button class="flex-1 bg-primary-600 text-white py-3 px-4 rounded-lg hover:bg-primary-700 transition-colors font-semibold">
                            <i class="fas fa-calendar-plus mr-2"></i>
                            Lên lịch đăng
                        </button>
                        <button class="px-4 py-3 border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campaign Scheduling Tab -->
        <div id="campaign-content" class="tab-content hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Campaign Setup -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-bullhorn mr-3 text-primary-500"></i>
                        Thiết lập chiến dịch
                    </h2>

                    <!-- Campaign Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tên chiến dịch</label>
                            <input type="text" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                placeholder="Ví dụ: Black Friday 2024">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mục tiêu</label>
                            <select class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option>Tăng nhận diện thương hiệu</option>
                                <option>Tăng tương tác</option>
                                <option>Tăng doanh số</option>
                                <option>Thu hút khách hàng mới</option>
                            </select>
                        </div>
                    </div>

                    <!-- Campaign Duration -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ngày bắt đầu</label>
                            <input type="text" id="campaign-start-date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ngày kết thúc</label>
                            <input type="text" id="campaign-end-date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" 
                                data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày">
                        </div>
                    </div>

                    <!-- Content Strategy -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Chiến lược nội dung</label>
                        <div class="space-y-3">
                            @foreach([
                                ['strategy' => 'Đăng tuần tự', 'desc' => 'Đăng các bài theo thứ tự đã sắp xếp'],
                                ['strategy' => 'Đăng ngẫu nhiên', 'desc' => 'Hệ thống tự động chọn nội dung phù hợp', 'checked' => true],
                                ['strategy' => 'Theo sự kiện', 'desc' => 'Đăng theo các mốc thời gian quan trọng']
                            ] as $strategy)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="radio" name="content-strategy" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" {{ $strategy['checked'] ?? false ? 'checked' : '' }}>
                                <div>
                                    <div class="font-semibold text-gray-800">{{ $strategy['strategy'] }}</div>
                                    <div class="text-sm text-gray-600">{{ $strategy['desc'] }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Posting Frequency -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Tần suất đăng bài</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <div class="text-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Thứ 2-6</label>
                                <input type="number" min="0" max="10" value="2" class="w-full p-2 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div class="text-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Thứ 7</label>
                                <input type="number" min="0" max="10" value="1" class="w-full p-2 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div class="text-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Chủ nhật</label>
                                <input type="number" min="0" max="10" value="1" class="w-full p-2 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div class="text-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tổng/tuần</label>
                                <div class="p-2 bg-gray-100 rounded-lg font-bold text-primary-600">10</div>
                            </div>
                        </div>
                    </div>

                    <!-- Time Slots -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Khung giờ đăng bài</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach(['06:00 - 09:00', '12:00 - 14:00', '18:00 - 22:00'] as $time)
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <input type="checkbox" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" {{ in_array($time, ['12:00 - 14:00', '18:00 - 22:00']) ? 'checked' : '' }}>
                                <span class="text-sm font-medium">{{ $time }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Campaign Preview & Actions -->
                <div class="space-y-6">
                    <!-- Campaign Summary -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-chart-pie mr-2 text-primary-500"></i>
                            Tóm tắt chiến dịch
                        </h3>
                        <div class="space-y-3 text-sm">
                            @foreach([
                                ['label' => 'Thời gian', 'value' => '30 ngày'],
                                ['label' => 'Tổng bài viết', 'value' => '42 bài'],
                                ['label' => 'Nền tảng', 'value' => '3 nền tảng'],
                                ['label' => 'Trung bình/ngày', 'value' => '1.4 bài']
                            ] as $summary)
                            <div class="flex justify-between">
                                <span class="text-gray-600">{{ $summary['label'] }}</span>
                                <span class="font-medium">{{ $summary['value'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Platform Selection -->
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-share-alt mr-2 text-primary-500"></i>
                            Nền tảng
                        </h3>
                        <div class="space-y-3">
                            @foreach([
                                ['icon' => 'fab fa-facebook', 'color' => 'text-blue-600', 'name' => 'Facebook', 'posts' => '14 bài'],
                                ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600', 'name' => 'Instagram', 'posts' => '14 bài'],
                                ['icon' => 'fab fa-linkedin', 'color' => 'text-blue-700', 'name' => 'LinkedIn', 'posts' => '14 bài']
                            ] as $platform)
                            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <div class="flex items-center">
                                    <input type="checkbox" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" checked>
                                    <i class="{{ $platform['icon'] }} {{ $platform['color'] }} mr-2"></i>
                                    <span class="text-sm font-medium">{{ $platform['name'] }}</span>
                                </div>
                                <span class="text-xs text-gray-500">{{ $platform['posts'] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="space-y-3">
                        <button class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg hover:bg-primary-700 transition-colors font-semibold">
                            <i class="fas fa-rocket mr-2"></i>
                            Khởi chạy chiến dịch
                        </button>
                        <button class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                            <i class="fas fa-save mr-2"></i>
                            Lưu bản nháp
                        </button>
                        <button class="w-full border border-gray-200 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-50 transition-colors font-semibold">
                            <i class="fas fa-eye mr-2"></i>
                            Xem trước lịch
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scheduled Posts Overview -->
        <div class="mt-12 bg-white rounded-xl shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
                    <i class="fas fa-list-ul mr-3 text-primary-500"></i>
                    Bài viết đã lên lịch
                </h2>
                <div class="flex space-x-3">
                    <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-filter mr-2"></i>
                        Lọc
                    </button>
                    <button class="px-4 py-2 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        <i class="fas fa-calendar-week mr-2"></i>
                        Xem lịch
                    </button>
                </div>
            </div>

            <!-- Posts Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Nội dung</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Nền tảng</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Thời gian đăng</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Trạng thái</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach([
                            [
                                'icon' => 'fas fa-image', 'icon_bg' => 'from-blue-500 to-purple-600', 'title' => 'Khuyến mãi Black Friday', 'desc' => 'Giảm giá lên đến 70%...', 
                                'platforms' => ['fab fa-facebook text-blue-600', 'fab fa-instagram text-pink-600'], 'date' => '25/11/2024', 'time' => '14:30', 'status' => 'Đang chờ', 'status_color' => 'bg-yellow-100 text-yellow-800',
                                'actions' => ['edit' => 'text-blue-600', 'trash' => 'text-red-600', 'eye' => 'text-gray-600']
                            ],
                            [
                                'icon' => 'fas fa-video', 'icon_bg' => 'from-green-500 to-blue-600', 'title' => 'Giới thiệu sản phẩm mới', 'desc' => 'Ra mắt dòng sản phẩm AI...', 
                                'platforms' => ['fab fa-linkedin text-blue-700', 'fab fa-tiktok text-gray-800'], 'date' => '26/11/2024', 'time' => '09:00', 'status' => 'Đã đăng', 'status_color' => 'bg-green-100 text-green-800',
                                'actions' => ['chart-line' => 'text-blue-600', 'external-link-alt' => 'text-gray-600']
                            ],
                            [
                                'icon' => 'fas fa-lightbulb', 'icon_bg' => 'from-orange-500 to-red-600', 'title' => 'Tips sử dụng sản phẩm', 'desc' => '10 mẹo hay để tối ưu...', 
                                'platforms' => ['fab fa-facebook text-blue-600'], 'date' => '27/11/2024', 'time' => '18:15', 'status' => 'Lỗi', 'status_color' => 'bg-red-100 text-red-800',
                                'actions' => ['redo' => 'text-yellow-600', 'edit' => 'text-blue-600', 'trash' => 'text-red-600']
                            ]
                        ] as $post)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-r {{ $post['icon_bg'] }} rounded-lg flex items-center justify-center mr-3">
                                        <i class="{{ $post['icon'] }} text-white"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $post['title'] }}</div>
                                        <div class="text-gray-600">{{ $post['desc'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    @foreach($post['platforms'] as $platform)
                                    <i class="{{ $platform }}"></i>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="text-gray-800">{{ $post['date'] }}</div>
                                <div class="text-gray-600">{{ $post['time'] }}</div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="px-3 py-1 text-xs font-medium {{ $post['status_color'] }} rounded-full">
                                    {{ $post['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    @foreach($post['actions'] as $icon => $color)
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
                    trong tổng số <span class="font-medium">25</span> bài viết
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

        <!-- Quick Stats -->
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach([
                ['icon' => 'fas fa-calendar-check', 'color' => 'text-primary-600', 'bg' => 'bg-primary-100', 'value' => '25', 'label' => 'Bài đã lên lịch'],
                ['icon' => 'fas fa-check-circle', 'color' => 'text-green-600', 'bg' => 'bg-green-100', 'value' => '18', 'label' => 'Đã đăng thành công'],
                ['icon' => 'fas fa-clock', 'color' => 'text-yellow-600', 'bg' => 'bg-yellow-100', 'value' => '5', 'label' => 'Đang chờ đăng'],
                ['icon' => 'fas fa-exclamation-triangle', 'color' => 'text-red-600', 'bg' => 'bg-red-100', 'value' => '2', 'label' => 'Lỗi đăng bài']
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
    </div>

    <!-- Modal for selecting Facebook Page -->
    <div id="page-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center h-screen z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-auto">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Chọn Page Facebook</h3>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @foreach($user_pages as $page)
                    <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                        <input type="radio" name="selected-page" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" value="{{ $page->page_id }}">
                        <span class="text-sm font-medium">{{ $page->page_name }}</span>
                    </label>
                @endforeach
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button id="close-modal" class="px-4 py-2 border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50">
                    Hủy
                </button>
                <button id="save-page" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Lưu
                </button>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            const tabs = {
                'normal': 'normal-content',
                'campaign': 'campaign-content'
            };
            
            // Reset tab styles
            document.querySelectorAll('[role="tab"]').forEach(btn => {
                btn.className = 'inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 text-gray-500';
            });
            document.querySelectorAll('.tab-content').forEach(content => {
                content.className = 'tab-content hidden';
            });

            // Activate selected tab
            document.getElementById(`${tab}-tab`).className = 'inline-flex items-center p-4 border-b-2 rounded-t-lg border-primary-600 text-primary-600 font-semibold';
            document.getElementById(tabs[tab]).className = 'tab-content';
        }

        // Auto-calculate total posts per week
        function updateWeeklyTotal() {
            const weekdays = parseInt(document.querySelector('input[type="number"]:nth-of-type(1)').value) || 0;
            const saturday = parseInt(document.querySelector('input[type="number"]:nth-of-type(2)').value) || 0;
            const sunday = parseInt(document.querySelector('input[type="number"]:nth-of-type(3)').value) || 0;
            const total = (weekdays * 5) + saturday + sunday;
            
            const totalDisplay = document.querySelector('.text-center .bg-gray-100');
            if (totalDisplay) {
                totalDisplay.textContent = total;
            }
        }

        // Realtime search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const frequencyInputs = document.querySelectorAll('input[type="number"]');
            frequencyInputs.forEach(input => {
                input.addEventListener('input', updateWeeklyTotal);
            });

            const searchInput = document.getElementById('search-input');
            const contentItems = document.querySelectorAll('#content-list > div');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();

                contentItems.forEach(item => {
                    const title = item.getAttribute('data-title').toLowerCase();
                    const content = item.getAttribute('data-content').toLowerCase();
                    if (title.includes(searchTerm) || content.includes(searchTerm)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

            // Handle Facebook page selection
            const facebookCheckbox = document.getElementById('facebook-platform');
            const modal = document.getElementById('page-modal');
            const closeModal = document.getElementById('close-modal');
            const savePage = document.getElementById('save-page');

            facebookCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    modal.classList.remove('hidden');
                } else {
                    modal.classList.add('hidden');
                }
            });

            closeModal.addEventListener('click', function() {
                modal.classList.add('hidden');
                facebookCheckbox.checked = false;
            });

            savePage.addEventListener('click', function() {
                const selectedPage = document.querySelector('input[name="selected-page"]:checked');
                if (selectedPage) {
                    console.log('Selected Page ID:', selectedPage.value);
                }
                modal.classList.add('hidden');
            });

            // Initialize Flatpickr for datepickers
            flatpickr("[data-datepicker]", {
                dateFormat: "d/m/Y", // Match the data-datepicker-format
                allowInput: false,   // Disable manual input
                minDate: "today"     // Optional: Restrict to today or later (August 20, 2025)
            });
        });
    </script>

    <!-- Include Flatpickr CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</x-app-dashboard>