<x-app-dashboard>
    <div class="container mx-auto px-8 py-8">
        <!-- Header -->
        <header class="mb-8 bg-gradient-to-r from-white via-gray-50 to-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-3 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Thiết lập chiến dịch</h1>
                            <p class="text-base text-gray-600">Tạo chiến dịch tự động đăng bài theo lịch</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="{{ route('dashboard.auto_publisher.campaign.index') }}"
                            class="px-4 py-2 text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Quay lại</span>
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <form action="{{ route('dashboard.auto_publisher.campaign.store') }}" method="POST" class="divide-y divide-gray-200">
                @csrf

                <!-- Campaign Basics Section -->
                <div class="p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Thông tin cơ bản</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Tên chiến dịch *
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm"
                                placeholder="Ví dụ: Black Friday 2025" required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="objective" class="block text-sm font-medium text-gray-700 mb-2">
                                Mục tiêu chiến dịch
                            </label>
                            <select id="objective" name="objective"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm">
                                <option value="brand_awareness" {{ old('objective', 'brand_awareness') == 'brand_awareness' ? 'selected' : '' }}>Xây dựng nhận diện thương hiệu</option>
                                <option value="reach" {{ old('objective') == 'reach' ? 'selected' : '' }}>Reach</option>
                                <option value="engagement" {{ old('objective') == 'engagement' ? 'selected' : '' }}>Tăng tương tác</option>
                                <option value="traffic" {{ old('objective') == 'traffic' ? 'selected' : '' }}>Tăng traffic</option>
                                <option value="lead_generation" {{ old('objective') == 'lead_generation' ? 'selected' : '' }}>Sinh lead</option>
                                <option value="app_promotion" {{ old('objective') == 'app_promotion' ? 'selected' : '' }}>Quảng bá ứng dụng</option>
                                <option value="conversions" {{ old('objective') == 'conversions' ? 'selected' : '' }}>Chuyển đổi</option>
                                <option value="sales" {{ old('objective') == 'sales' ? 'selected' : '' }}>Tăng doanh số</option>
                                <option value="retention_loyalty" {{ old('objective') == 'retention_loyalty' ? 'selected' : '' }}>Giữ chân / Tính trung thành</option>
                                <option value="video_views" {{ old('objective') == 'video_views' ? 'selected' : '' }}>Xem video</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Mô tả chiến dịch
                        </label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm"
                            placeholder="Mô tả chi tiết về chiến dịch...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- Time Period Section -->
                <div class="p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Thời gian</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Ngày bắt đầu *
                            </label>
                            <input type="date" id="start_date" name="start_date" min="{{ date('Y-m-d') }}"
                                value="{{ old('start_date', date('Y-m-d')) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm"
                                required>
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Ngày kết thúc
                            </label>
                            <input type="date" id="end_date" name="end_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                value="{{ old('end_date', date('Y-m-d', strtotime('+1 month'))) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm">
                            <p class="mt-2 text-sm text-gray-500">Để trống nếu chiến dịch vô hạn</p>
                        </div>
                    </div>
                </div>

                <!-- Platform Selection -->
                <div class="p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Nền tảng mạng xã hội</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($userPages as $page)
                            <div class="flex items-center p-4 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 transition-colors duration-200">
                                <input id="page_{{ $page->id }}" name="platforms[]" type="checkbox" value="{{ $page->id }}"
                                    class="w-5 h-5 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500">
                                <label for="page_{{ $page->id }}" class="w-full ml-3 text-sm font-medium text-gray-900 flex items-center">
                                    <img src="{{ $page->avatar_url ?: '/images/logo.png' }}" alt="{{ $page->page_name }}"
                                        class="w-10 h-10 mr-3 rounded-full border-2 border-white shadow-sm">
                                    <div>
                                        <div class="font-medium">{{ $page->page_name }}</div>
                                        <div class="text-xs text-gray-500">{{ number_format($page->fan_count) }} followers</div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('platforms')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Frequency Settings -->
                <div class="p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Tần suất đăng bài</h2>
                    </div>

                    <!-- Frequency Type Selection -->
                    <fieldset class="grid grid-cols-3 gap-6">
                        <div>
                            <input id="frequency-daily" type="radio" name="frequency" value="daily" class="w-4 h-4 border-gray-200 focus:ring-2 checked:bg-primary-600 dark:border-gray-600 dark:bg-gray-700" checked>
                            <label for="frequency-daily" class="w-full ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Hàng ngày
                            </label>
                        </div>
                        <div>
                            <input id="frequency-weekly" type="radio" name="frequency" value="weekly" class="w-4 h-4 border-gray-200 focus:ring-2 checked:bg-primary-600 dark:border-gray-600 dark:bg-gray-700">
                            <label for="frequency-weekly" class="w-full ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Hàng tuần
                            </label>
                        </div>
                        <div>
                            <input id="frequency-custom" type="radio" name="frequency" value="custom" class="w-4 h-4 border-gray-200 focus:ring-2 checked:bg-primary-600 dark:border-gray-600 dark:bg-gray-700">
                            <label for="frequency-custom" class="w-full ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                Tùy chỉnh
                            </label>
                        </div>
                    </fieldset>

                    <!-- Daily Configuration -->
                    <div id="daily_options" class="mt-4 space-y-4">
                        <div>
                            <label for="posts_per_day" class="block text-sm font-medium text-gray-700 mb-2">
                                Số bài đăng mỗi ngày
                            </label>
                            <input type="number" id="posts_per_day" name="frequency_config[posts_per_day]" value="1" min="1" max="10"
                                class="w-full max-w-xs px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm">
                        </div>
                    </div>

                    <!-- Weekly Configuration -->
                    <div id="weekly_options" class="mt-4 space-y-4 hidden">
                        <div>
                            <label for="posts_per_week" class="block text-sm font-medium text-gray-700 mb-2">
                                Số bài đăng mỗi tuần
                            </label>
                            <input type="number" id="posts_per_week" name="frequency_config[posts_per_week]" value="3" min="1" max="20"
                                class="w-full max-w-xs px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm">
                        </div>

                        <fieldset>
                            <legend class="block text-sm font-medium text-gray-700 mb-2">Chọn ngày đăng trong tuần</legend>
                            <div class="grid grid-cols-7 gap-2">
                                @for($i = 1; $i <= 7; $i++)
                                    <div class="flex items-center">
                                        <input id="day_{{ $i }}" name="frequency_config[selected_days][]" type="checkbox" value="{{ $i }}"
                                            class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500"
                                            @if($i == 2) checked @endif>
                                        <label for="day_{{ $i }}" class="w-full ml-3 text-sm font-medium text-gray-700">
                                            {{ ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'][$i-1] }}
                                        </label>
                                    </div>
                                @endfor
                            </div>
                        </fieldset>
                    </div>

                    <!-- Custom Configuration -->
                    <div id="custom_options" class="mt-4 space-y-4 hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-4">
                            Số bài đăng mỗi ngày trong tuần
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach(['monday' => 'Thứ Hai', 'tuesday' => 'Thứ Ba', 'wednesday' => 'Thứ Tư', 'thursday' => 'Thứ Năm', 'friday' => 'Thứ Sáu', 'saturday' => 'Thứ Bảy', 'sunday' => 'Chủ Nhật'] as $key => $label)
                                <div>
                                    <label for="custom_{{ $key }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $label }}
                                    </label>
                                    <input type="number" id="custom_{{ $key }}" name="frequency_config[days][{{ $key }}]" value="0" min="0" max="10"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm text-center">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @error('frequency')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Settings -->
                <div class="p-8 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">Cài đặt thời gian</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="default_time_start" class="block text-sm font-medium text-gray-700 mb-2">
                                Giờ bắt đầu mặc định
                            </label>
                            <input type="time" id="default_time_start" name="default_time_start" value="08:00"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm">
                        </div>

                        <div>
                            <label for="default_time_end" class="block text-sm font-medium text-gray-700 mb-2">
                                Giờ kết thúc mặc định
                            </label>
                            <input type="time" id="default_time_end" name="default_time_end" value="20:00"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 shadow-sm">
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="p-8 bg-gray-50 flex justify-end space-x-4">
                    <a href="{{ route('dashboard.auto_publisher.campaign.index') }}"
                        class="px-6 py-3 text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Hủy bỏ
                    </a>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-xl hover:from-primary-600 hover:to-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        Tiếp tục tạo roadmap
                    </button>
                </div>
            </form>
        </div>

        <!-- Modal Thông báo -->
        <div id="alert-modal" tabindex="-1" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-6">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                    <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Thông báo</h3>
                        </div>
                    </div>

                    <div class="p-6">
                        <p id="alert-message" class="text-gray-600 mb-6">Vui lòng chọn ít nhất 1 Page để đăng bài!</p>

                        <div class="flex justify-end">
                            <button type="button" onclick="closeAlertModal()" class="px-6 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105">
                                OK
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showAlertModal(message) {
            document.getElementById('alert-message').textContent = message;
            document.getElementById('alert-modal').classList.remove('hidden');
        }

        function closeAlertModal() {
            document.getElementById('alert-modal').classList.add('hidden');
        }

        // Initialize datepickers
        const frequencyRadios = document.querySelectorAll('input[name="frequency"]');
        const options = {
            daily: document.getElementById('daily_options'),
            weekly: document.getElementById('weekly_options'),
            custom: document.getElementById('custom_options')
        };

        function toggleFrequencyOptions() {
            Object.values(options).forEach(option => option.classList.add('hidden'));
            const selected = document.querySelector('input[name="frequency"]:checked').value;
            options[selected].classList.remove('hidden');
        }

        frequencyRadios.forEach(radio => radio.addEventListener('change', toggleFrequencyOptions));
        toggleFrequencyOptions();

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const pages = document.querySelectorAll('input[name="platforms[]"]:checked');
            if (pages.length === 0) {
                e.preventDefault();
                showAlertModal('Vui lòng chọn ít nhất 1 Page để đăng bài!');
                return false;
            }
        });
    </script>
</x-app-dashboard>
