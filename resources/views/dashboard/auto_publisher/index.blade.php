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
                <button class="inline-flex items-center p-4 border-b-2 rounded-t-lg border-primary-600 text-primary-600 font-semibold" id="normal-tab" type="button" role="tab" onclick="switchTab('normal')">
                    <i class="fas fa-clock mr-2"></i> Lên lịch bình thường
                </button>
            </li>
            <li class="me-2">
                <button class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 text-gray-500" id="campaign-tab" type="button" role="tab" onclick="switchTab('campaign')">
                    <i class="fas fa-bullhorn mr-2"></i> Lên lịch theo chiến dịch
                </button>
            </li>
        </ul>
    </div>

    <!-- Normal Scheduling Tab -->
    <div id="normal-content" class="tab-content">
        <form id="normal-schedule-form" action="{{ route('dashboard.auto_publisher.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Panel - Content Selection -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-file-alt mr-3 text-primary-500"></i> Chọn nội dung
                    </h2>
                    <!-- Content Search -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm nội dung</label>
                        <div class="relative">
                            <input type="text" id="search-input" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" placeholder="Nhập từ khóa...">
                            <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                    <!-- Content List -->
                    <div id="content-list" class="space-y-4 max-h-96 overflow-y-auto pr-2">
                        @foreach($ads as $ad)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer transition-colors duration-200" data-title="{{ $ad->ad_title }}" data-content="{{ $ad->ad_content }}">
                            <div class="flex items-start space-x-3">
                                <input type="checkbox" name="selected_ads[]" value="{{ $ad->id }}" class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
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
                        <i class="fas fa-cog mr-3 text-primary-500"></i> Cài đặt lịch đăng
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
                                <input type="checkbox" name="platforms[]" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" id="{{ $platform['id'] ?? '' }}" value="{{ $platform['name'] }}">
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
                                <input type="radio" name="schedule_type" value="immediate" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" onchange="toggleRecurrenceFields()">
                                <span class="text-sm font-medium">Đăng ngay</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="schedule_type" value="scheduled" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" checked onchange="toggleRecurrenceFields()">
                                <span class="text-sm font-medium">Lên lịch đăng</span>
                            </label>
                        </div>
                    </div>
                    <!-- Date & Time -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ngày đăng</label>
                            <input type="text" name="scheduled_time" id="normal-datepicker" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Giờ đăng</label>
                            <input type="time" name="scheduled_time" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>
                    <!-- Repeat Options -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Lặp lại</label>
                        <select name="is_recurring" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" onchange="toggleRecurrenceInterval()">
                            <option value="0">Không lặp lại</option>
                            <option value="1">Lặp lại</option>
                        </select>
                    </div>
                    <!-- Recurrence Interval -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Khoảng cách lặp lại</label>
                        <select name="recurrence_interval" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" id="recurrence-interval">
                            <option value="daily">Hằng ngày</option>
                            <option value="weekly">Hàng tuần</option>
                            <option value="monthly">Hàng tháng</option>
                        </select>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex space-x-3">
                        <button type="submit" class="flex-1 bg-primary-600 text-white py-3 px-4 rounded-lg hover:bg-primary-700 transition-colors font-semibold">
                            <i class="fas fa-calendar-plus mr-2"></i> Lên lịch đăng
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Campaign Scheduling Tab -->
    <div id="campaign-content" class="tab-content hidden">
        <form id="campaign-schedule-form" action="#" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Campaign Setup -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg p-6">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-bullhorn mr-3 text-primary-500"></i> Thiết lập chiến dịch
                    </h2>
                    <!-- Campaign Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tên chiến dịch</label>
                            <input type="text" name="campaign_name" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ví dụ: Black Friday 2024">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mục tiêu</label>
                            <select name="campaign_goal" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
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
                            <input type="text" name="start_date" id="campaign-start-date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ngày kết thúc</label>
                            <input type="text" name="end_date" id="campaign-end-date" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày">
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
                                <input type="radio" name="content_strategy" value="{{ strtolower(str_replace(' ', '_', $strategy['strategy'])) }}" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" {{ $strategy['checked'] ?? false ? 'checked' : '' }}>
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
                                <input type="number" name="weekday_frequency" min="0" max="10" value="2" class="w-full p-2 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div class="text-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Thứ 7</label>
                                <input type="number" name="saturday_frequency" min="0" max="10" value="1" class="w-full p-2 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                            <div class="text-center">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Chủ nhật</label>
                                <input type="number" name="sunday_frequency" min="0" max="10" value="1" class="w-full p-2 text-center border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
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
                                <input type="checkbox" name="time_slots[]" value="{{ $time }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" {{ in_array($time, ['12:00 - 14:00', '18:00 - 22:00']) ? 'checked' : '' }}>
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
                            <i class="fas fa-chart-pie mr-2 text-primary-500"></i> Tóm tắt chiến dịch
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
                            <i class="fas fa-share-alt mr-2 text-primary-500"></i> Nền tảng
                        </h3>
                        <div class="space-y-3">
                            @foreach([
                                ['icon' => 'fab fa-facebook', 'color' => 'text-blue-600', 'name' => 'Facebook', 'posts' => '14 bài'],
                                ['icon' => 'fab fa-instagram', 'color' => 'text-pink-600', 'name' => 'Instagram', 'posts' => '14 bài'],
                                ['icon' => 'fab fa-linkedin', 'color' => 'text-blue-700', 'name' => 'LinkedIn', 'posts' => '14 bài']
                            ] as $platform)
                            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                                <div class="flex items-center">
                                    <input type="checkbox" name="campaign_platforms[]" value="{{ $platform['name'] }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" checked>
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
                        <button type="submit" class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg hover:bg-primary-700 transition-colors font-semibold">
                            <i class="fas fa-rocket mr-2"></i> Khởi chạy chiến dịch
                        </button>
                        <button type="button" class="w-full bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 transition-colors font-semibold">
                            <i class="fas fa-save mr-2"></i> Lưu bản nháp
                        </button>
                        <button type="button" class="w-full border border-gray-200 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-50 transition-colors font-semibold">
                            <i class="fas fa-eye mr-2"></i> Xem trước lịch
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Scheduled Posts Overview -->
    <div class="mt-12 bg-white rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 flex items-center">
                <i class="fas fa-list-ul mr-3 text-primary-500"></i> Bài viết đã lên lịch
            </h2>
            <div class="flex space-x-3">
                <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-filter mr-2"></i> Lọc
                </button>
                <button class="px-4 py-2 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    <i class="fas fa-calendar-week mr-2"></i> Xem lịch
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
                    @foreach($scheduledAds as $schedule)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <!-- Nội dung -->
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-image text-white"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $schedule->ad->ad_title }}</div>
                                        <div class="text-gray-600">{{ \Str::limit($schedule->ad->ad_content, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <!-- Nền tảng (page) -->
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    <i class="fab fa-facebook text-blue-600"></i>
                                    <span class="text-gray-700">{{ $schedule->userPage->page_name }}</span>
                                </div>
                            </td>
                            <!-- Thời gian đăng -->
                            <td class="px-4 py-4">
                                <div class="text-gray-800">{{ $schedule->scheduled_time }}</div>
                            </td>
                            <!-- Trạng thái -->
                            <td class="px-4 py-4">
                                @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'posted' => 'bg-green-100 text-green-800',
                                    'error' => 'bg-red-100 text-red-800',
                                ];
                                @endphp
                                <span class="px-3 py-1 text-xs font-medium {{ $statusColors[$schedule->status] ?? 'bg-gray-100 text-gray-800' }} rounded-full">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </td>
                            <!-- Hành động -->
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('dashboard.auto_publisher.edit', $schedule->ad->id) }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors duration-200">
                                        Sửa
                                    </a>
                                    <button type="button" data-modal-target="delete-modal-{{ $schedule->id }}" data-modal-toggle="delete-modal-{{ $schedule->id }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full hover:bg-red-200 transition-colors duration-200">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal xác nhận xóa -->
                        <div id="delete-modal-{{ $schedule->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full bg-black bg-opacity-50">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative bg-white rounded-xl shadow-2xl border border-gray-200">
                                    <div class="p-6 text-center">
                                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Xác nhận xóa</h3>
                                        <p class="mb-6 text-gray-500">Bạn có chắc muốn xóa nội dung "<span class="font-medium text-gray-900">{{ $schedule->ad->ad_title }}</span>"? <br><span class="text-sm">Hành động này không thể hoàn tác.</span></p>
                                        <div class="flex justify-center space-x-3">
                                            <button data-modal-toggle="delete-modal-{{ $schedule->id }}" class="px-6 py-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 font-medium transition-all duration-200">
                                                Hủy
                                            </button>
                                            <form action="{{ route('dashboard.auto_publisher.destroy', [$schedule->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-6 py-3 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg transition-all duration-200">
                                                    Xác nhận xóa
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @if($items->isEmpty())
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Chưa có bài viết đã lên lịch nào</h3>
                                <p class="text-gray-500 dark:text-gray-400">Hãy tạo bài viết đã lên lịch đầu tiên của bạn!</p>
                            </div>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div class="text-sm text-gray-700">
                Hiển thị <span class="font-medium">1</span> đến <span class="font-medium">3</span> trong tổng số <span class="font-medium">25</span> bài viết
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

    <!-- Modal for selecting Facebook Page -->
    <div id="page-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center h-screen z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-auto">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Chọn Page Facebook</h3>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @foreach($user_pages as $page)
                <label class="flex items-center p-2 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer">
                    <input type="radio" name="selected_page" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" value="{{ $page->page_id }}">
                    <span class="text-sm font-medium">{{ $page->page_name }}</span>
                </label>
                @endforeach
            </div>
            <div class="mt-6 flex justify-end space-x-3">
                <button id="close-modal" class="px-4 py-2 border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50">Hủy</button>
                <button id="save-page" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Lưu</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Flatpickr CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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
        const weekdays = parseInt(document.querySelector('input[name="weekday_frequency"]').value) || 0;
        const saturday = parseInt(document.querySelector('input[name="saturday_frequency"]').value) || 0;
        const sunday = parseInt(document.querySelector('input[name="sunday_frequency"]').value) || 0;
        const total = (weekdays * 5) + saturday + sunday;
        const totalDisplay = document.querySelector('.text-center .bg-gray-100');
        if (totalDisplay) {
            totalDisplay.textContent = total;
        }
    }

    function toggleRecurrenceFields() {
        const immediate = document.querySelector('input[name="schedule_type"][value="immediate"]').checked;
        const recurringSelect = document.querySelector('select[name="is_recurring"]');
        const recurrenceInterval = document.getElementById('recurrence-interval');
        
        if (immediate) {
            recurringSelect.disabled = true;
            recurrenceInterval.disabled = true;
            recurringSelect.value = "0"; // Set to "Không lặp lại" by default
        } else {
            recurringSelect.disabled = false;
            toggleRecurrenceInterval();
        }
    }

    function toggleRecurrenceInterval() {
        const isRecurring = document.querySelector('select[name="is_recurring"]').value === "0";
        const recurrenceInterval = document.getElementById('recurrence-interval');
        
        if (isRecurring) {
            recurrenceInterval.disabled = true;
        } else {
            recurrenceInterval.disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Frequency inputs
        const frequencyInputs = document.querySelectorAll('input[type="number"][name$="_frequency"]');
        frequencyInputs.forEach(input => {
            input.addEventListener('input', updateWeeklyTotal);
        });

        // Search functionality
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

        // Facebook page selection
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
            const selectedPage = document.querySelector('input[name="selected_page"]:checked');
            if (selectedPage) {
                console.log('Selected Page ID:', selectedPage.value);
                document.querySelector('input[name="platforms[]"][value="Facebook"]').value = selectedPage.value;
            }
            modal.classList.add('hidden');
        });

        // Initialize Flatpickr for datepickers
        flatpickr("[data-datepicker]", {
            dateFormat: "d/m/Y",
            allowInput: false,
            minDate: "today"
        });

        // Initialize recurrence field toggles
        toggleRecurrenceFields();
    });
</script>
</x-app-dashboard>