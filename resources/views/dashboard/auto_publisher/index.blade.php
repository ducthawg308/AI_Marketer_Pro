<x-app-dashboard>
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Header -->
        <header class="mb-8 bg-gradient-to-r from-white via-gray-50 to-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-3 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Tổng quan lịch đăng bài</h1>
                            <p class="text-base text-gray-600">Xem và quản lý các bài viết đã lên lịch cho mạng xã hội</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigation Buttons -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('dashboard.auto_publisher.normal') }}" class="group flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-4 bg-primary-600 text-white rounded-2xl hover:bg-primary-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-base">Lên lịch bình thường</div>
                            <div class="text-primary-200 text-sm">Tạo lịch đăng đơn giản</div>
                        </div>
                    </div>
                </a>
                <a href="{{ route('dashboard.auto_publisher.campaign') }}" class="group flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-2xl hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center group-hover:bg-white/30 transition-all duration-300">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.894A1 1 0 0018 16V3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-base">Lên lịch theo chiến dịch</div>
                            <div class="text-blue-200 text-sm">Quản lý chiến dịch marketing</div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Scheduled Posts Overview -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Bài viết đã lên lịch
                </h2>
                <div class="flex space-x-3">
                    <button class="px-4 py-2 text-sm border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Lọc
                    </button>
                    <button class="px-4 py-2 text-sm bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
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
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Page</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Thời gian đăng</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Trạng thái</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($scheduledAds as $schedule)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 2h6v4H7V5zm0 6h6v2H7v-2zm-3 2h2v2H4v-2zm9 2h2v-2h-2v2z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $schedule->ad->ad_title }}</div>
                                        <div class="text-gray-600 text-xs">{{ \Str::limit($schedule->ad->ad_content, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-700">{{ $schedule->userPage->page_name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-gray-800">{{ \Carbon\Carbon::parse($schedule->scheduled_time)->format('d/m/Y H:i') }}</td>
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
                            <td class="px-4 py-4">
                                <div class="flex space-x-2">
                                    <button type="button" data-modal-target="edit-modal-{{ $schedule->id }}" data-modal-toggle="edit-modal-{{ $schedule->id }}" class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200">
                                        Sửa
                                    </button>
                                    <button type="button" data-modal-target="delete-modal-{{ $schedule->id }}" data-modal-toggle="delete-modal-{{ $schedule->id }}" class="px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full hover:bg-red-200">
                                        Xóa
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Edit Modal -->
                        <div id="edit-modal-{{ $schedule->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto">
                            <div class="relative p-6 w-full max-w-2xl">
                                <div class="bg-white rounded-2xl shadow-2xl transform transition-all duration-300">
                                    <div class="p-6">
                                        <div class="flex items-center justify-between mb-6 bg-gradient-to-r from-gray-50 to-white rounded-t-2xl p-4">
                                            <h3 class="text-xl font-bold text-gray-900">Chỉnh sửa lịch đăng</h3>
                                            <button type="button" data-modal-toggle="edit-modal-{{ $schedule->id }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                        <form action="{{ route('dashboard.auto_publisher.update', [$schedule->id]) }}" method="POST" class="space-y-6">
                                            @csrf
                                            @method('PATCH')
                                            <div class="mb-4">
                                                <label for="page_id_{{ $schedule->id }}" class="block text-sm font-medium text-gray-700 mb-2">Chọn Page</label>
                                                <select id="page_id_{{ $schedule->id }}" name="page_id" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200" required>
                                                    @foreach($user_pages as $page)
                                                    <option value="{{ $page->id }}" {{ $schedule->userPage->id == $page->id ? 'selected' : '' }}>{{ $page->page_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label for="ad_id_{{ $schedule->id }}" class="block text-sm font-medium text-gray-700 mb-2">Chọn bài viết</label>
                                                <select id="ad_id_{{ $schedule->id }}" name="ad_id" class="w-full max-w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200 truncate" required>
                                                    @foreach($ads as $ad)
                                                    <option value="{{ $ad->ad_id }}" {{ $schedule->ad->id == $ad->id ? 'selected' : '' }} title="{{ $ad->ad_title }}">{{ \Illuminate\Support\Str::limit($ad->ad_title, 60, '...') }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-6">
                                                <label for="scheduled_time_{{ $schedule->id }}" class="block text-sm font-medium text-gray-700 mb-2">Thời gian đăng</label>
                                                <input type="text" id="scheduled_time_{{ $schedule->id }}" name="scheduled_time" value="{{ \Carbon\Carbon::parse($schedule->scheduled_time)->format('d/m/Y H:i') }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200" data-datepicker data-datepicker-format="dd/mm/yyyy HH:MM" placeholder="Chọn ngày giờ đăng" required>
                                            </div>
                                            <div class="flex justify-end space-x-4">
                                                <button type="button" data-modal-toggle="edit-modal-{{ $schedule->id }}" class="px-6 py-2 text-gray-700 border border-gray-300 rounded-xl hover:bg-gray-50 transition-colors duration-200">Hủy</button>
                                                <button type="submit" class="px-6 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors duration-200">Lưu thay đổi</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Delete Modal -->
                        <div id="delete-modal-{{ $schedule->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                            <div class="relative p-4 w-full max-w-md">
                                <div class="bg-white rounded-lg shadow-lg">
                                    <div class="p-6 text-center">
                                        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="mb-4 text-lg font-semibold text-gray-900">Xác nhận xóa</h3>
                                        <p class="mb-4 text-gray-600">Bạn có chắc muốn xóa bài viết "<span class="font-medium">{{ $schedule->ad->ad_title }}</span>"?</p>
                                        <div class="flex justify-center space-x-3">
                                            <button data-modal-toggle="delete-modal-{{ $schedule->id }}" class="px-4 py-2 text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50">Hủy</button>
                                            <form action="{{ route('dashboard.auto_publisher.destroy', [$schedule->id]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Xác nhận xóa</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @if($scheduledAds->isEmpty())
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-600">Chưa có bài viết đã lên lịch nào.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-dashboard>

<script>
    document.querySelectorAll('[data-datepicker]').forEach(input => {
        flatpickr(input, {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            minDate: "today",
            defaultDate: input.value || new Date(),
            time_24hr: true,
            minuteIncrement: 1,
            locale: "vn",
            onChange: function(selectedDates, dateStr, instance) {
                instance.input.value = dateStr;
            }
        });
    });
</script>