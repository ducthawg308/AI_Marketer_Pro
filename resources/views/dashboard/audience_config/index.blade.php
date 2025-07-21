<x-app-dashboard>
    <div class="min-h-screen bg-primary-50 p-6">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold text-primary-600 mb-6">Nhập Thông Tin Nghiên Cứu</h2>
            <form action="{{ route('research.store') }}" method="POST">
                @csrf
                <!-- Tên sản phẩm/dịch vụ -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm/dịch vụ</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Ngành nghề -->
                <div class="mb-4">
                    <label for="industry" class="block text-sm font-medium text-gray-700">Ngành nghề</label>
                    <select id="industry" name="industry" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" required>
                        <option value="">Chọn ngành nghề</option>
                        <option value="fashion">Thời trang</option>
                        <option value="technology">Công nghệ</option>
                        <option value="food">Thực phẩm</option>
                        <option value="other">Khác</option>
                    </select>
                    @error('industry') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Mô tả ngắn gọn -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Mô tả ngắn gọn</label>
                    <textarea id="description" name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm"></textarea>
                    @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Đặc điểm khách hàng mục tiêu -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-primary-600 mb-2">Khách hàng mục tiêu</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="age_range" class="block text-sm font-medium text-gray-700">Độ tuổi</label>
                            <input type="text" id="age_range" name="age_range" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: 18-25">
                            @error('age_range') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="income_level" class="block text-sm font-medium text-gray-700">Mức thu nhập</label>
                            <input type="text" id="income_level" name="income_level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Trung bình">
                            @error('income_level') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="interests" class="block text-sm font-medium text-gray-700">Sở thích</label>
                            <input type="text" id="interests" name="interests" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="Ví dụ: Thể thao, Công nghệ">
                            @error('interests') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Đối thủ cạnh tranh -->
                <div class="mb-4">
                    <h3 class="text-lg font-semibold text-primary-600 mb-2">Đối thủ cạnh tranh (Tùy chọn)</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="competitor_name" class="block text-sm font-medium text-gray-700">Tên đối thủ</label>
                            <input type="text" id="competitor_name" name="competitor_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm">
                            @error('competitor_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="competitor_url" class="block text-sm font-medium text-gray-700">URL đối thủ</label>
                            <input type="url" id="competitor_url" name="competitor_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm" placeholder="https://">
                            @error('competitor_url') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="competitor_description" class="block text-sm font-medium text-gray-700">Mô tả đối thủ</label>
                            <textarea id="competitor_description" name="competitor_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-primary-600 focus:border-primary-600 sm:text-sm"></textarea>
                            @error('competitor_description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Nút gửi -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600">Lưu Thông Tin</button>
                </div>
            </form>
        </div>
    </div>
</x-app-dashboard>