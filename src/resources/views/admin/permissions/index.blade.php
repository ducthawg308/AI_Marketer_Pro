<x-app-dashboard title="Quản lý Quyền truy cập">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="p-6">
                <!-- Header với nút thêm -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Danh sách Quyền truy cập</h2>
                        <p class="text-sm text-gray-500 mt-1">Quản lý và cập nhật quyền truy cập hệ thống</p>
                    </div>
                    <a href="{{ route('admin.permissions.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Thêm mới
                    </a>
                </div>

                <!-- Thanh tìm kiếm -->
                <div class="mb-6">
                    <form action="#" method="GET" class="flex gap-2">
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="keyword"
                                name="keyword" 
                                value="{{ request('search') }}" 
                                class="block w-full pl-10 pr-3 py-2.5 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500" 
                                placeholder="Tìm kiếm theo tên quyền...">
                        </div>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 transition-colors">
                            Tìm kiếm
                        </button>
                        @if(request('keyword'))
                        <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 transition-colors">
                            Xóa lọc
                        </a>
                        @endif
                    </form>
                </div>

                <!-- Bảng danh sách -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-primary-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">STT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tên quyền</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Guard</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($permissions as $key => $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200" data-id="{{ $item->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $permissions->firstItem() + $key }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $item->id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 flex items-center justify-center rounded-full bg-primary-100">
                                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">
                                                    {{ $item->name }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('admin.permissions.show', $item->id) }}" class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors duration-200">
                                            {{ $item->guard_name }}
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.permissions.edit', $item->id) }}" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-600 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors duration-200" title="Chỉnh sửa">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button 
                                                type="button" 
                                                data-modal-target="confirm-delete-{{ $item->id }}" 
                                                data-modal-toggle="confirm-delete-{{ $item->id }}"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200" 
                                                title="Xóa">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal Xác nhận xóa -->
                                <div id="confirm-delete-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white absolute top-2 right-2" data-modal-hide="confirm-delete-{{ $item->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Bạn có muốn xóa quyền "{{ $item->name }}" không?</h3>
                                                <form action="{{ route('admin.permissions.destroy', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        Đúng, xóa nó!
                                                    </button>
                                                </form>
                                                <button data-modal-hide="confirm-delete-{{ $item->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Hủy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($permissions->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                        </svg>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có quyền truy cập nào</h3>
                                        <p class="text-gray-500 mb-4">
                                            @if(request('keyword'))
                                                Không tìm thấy kết quả phù hợp với từ khóa "{{ request('keyword') }}"
                                            @else
                                                Hãy thêm quyền truy cập đầu tiên của bạn!
                                            @endif
                                        </p>
                                        @if(request('keyword'))
                                        <a href="{{ route('admin.permissions.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                                            Xem tất cả quyền truy cập
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Phân trang -->
                @if($permissions->hasPages())
                    <div class="mt-6 flex items-center justify-center">
                        {{ $permissions->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-dashboard>