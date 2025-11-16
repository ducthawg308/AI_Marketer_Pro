<x-app-dashboard>
    <div class="min-h-screen bg-primary-50 p-6">
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Thêm quyền truy cập mới</h2>
                    <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Quay lại
                    </a>
                </div>

                <form action="{{ route('admin.permissions.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Thông tin cơ bản -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-primary-600 mb-4">Thông tin quyền truy cập</h3>
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Tên quyền -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tên quyền <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    placeholder="VD: users.create, posts.edit, ..."
                                    required>
                                <p class="text-xs text-gray-500 mt-1">Sử dụng định dạng: module.action (VD: users.create, posts.edit)</p>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Guard Name -->
                            <div>
                                <label for="guard_name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Guard Name <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    id="guard_name" 
                                    name="guard_name" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    required>
                                    <option value="web" {{ old('guard_name') === 'web' ? 'selected' : '' }}>Web</option>
                                    <option value="api" {{ old('guard_name') === 'api' ? 'selected' : '' }}>API</option>
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Chọn guard phù hợp với ứng dụng của bạn</p>
                                @error('guard_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Mô tả chi tiết -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-primary-600 mb-4">Mô tả (Tùy chọn)</h3>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Mô tả chức năng
                            </label>
                            <textarea 
                                id="description" 
                                name="description" 
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                placeholder="Mô tả chi tiết về quyền này và chức năng của nó...">{{ old('description') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Giúp người quản lý hiểu rõ mục đích sử dụng quyền này</p>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <!-- Hướng dẫn -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-blue-800">
                                <h4 class="font-semibold mb-2">Quy tắc đặt tên quyền:</h4>
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    <li>Sử dụng chữ thường và dấu chấm (.) để phân cách</li>
                                    <li>Định dạng: <code class="bg-blue-100 px-1 py-0.5 rounded">module.action</code></li>
                                    <li>VD: users.view, users.create, users.edit, users.delete</li>
                                    <li>Tránh sử dụng ký tự đặc biệt và khoảng trắng</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Nút gửi -->
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Hủy
                        </a>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tạo quyền truy cập
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-dashboard>