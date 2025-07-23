<x-app-dashboard>
    <div class="min-h-screen bg-primary-50 p-6">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-900">Thêm đối tượng mục tiêu</h2>
                    <a href="{{ route('dashboard.audienceconfig.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Quay lại
                    </a>
                </div>
                <form action="{{ route('dashboard.audienceconfig.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <!-- Tên sản phẩm/dịch vụ -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm/dịch vụ</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" required>
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Ngành nghề -->
                    <div>
                        <label for="industry" class="block text-sm font-medium text-gray-700">Ngành nghề</label>
                        <select id="industry" name="industry" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" required>
                            <option value="">Chọn ngành nghề</option>
                            <option value="fashion" {{ old('industry') === 'fashion' ? 'selected' : '' }}>Thời trang</option>
                            <option value="technology" {{ old('industry') === 'technology' ? 'selected' : '' }}>Công nghệ</option>
                            <option value="food" {{ old('industry') === 'food' ? 'selected' : '' }}>Thực phẩm</option>
                            <option value="other" {{ old('industry') === 'other' ? 'selected' : '' }}>Khác</option>
                        </select>
                        @error('industry') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Mô tả ngắn gọn -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Mô tả ngắn gọn</label>
                        <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Đặc điểm khách hàng mục tiêu -->
                    <div>
                        <h3 class="text-lg font-semibold text-primary-600 mb-2">Khách hàng mục tiêu</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="target_customer_age_range" class="block text-sm font-medium text-gray-700">Độ tuổi</label>
                                <input type="text" id="target_customer_age_range" name="target_customer_age_range" value="{{ old('target_customer_age_range') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: 18-25">
                                @error('target_customer_age_range') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="target_customer_income_level" class="block text-sm font-medium text-gray-700">Mức thu nhập</label>
                                <input type="text" id="target_customer_income_level" name="target_customer_income_level" value="{{ old('target_customer_income_level') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Trung bình">
                                @error('target_customer_income_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="target_customer_interests" class="block text-sm font-medium text-gray-700">Sở thích</label>
                                <input type="text" id="target_customer_interests" name="target_customer_interests" value="{{ old('target_customer_interests') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Thể thao, Công nghệ">
                                @error('target_customer_interests') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Đối thủ cạnh tranh -->
                    <div>
                        <h3 class="text-lg font-semibold text-primary-600 mb-2">Đối thủ cạnh tranh (Tùy chọn)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="competitor_name" class="block text-sm font-medium text-gray-700">Tên đối thủ</label>
                                <input type="text" id="competitor_name" name="competitor_name" value="{{ old('competitor_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">
                                @error('competitor_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="competitor_url" class="block text-sm font-medium text-gray-700">URL đối thủ</label>
                                <input type="url" id="competitor_url" name="competitor_url" value="{{ old('competitor_url') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="https://">
                                @error('competitor_url') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label for="competitor_description" class="block text-sm font-medium text-gray-700">Mô tả đối thủ</label>
                                <textarea id="competitor_description" name="competitor_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">{{ old('competitor_description') }}</textarea>
                                @error('competitor_description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Nút gửi -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Lưu Thông Tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-dashboard>