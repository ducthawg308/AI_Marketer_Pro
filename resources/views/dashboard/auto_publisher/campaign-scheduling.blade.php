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
                                        <input type="number" name="weekday_frequency" min="0" max="10" value="2" class="w-full p-3 text-center border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200 frequency-input">
                                    </div>
                                    <div class="text-center">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Thứ 7</label>
                                        <input type="number" name="saturday_frequency" min="0" max="10" value="1" class="w-full p-3 text-center border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200 frequency-input">
                                    </div>
                                    <div class="text-center">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Chủ nhật</label>
                                        <input type="number" name="sunday_frequency" min="0" max="10" value="1" class="w-full p-3 text-center border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200 frequency-input">
                                    </div>
                                    <div class="text-center">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Tổng/tuần</label>
                                        <div id="total-frequency" class="p-3 bg-primary-50 rounded-xl font-bold text-primary-700">4</div>
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
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-gray-100">
                                    <span class="text-gray-600">Thời gian</span>
                                    <span id="summary-duration" class="font-medium text-primary-700">30 ngày</span>
                                </div>
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-gray-100">
                                    <span class="text-gray-600">Tổng bài viết</span>
                                    <span id="summary-total-posts" class="font-medium text-primary-700">42 bài</span>
                                </div>
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-gray-100">
                                    <span class="text-gray-600">Nền tảng</span>
                                    <span id="summary-platforms" class="font-medium text-primary-700">3 nền tảng</span>
                                </div>
                                <div class="flex justify-between items-center bg-white p-3 rounded-lg border border-gray-100">
                                    <span class="text-gray-600">Trung bình/ngày</span>
                                    <span id="summary-average-posts" class="font-medium text-primary-700">1.4 bài</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            <button type="button" class="w-full border border-gray-300 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 transition-all duration-200 font-semibold flex items-center justify-center">
                                <i class="fas fa-eye mr-2"></i>
                                Xem trước lịch
                            </button>
                            <a href="{{ route('dashboard.auto_publisher.normal') }}" class="w-full border border-gray-300 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-50 focus:ring-2 focus:ring-gray-200 transition-all duration-200 font-semibold flex items-center justify-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Quay về
                            </a>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="user_id" value="{{ auth()->id() }}">
            </form>
        </div>
    </div>
</x-app-dashboard>

<script>
    let startDatePicker = flatpickr("#campaign-start-date", {
        dateFormat: "d/m/Y",
        minDate: "today",
        defaultDate: new Date(),
        onChange: function(selectedDates, dateStr, instance) {
            instance.input.value = dateStr;
            flatpickr("#campaign-end-date").set("minDate", dateStr);
            updateCampaignSummary();
        }
    });

    let endDatePicker = flatpickr("#campaign-end-date", {
        dateFormat: "d/m/Y",
        minDate: "today",
        defaultDate: new Date().fp_incr(30),
        onChange: function(selectedDates, dateStr, instance) {
            instance.input.value = dateStr;
            updateCampaignSummary();
        }
    });

    // Dynamic total frequency calculation
    function getWeeklyFrequency() {
        const frequencyType = document.querySelector('input[name="frequency"]:checked').value;
        let postsPerWeek = 0;

        if (frequencyType === 'daily') {
            postsPerWeek = 7; // 1 post per day
        } else if (frequencyType === 'weekly') {
            postsPerWeek = 1; // 1 post per week
        } else if (frequencyType === 'custom') {
            const weekday = parseInt(document.querySelector('input[name="weekday_frequency"]').value) || 0;
            const saturday = parseInt(document.querySelector('input[name="saturday_frequency"]').value) || 0;
            const sunday = parseInt(document.querySelector('input[name="sunday_frequency"]').value) || 0;
            postsPerWeek = weekday * 5 + saturday + sunday; // Weekdays (Mon-Fri) * 5 + Sat + Sun
        }

        return postsPerWeek;
    }

    function updateTotalFrequency() {
        const postsPerWeek = getWeeklyFrequency();
        document.getElementById('total-frequency').textContent = postsPerWeek;
    }

    function updateCampaignSummary() {
        // Calculate duration in days
        const startDate = startDatePicker.selectedDates[0];
        const endDate = endDatePicker.selectedDates[0];
        const durationMs = endDate - startDate;
        const durationDays = Math.ceil(durationMs / (1000 * 60 * 60 * 24)) + 1; // Include end date

        // Calculate total posts
        const postsPerWeek = getWeeklyFrequency();
        const weeks = durationDays / 7;
        const totalPosts = Math.round(postsPerWeek * weeks);

        // Calculate average posts per day
        const averagePostsPerDay = durationDays > 0 ? (totalPosts / durationDays).toFixed(1) : 0;

        // Update summary
        document.getElementById('summary-duration').textContent = `${durationDays} ngày`;
        document.getElementById('summary-total-posts').textContent = `${totalPosts} bài`;
        document.getElementById('summary-platforms').textContent = '3 nền tảng'; // Static as no input provided
        document.getElementById('summary-average-posts').textContent = `${averagePostsPerDay} bài`;
    }

    // Add event listeners to frequency inputs
    document.querySelectorAll('.frequency-input').forEach(input => {
        input.addEventListener('input', () => {
            updateTotalFrequency();
            updateCampaignSummary();
        });
    });

    // Add event listeners to frequency radio buttons
    document.querySelectorAll('input[name="frequency"]').forEach(radio => {
        radio.addEventListener('change', () => {
            const customFrequencyDiv = document.getElementById('custom-frequency');
            customFrequencyDiv.style.display = radio.value === 'custom' ? 'grid' : 'none';
            updateTotalFrequency();
            updateCampaignSummary();
        });
    });

    // Set initial visibility of custom frequency
    document.getElementById('custom-frequency').style.display = document.querySelector('input[name="frequency"]:checked').value === 'custom' ? 'grid' : 'none';

    // Initial calculations
    updateTotalFrequency();
    updateCampaignSummary();
</script>