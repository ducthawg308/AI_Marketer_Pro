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
                        <input type="text" name="name" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Ví dụ: Black Friday 2024">
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
                <!-- Campaign Description -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                    <textarea name="description" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Nhập mô tả chiến dịch"></textarea>
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
                <!-- Posting Frequency -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Tần suất đăng bài</label>
                    <div class="space-y-3">
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                            <input type="radio" name="frequency" value="daily" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3">
                            <span class="text-sm font-medium">Hàng ngày</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                            <input type="radio" name="frequency" value="weekly" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3">
                            <span class="text-sm font-medium">Hàng tuần</span>
                        </label>
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                            <input type="radio" name="frequency" value="custom" class="w-4 h-4 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" checked>
                            <span class="text-sm font-medium">Tùy chỉnh</span>
                        </label>
                    </div>
                    <!-- Custom Frequency (visible when 'custom' is selected) -->
                    <div id="custom-frequency" class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-3">
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
                <!-- Campaign Status -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                    <select name="status" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <option value="draft">Nháp</option>
                        <option value="running">Đang chạy</option>
                        <option value="stopped">Đã dừng</option>
                        <option value="completed">Hoàn thành</option>
                    </select>
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
                <!-- Page Selection -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-share-alt mr-2 text-primary-500"></i> Chọn Page
                    </h3>
                    <div class="space-y-3 max-h-40 overflow-y-auto">
                        @foreach($user_pages as $page)
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                            <input type="checkbox" name="campaign_pages[]" value="{{ $page->page_id }}" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" checked>
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium">{{ $page->page_name }}</span>
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
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
    </form>
</div>