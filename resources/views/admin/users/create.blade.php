<x-app-dashboard>
    <div class="min-h-screen bg-primary-50 p-6">
        <div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Thêm người dùng mới</h2>
                    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Quay lại
                    </a>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Thông tin cơ bản -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-primary-600 mb-4">Thông tin cơ bản</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Tên người dùng -->
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tên người dùng <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    id="name" 
                                    name="name" 
                                    value="{{ old('name') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    placeholder="Nhập tên người dùng"
                                    required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    placeholder="email@example.com"
                                    required>
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Mật khẩu -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    Mật khẩu <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    id="password" 
                                    name="password" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    placeholder="Nhập mật khẩu"
                                    required>
                                <p class="text-xs text-gray-500 mt-1">Tối thiểu 8 ký tự</p>
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Xác nhận mật khẩu -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                    Xác nhận mật khẩu <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="password" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    placeholder="Xác nhận mật khẩu"
                                    required>
                                @error('password_confirmation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Vai trò -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                                    Vai trò <span class="text-red-500">*</span>
                                </label>

                                <select 
                                    id="role" 
                                    name="role" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    required>
                                    <option value="">Chọn vai trò</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" 
                                            {{ old('role') === $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('role') 
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
                                @enderror
                            </div>

                            <!-- Email đã xác thực -->
                            <div class="flex items-center pt-2">
                                <label for="email_verified" class="flex items-center cursor-pointer">
                                    <input 
                                        type="checkbox" 
                                        id="email_verified" 
                                        name="email_verified" 
                                        value="1" 
                                        {{ old('email_verified') ? 'checked' : '' }}
                                        class="w-4 h-4 rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500">
                                    <span class="ml-2 text-sm text-gray-700">Email đã được xác thực</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Đăng nhập mạng xã hội -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-primary-600 mb-4">Tài khoản mạng xã hội (Tùy chọn)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Google ID -->
                            <div>
                                <label for="google_id" class="block text-sm font-medium text-gray-700 mb-1">Google ID</label>
                                <input 
                                    type="text" 
                                    id="google_id" 
                                    name="google_id" 
                                    value="{{ old('google_id') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    placeholder="ID từ Google OAuth">
                                @error('google_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Facebook ID -->
                            <div>
                                <label for="facebook_id" class="block text-sm font-medium text-gray-700 mb-1">Facebook ID</label>
                                <input 
                                    type="text" 
                                    id="facebook_id" 
                                    name="facebook_id" 
                                    value="{{ old('facebook_id') }}" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors" 
                                    placeholder="ID từ Facebook OAuth">
                                @error('facebook_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Facebook Access Token -->
                            <div class="md:col-span-2">
                                <label for="facebook_access_token" class="block text-sm font-medium text-gray-700 mb-1">Facebook Access Token</label>
                                <textarea 
                                    id="facebook_access_token" 
                                    name="facebook_access_token" 
                                    rows="2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 transition-colors font-mono text-xs" 
                                    placeholder="Token từ Facebook OAuth"></textarea>
                                @error('facebook_access_token') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Nút gửi -->
                    <div class="flex justify-end gap-3 pt-2">
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                            Hủy
                        </a>
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-6 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Tạo người dùng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-dashboard>