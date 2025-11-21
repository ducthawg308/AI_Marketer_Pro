<x-app-dashboard>
    <div class="container mx-auto px-8 py-8">
        <!-- Header -->
        <header class="mb-8 bg-gradient-to-r from-white via-gray-50 to-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.894A1 1 0 0018 16V3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-3 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Danh sách chiến dịch</h1>
                            <p class="text-base text-gray-600">Quản lý các chiến dịch tự động đăng bài theo lịch</p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.auto_publisher.campaign.create') }}"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">Tạo chiến dịch mới</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Campaigns Table -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4V3a2 2 0 00-2-2H7a2 2 0 00-2 2v4a2 2 0 002 2h10a2 2 0 002-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 15a2 2 0 012-2h6a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4z"></path>
                    </svg>
                    Các chiến dịch của bạn
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Tên chiến dịch</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Trạng thái</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Thời gian</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Tần suất</th>
                            <th class="px-4 py-3 text-left font-medium text-gray-700">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($items as $campaign)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.894A1 1 0 0018 16V3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800" title="{{ $campaign->name }}">{{ Str::limit($campaign->name, 50) }}</div>
                                            <div class="text-gray-600 text-xs" title="{{ $campaign->description ?? 'Không có mô tả' }}">{{ Str::limit($campaign->description ?? 'Không có mô tả', 80) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    @if($campaign->status == 'draft')
                                        <span class="px-3 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Nháp</span>
                                    @elseif($campaign->status == 'running')
                                        <span class="px-3 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Đang chạy</span>
                                    @elseif($campaign->status == 'completed')
                                        <span class="px-3 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Hoàn thành</span>
                                    @elseif($campaign->status == 'stopped')
                                        <span class="px-3 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Đã dừng</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Không xác định</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-gray-800">
                                    <div>{{ $campaign->start_date->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">
                                        @if($campaign->end_date)
                                            Đến {{ $campaign->end_date->format('d/m/Y') }}
                                        @else
                                            Không giới hạn
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-gray-600">
                                    <div class="capitalize">{{ $campaign->frequency_type }}</div>
                                    <div class="text-xs">{{ $campaign->platforms ? count($campaign->platforms) : 0 }} pages</div>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex space-x-2">
                                        @if($campaign->status == 'draft')
                                            <a href="{{ route('dashboard.auto_publisher.campaign.roadmap', $campaign->id) }}"
                                               class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full hover:bg-blue-200 transition-colors">
                                                Xem roadmap
                                            </a>
                                        @else
                                            <span class="px-3 py-1 text-xs font-medium text-gray-500 bg-gray-100 rounded-full">Đang chạy</span>
                                        @endif

                                        <button type="button" onclick="showDeleteModal({{ $campaign->id }}, '{{ $campaign->name }}')" class="px-3 py-1 text-xs font-medium text-red-600 bg-red-100 rounded-full hover:bg-red-200 transition-colors">
                                            Xóa
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div id="delete-modal-{{ $campaign->id }}" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 overflow-y-auto">
                                <div class="relative p-6 w-full max-w-2xl">
                                    <div class="bg-white rounded-2xl shadow-2xl transform transition-all duration-300">
                                        <div class="p-6">
                                            <div class="flex items-center justify-between mb-6 bg-gradient-to-r from-gray-50 to-white rounded-t-2xl p-4">
                                                <h3 class="text-xl font-bold text-gray-900">Xác nhận xóa</h3>
                                                <button type="button" data-modal-toggle="delete-modal-{{ $campaign->id }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>

                                            <div class="flex items-center mb-6">
                                                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mr-4">
                                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-bold text-gray-900 mb-1">Bạn có chắc muốn xóa?</h4>
                                                    <p class="text-gray-600">Chiến dịch "<span class="font-semibold text-gray-900">{{ $campaign->name }}</span>" và tất cả lịch đăng liên quan sẽ bị xóa vĩnh viễn.</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center space-x-4 p-4 bg-red-50 rounded-xl">
                                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                <p class="text-sm text-red-800 font-medium">Hành động này không thể khôi phục!</p>
                                            </div>

                                            <div class="flex justify-end space-x-4 mt-6">
                                                <button type="button" data-modal-toggle="delete-modal-{{ $campaign->id }}" class="px-6 py-3 text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200 flex items-center">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Hủy bỏ
                                                </button>
                                                <form action="{{ route('dashboard.auto_publisher.campaign.destroy', [$campaign->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
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
                                <td colspan="5" class="px-4 py-12 text-center">
                                    <div class="w-16 h-16 bg-gradient-to-r from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4V3a2 2 0 00-2-2H7a2 2 0 00-2 2v4a2 2 0 002 2h10a2 2 0 002-2z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 15a2 2 0 012-2h6a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có chiến dịch nào</h3>
                                    <p class="text-gray-500 mb-4">Hãy tạo chiến dịch đầu tiên để bắt đầu tự động đăng bài theo lịch</p>
                                    <a href="{{ route('dashboard.auto_publisher.campaign.create') }}"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Tạo chiến dịch đầu tiên
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                @if($items->hasPages())
                    <div class="mt-6 flex items-center justify-center">
                        {{ $items->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Delete confirmation form -->
        <form id="delete-form" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>


    <!-- Modal Xác nhận xóa -->
    <div id="delete-confirm-modal" tabindex="-1" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-6">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
                <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-red-50 to-white">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Xác nhận xóa chiến dịch</h3>
                            <p class="text-sm text-gray-600 mt-1">Hành động này không thể khôi phục</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <p id="delete-confirm-message" class="text-gray-700 mb-6">Bạn có chắc muốn xóa chiến dịch này?</p>

                    <div class="flex items-center space-x-4 p-4 bg-red-50 rounded-xl">
                        <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <p class="text-sm text-red-800 font-medium">Chiến dịch và tất cả dữ liệu liên quan sẽ bị xóa hoàn toàn!</p>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" onclick="closeDeleteModal()" class="px-6 py-3 text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Hủy bỏ
                        </button>
                        <button type="button" onclick="executeDelete()" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Xác nhận xóa
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteId = null;
        let deleteName = null;

        function showDeleteModal(id, name) {
            deleteId = id;
            deleteName = name;
            document.getElementById('delete-confirm-message').textContent =
                `Bạn có chắc muốn xóa chiến dịch "${name}"? Tất cả dữ liệu lịch đăng sẽ bị xóa hoàn toàn.`;
            document.getElementById('delete-confirm-modal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('delete-confirm-modal').classList.add('hidden');
            deleteId = null;
            deleteName = null;
        }

        function executeDelete() {
            if (deleteId) {
                const form = document.getElementById('delete-form');
                form.action = `{{ url('dashboard/auto_publisher/campaign') }}/${deleteId}`;
                form.submit();
            }
        }
    </script>

    <!-- Make functions globally available -->
    <script>
        window.showDeleteModal = showDeleteModal;
        window.closeDeleteModal = closeDeleteModal;
        window.executeDelete = executeDelete;
    </script>
</x-app-dashboard>
