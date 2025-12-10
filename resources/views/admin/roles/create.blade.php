<x-app-dashboard>
    <div class="min-h-screen bg-primary-50 p-6">
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Thêm vai trò mới</h2>
                    <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Quay lại
                    </a>
                </div>

                <form action="{{ route('admin.roles.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Thông tin cơ bản -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-primary-600 mb-4">Thông tin vai trò</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Tên hiển thị (description) -->
                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tên hiển thị <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="description" 
                                    name="description" 
                                    value="{{ old('description') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('description') border-red-500 @enderror" 
                                    placeholder="Ví dụ: Quản trị viên, Người quản lý"
                                    required
                                    autofocus>
                                <p class="text-xs text-gray-500 mt-1">Tên hiển thị của vai trò (có dấu, dễ đọc)</p>
                                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Mã vai trò (name) -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Mã vai trò <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors @error('name') border-red-500 @enderror" 
                                    placeholder="Ví dụ: admin, manager, user"
                                    required>
                                <p class="text-xs text-gray-500 mt-1">Mã định danh của vai trò (slug, không dấu, viết thường)</p>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Phân quyền theo chức năng -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-primary-600 mb-4">Gán quyền</h3>
                        <p class="text-sm text-gray-600 mb-4">Chọn các chức năng mà vai trò này sẽ truy cập được</p>

                        <div class="mb-4">
                            <label class="inline-flex items-center cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="all_features"
                                    id="all_features"
                                    class="w-4 h-4 rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">Chọn tất cả chức năng</span>
                            </label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($features as $key => $feature)
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input
                                        type="checkbox"
                                        id="features[{{ $key }}]"
                                        name="features[]"
                                        value="{{ $key }}"
                                        class="feature w-4 h-4 rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500"
                                        {{ in_array($key, old('features', [])) ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3 flex-1">
                                    <label for="features[{{ $key }}]" class="text-sm font-medium text-gray-700 cursor-pointer">
                                        {{ $feature['name'] }}
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ count($feature['permissions']) }} quyền liên quan
                                    </p>
                                    <details class="mt-2">
                                        <summary class="text-xs text-primary-600 cursor-pointer hover:text-primary-700">
                                            Xem chi tiết quyền
                                        </summary>
                                        <ul class="mt-1 ml-2 space-y-1">
                                            @foreach($feature['permissions'] as $permission)
                                            <li class="text-xs text-gray-600">• {{ $permission }}</li>
                                            @endforeach
                                        </ul>
                                    </details>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @error('features') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Thông tin bổ sung -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Lưu ý khi tạo vai trò</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Tên hiển thị là tên có dấu cho người dùng</li>
                                        <li>Mã vai trò là định danh hệ thống, không dấu, không khoảng trắng</li>
                                        <li>Chọn quyền phù hợp với chức năng của vai trò</li>
                                        <li>Có thể chọn tất cả quyền bằng checkbox ở trên</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nút gửi -->
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Hủy
                        </a>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Lưu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

   <script>
        document.addEventListener('DOMContentLoaded', function() {
            const allFeaturesCheckbox = document.querySelector('[name="all_features"]');
            const featureCheckboxes = document.querySelectorAll('.feature');

            if (allFeaturesCheckbox) {
                allFeaturesCheckbox.addEventListener('click', function() {
                    const isChecked = this.checked;
                    featureCheckboxes.forEach(function(checkbox) {
                        checkbox.checked = isChecked;
                    });
                });

                featureCheckboxes.forEach(function(checkbox) {
                    checkbox.addEventListener('change', function() {
                        const allChecked = Array.from(featureCheckboxes).every(cb => cb.checked);
                        allFeaturesCheckbox.checked = allChecked;
                    });
                });
            }
        });
    </script>
</x-app-dashboard>
