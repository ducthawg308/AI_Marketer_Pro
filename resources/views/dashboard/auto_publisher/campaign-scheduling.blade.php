<x-app-dashboard>
    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <div id="campaign-content" class="tab-content">
            <form id="campaign-schedule-form" action="#" method="POST" class="bg-white rounded-2xl shadow-xl p-8">
                @csrf
                <h2 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
                    <i class="fas fa-bullhorn mr-4 text-primary-600"></i>
                    Thiết lập chiến dịch
                </h2>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Campaign Setup -->
                    <div class="lg:col-span-2 space-y-8">
                        <!-- Campaign Info -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Thông tin chiến dịch</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên chiến dịch</label>
                                    <input type="text" name="name" class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200 placeholder-gray-400" placeholder="Ví dụ: Black Friday 2025">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Mục tiêu</label>
                                    <select name="campaign_goal" class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200 appearance-none bg-white">
                                        <option value="brand_awareness">Tăng nhận diện thương hiệu</option>
                                        <option value="engagement">Tăng tương tác</option>
                                        <option value="sales">Tăng doanh số</option>
                                        <option value="new_customers">Thu hút khách hàng mới</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Campaign Description -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-4">Mô tả</label>
                            <textarea name="description" class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200 h-32 resize-none placeholder-gray-400" placeholder="Nhập mô tả chiến dịch"></textarea>
                        </div>

                        <!-- Campaign Duration -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Thời gian chiến dịch</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ngày bắt đầu</label>
                                    <input type="text" name="start_date" id="campaign-start-date" class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200" data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Ngày kết thúc</label>
                                    <input type="text" name="end_date" id="campaign-end-date" class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200" data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày">
                                </div>
                            </div>
                        </div>

                        <!-- Posting Frequency -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Tần suất đăng bài</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-3 gap-4">
                                    <label class="flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                        <input type="radio" name="frequency" value="daily" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3">
                                        <span class="text-sm font-medium">Hàng ngày</span>
                                    </label>
                                    <label class="flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                        <input type="radio" name="frequency" value="weekly" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3">
                                        <span class="text-sm font-medium">Hàng tuần</span>
                                    </label>
                                    <label class="flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                        <input type="radio" name="frequency" value="custom" class="w-5 h-5 text-primary-600 border-gray-300 focus:ring-primary-500 mr-3" checked>
                                        <span class="text-sm font-medium">Tùy chỉnh</span>
                                    </label>
                                </div>
                                <!-- Custom Frequency -->
                                <div id="custom-frequency" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                                    <div class="text-center">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thứ 2-6</label>
                                        <input type="number" name="weekday_frequency" min="0" max="10" value="2" class="w-full p-3 text-center border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200">
                                    </div>
                                    <div class="text-center">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thứ 7</label>
                                        <input type="number" name="saturday_frequency" min="0" max="10" value="1" class="w-full p-3 text-center border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200">
                                    </div>
                                    <div class="text-center">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Chủ nhật</label>
                                        <input type="number" name="sunday_frequency" min="0" max="10" value="1" class="w-full p-3 text-center border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200">
                                    </div>
                                    <div class="text-center">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tổng/tuần</label>
                                        <div class="p-3 bg-primary-50 rounded-xl font-bold text-primary-700">10</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campaign Preview & Actions -->
                    <div class="space-y-8">
                        <!-- Campaign Summary -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-chart-pie mr-3 text-primary-600"></i>
                                Tóm tắt chiến dịch
                            </h3>
                            <div class="space-y-4 text-sm">
                                @foreach([
                                    ['label' => 'Thời gian', 'value' => '30 ngày'],
                                    ['label' => 'Tổng bài viết', 'value' => '42 bài'],
                                    ['label' => 'Nền tảng', 'value' => '3 nền tảng'],
                                    ['label' => 'Trung bình/ngày', 'value' => '1.4 bài']
                                ] as $summary)
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-gray-100">
                                    <span class="text-gray-600">{{ $summary['label'] }}</span>
                                    <span class="font-medium text-primary-700">{{ $summary['value'] }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Page Selection -->
                        <div class="bg-gray-50 p-6 rounded-xl border border-gray-200">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-share-alt mr-3 text-primary-600"></i>
                                Chọn Page
                            </h3>
                            <div class="space-y-3 max-h-48 overflow-y-auto">
                                @foreach($user_pages as $page)
                                <label class="flex items-center p-4 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-200">
                                    <input type="checkbox" name="campaign_pages[]" value="{{ $page->page_id }}" class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-4">
                                    <i class="fab fa-facebook text-blue-600 mr-3"></i>
                                    <span class="text-sm font-medium">{{ $page->page_name }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            <button type="submit" class="w-full bg-primary-600 text-white py-3 px-6 rounded-xl hover:bg-primary-700 focus:ring-2 focus:ring-primary-300 transition-all duration-200 font-semibold flex items-center justify-center">
                                <i class="fas fa-rocket mr-2"></i>
                                Khởi chạy chiến dịch
                            </button>
                            <button type="button" class="w-full bg-gray-200 text-gray-800 py-3 px-6 rounded-xl hover:bg-gray-300 focus:ring-2 focus:ring-gray-200 transition-all duration-200 font-semibold flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                Lưu bản nháp
                            </button>
                            <button type="button" class="w-full border border-gray-300 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 transition-all duration-200 font-semibold flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>
                                Xem trước lịch
                            </button>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            </form>
        </div>
    </div>
</x-app-dashboard>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script>
    // Initialize Flatpickr datepickers
    flatpickr("#campaign-start-date", {
        dateFormat: "d/m/Y",
        minDate: "today",
        defaultDate: new Date(),
        onChange: function(selectedDates, dateStr, instance) {
            instance.input.value = dateStr;
            flatpickr("#campaign-end-date").set("minDate", dateStr);
        }
    });

    flatpickr("#campaign-end-date", {
        dateFormat: "d/m/Y",
        minDate: "today",
        defaultDate: new Date().fp_incr(30),
        onChange: function(selectedDates, dateStr, instance) {
            instance.input.value = dateStr;
        }
    });
</script>