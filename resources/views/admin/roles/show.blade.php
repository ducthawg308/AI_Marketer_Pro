<x-app-dashboard>
    <div class="min-h-screen bg-primary-50 p-6">
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Chi tiết vai trò</h2>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.roles.edit', $role->id) }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Chỉnh sửa
                        </a>
                        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Quay lại
                        </a>
                    </div>
                </div>

                <!-- Thông tin cơ bản -->
                <div class="border-b pb-6">
                    <h3 class="text-lg font-semibold text-primary-600 mb-4">Thông tin vai trò</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- ID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID</label>
                            <div class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-900">
                                {{ $role->id }}
                            </div>
                        </div>

                        <!-- Mã vai trò -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Mã vai trò</label>
                            <div class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-900">
                                {{ $role->name }}
                            </div>
                        </div>

                        <!-- Tên hiển thị -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tên hiển thị</label>
                            <div class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-900">
                                {{ $role->description ?? '-' }}
                            </div>
                        </div>

                        <!-- Guard Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Guard Name</label>
                            <div class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-900">
                                {{ $role->guard_name }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danh sách quyền -->
                <div class="border-b pb-6 mt-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-primary-600">Quyền đã gán</h3>
                        <span class="px-3 py-1 bg-primary-100 text-primary-800 text-sm font-medium rounded-full">
                            {{ $rolePermissions->count() }} quyền
                        </span>
                    </div>
                    
                    @if($rolePermissions->isEmpty())
                        <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600">Vai trò này chưa được gán quyền nào</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($rolePermissions as $permission)
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200 hover:border-primary-300 hover:bg-primary-50 transition-colors">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $permission->name }}
                                    </p>
                                    @if($permission->description)
                                    <p class="text-xs text-gray-500 mt-1">{{ $permission->description }}</p>
                                    @endif
                                    <p class="text-xs text-gray-400 mt-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-200 text-gray-800">
                                            {{ $permission->guard_name }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Thông tin hệ thống -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mt-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Thông tin hệ thống</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-gray-600">Tạo lúc:</span>
                            <p class="text-gray-900 font-medium">{{ $role->created_at ? $role->created_at->format('d/m/Y H:i:s') : '-' }}</p>
                        </div>
                        <div>
                            <span class="text-gray-600">Cập nhật lúc:</span>
                            <p class="text-gray-900 font-medium">{{ $role->updated_at ? $role->updated_at->format('d/m/Y H:i:s') : '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Thống kê -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-blue-800">Tổng quyền</p>
                                <p class="text-2xl font-bold text-blue-900">{{ $rolePermissions->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-green-800">Trạng thái</p>
                                <p class="text-lg font-bold text-green-900">Hoạt động</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-purple-800">Guard</p>
                                <p class="text-lg font-bold text-purple-900">{{ $role->guard_name }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="flex justify-end gap-3 pt-6 mt-6 border-t">
                    <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Quay lại
                    </a>
                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Chỉnh sửa
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-dashboard>