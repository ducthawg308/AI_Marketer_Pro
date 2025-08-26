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

        @include('dashboard.auto_publisher.partials.normal-scheduling')
        @include('dashboard.auto_publisher.partials.campaign-scheduling')

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
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Page</th>
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
                                <!-- Page -->
                                <td class="px-4 py-4">
                                    <div class="flex space-x-2">
                                        <i class="fab fa-facebook text-blue-600"></i>
                                        <span class="text-gray-700">{{ $schedule->userPage->page_name }}</span>
                                    </div>
                                </td>
                                <!-- Thời gian đăng -->
                                <td class="px-4 py-4">
                                    <div class="text-gray-800">{{ \Carbon\Carbon::parse($schedule->scheduled_time)->format('d/m/Y H:i') }}</div>
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
                                        <button type="button" data-modal-target="edit-modal-{{ $schedule->id }}" data-modal-toggle="edit-modal-{{ $schedule->id }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors duration-200">
                                            Sửa
                                        </button>
                                        <button type="button" data-modal-target="delete-modal-{{ $schedule->id }}" data-modal-toggle="delete-modal-{{ $schedule->id }}" class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full hover:bg-red-200 transition-colors duration-200">
                                            Xóa
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal chỉnh sửa -->
                            <div id="edit-modal-{{ $schedule->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full bg-black bg-opacity-50">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-white rounded-xl shadow-2xl border border-gray-200">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-4">
                                                <h3 class="text-lg font-semibold text-gray-900">Chỉnh sửa lịch đăng</h3>
                                                <button data-modal-toggle="edit-modal-{{ $schedule->id }}" class="text-gray-400 hover:text-gray-600">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            <form action="{{ route('dashboard.auto_publisher.update', [$schedule->id]) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-4">
                                                    <label for="page_id_{{ $schedule->id }}" class="block text-sm font-medium text-gray-700 mb-1">Chọn Page</label>
                                                    <select id="page_id_{{ $schedule->id }}" name="page_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" required>
                                                        @foreach($user_pages as $page)
                                                            <option value="{{ $page->id }}" {{ $schedule->userPage->id == $page->id ? 'selected' : '' }}>{{ $page->page_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="ad_id_{{ $schedule->id }}" class="block text-sm font-medium text-gray-700 mb-1">Chọn bài viết</label>
                                                    <select id="ad_id_{{ $schedule->id }}" name="ad_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" required>
                                                        @foreach($ads as $ad)
                                                            <option value="{{ $ad->id }}" {{ $schedule->ad->id == $ad->id ? 'selected' : '' }}>{{ $ad->ad_title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="scheduled_time_{{ $schedule->id }}" class="block text-sm font-medium text-gray-700 mb-1">Thời gian đăng</label>
                                                    <input type="text" id="scheduled_time_{{ $schedule->id }}" name="scheduled_time" value="{{ \Carbon\Carbon::parse($schedule->scheduled_time)->format('d/m/Y H:i') }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500" data-datepicker required>
                                                </div>
                                                <div class="flex justify-end space-x-3">
                                                    <button type="button" data-modal-toggle="edit-modal-{{ $schedule->id }}" class="px-6 py-3 text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 font-medium transition-all duration-200">
                                                        Hủy
                                                    </button>
                                                    <button type="submit" class="px-6 py-3 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg transition-all duration-200">
                                                        Lưu thay đổi
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

            // Initialize Flatpickr for datepickers
            flatpickr("[data-datepicker]", {
                dateFormat: "d/m/Y H:i",
                enableTime: true,
                time_24hr: true,
                allowInput: false,
                minDate: "today"
            });
        });
    </script>
</x-app-dashboard>