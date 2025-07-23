<x-app-dashboard>
    <div class="p-6 sm:p-8 bg-gray-100 dark:bg-gray-900 min-h-screen">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Khởi tạo Content AI</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Tạo và quản lý nội dung quảng cáo tự động với AI</p>
        </div>

        <!-- Form tạo content AI -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-8">
            <form action="{{ route('dashboard.aicreator.store') }}" method="POST" class="space-y-6" id="create-content-form">
                @csrf
                <!-- Nút mở modal AI Settings -->
                <div>
                    <button type="button" data-modal-target="ai-settings-modal" data-modal-toggle="ai-settings-modal"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                        Cài đặt AI
                    </button>
                </div>

                <!-- Thông tin cơ bản -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Thông tin nội dung</h3>
                    <div>
                        <label for="ad_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tiêu đề quảng cáo</label>
                        <input type="text" name="ad_title" id="ad_title" value="{{ old('ad_title') }}"
                            class="mt-1 block w-full rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-primary-500 focus:border-primary-500 p-2.5"
                            placeholder="Nhập tiêu đề quảng cáo...">
                        @error('ad_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Chọn sản phẩm</label>
                        <select name="product_id" id="product_id"
                            class="mt-1 block w-full rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-primary-500 focus:border-primary-500 p-2.5">
                            <option value="">Chọn sản phẩm</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="prompt" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Prompt cho AI</label>
                        <textarea name="prompt" id="prompt" rows="4"
                            class="mt-1 block w-full rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-primary-500 focus:border-primary-500 p-2.5"
                            placeholder="Nhập prompt để tạo nội dung quảng cáo...">{{ old('prompt') }}</textarea>
                        @error('prompt')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Nút hành động -->
                <div class="flex space-x-4">
                    <button type="submit" name="action" value="draft"
                        class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200">
                        Lưu bản nháp
                    </button>
                    <button type="submit" name="action" value="publish"
                        class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition duration-200">
                        Tạo nội dung
                    </button>
                </div>
            </form>

            <!-- Modal AI Settings -->
            <div id="ai-settings-modal" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow">
                        <div class="flex justify-between items-center p-5 border-b dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cài đặt AI</h3>
                            <button type="button" data-modal-toggle="ai-settings-modal"
                                class="text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('dashboard.aicreator.update-setting') }}" method="POST" class="p-6 space-y-4">
                            @csrf
                            @method('PATCH')
                            <div>
                                <label for="tone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Giọng điệu</label>
                                <select name="tone" id="tone" class="mt-1 block w-full rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-primary-500 focus:border-primary-500 p-2.5">
                                    <option value="friendly" {{ old('tone', $setting->tone ?? 'friendly') == 'friendly' ? 'selected' : '' }}>Thân thiện</option>
                                    <option value="professional" {{ old('tone', $setting->tone ?? 'friendly') == 'professional' ? 'selected' : '' }}>Chuyên nghiệp</option>
                                    <option value="funny" {{ old('tone', $setting->tone ?? 'friendly') == 'funny' ? 'selected' : '' }}>Hài hước</option>
                                    <option value="emotional" {{ old('tone', $setting->tone ?? 'friendly') == 'emotional' ? 'selected' : '' }}>Cảm xúc</option>
                                </select>
                                @error('tone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="length" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Độ dài nội dung</label>
                                <select name="length" id="length" class="mt-1 block w-full rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-primary-500 focus:border-primary-500 p-2.5">
                                    <option value="short" {{ old('length', $setting->length ?? 'medium') == 'short' ? 'selected' : '' }}>Ngắn</option>
                                    <option value="medium" {{ old('length', $setting->length ?? 'medium') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                    <option value="long" {{ old('length', $setting->length ?? 'medium') == 'long' ? 'selected' : '' }}>Dài</option>
                                </select>
                                @error('length')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nền tảng</label>
                                <select name="platform" id="platform" class="mt-1 block w-full rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-primary-500 focus:border-primary-500 p-2.5">
                                    <option value="Facebook" {{ old('platform', $setting->platform ?? 'Facebook') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                    <option value="Zalo" {{ old('platform', $setting->platform ?? 'Facebook') == 'Zalo' ? 'selected' : '' }}>Zalo</option>
                                    <option value="TikTok" {{ old('platform', $setting->platform ?? 'Facebook') == 'TikTok' ? 'selected' : '' }}>TikTok</option>
                                    <option value="Shopee" {{ old('platform', $setting->platform ?? 'Facebook') == 'Shopee' ? 'selected' : '' }}>Shopee</option>
                                </select>
                                @error('platform')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ngôn ngữ</label>
                                <select name="language" id="language" class="mt-1 block w-full rounded-md bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-primary-500 focus:border-primary-500 p-2.5">
                                    <option value="Vietnamese" {{ old('language', $setting->language ?? 'Vietnamese') == 'Vietnamese' ? 'selected' : '' }}>Tiếng Việt</option>
                                    <option value="English" {{ old('language', $setting->language ?? 'Vietnamese') == 'English' ? 'selected' : '' }}>Tiếng Anh</option>
                                </select>
                                @error('language')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end space-x-2">
                                <button type="button" data-modal-toggle="ai-settings-modal"
                                    class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-400 transition duration-200">
                                    Hủy
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition duration-200">
                                    Lưu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách nội dung -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">Danh sách nội dung</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tiêu đề</th>
                            <th scope="col" class="px-6 py-3">Sản phẩm</th>
                            <th scope="col" class="px-6 py-3">Trạng thái</th>
                            <th scope="col" class="px-6 py-3">Ngày tạo</th>
                            <th scope="col" class="px-6 py-3">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $ad)
                            <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $ad->ad_title }}</td>
                                <td class="px-6 py-4">{{ $ad->product ? $ad->product->name : 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="{{ $ad->status == 'draft' ? 'text-yellow-600' : 'text-green-600' }}">
                                        {{ $ad->status == 'draft' ? 'Bản nháp' : 'Đã xuất bản' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $ad->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('dashboard.aicreator.show', $ad->id) }}"
                                        class="text-primary-600 dark:text-primary-400 hover:underline">Xem</a>
                                    <a href="{{ route('dashboard.aicreator.edit', $ad->id) }}"
                                        class="text-blue-600 dark:text-blue-400 hover:underline">Sửa</a>
                                    <button type="button" data-modal-target="delete-modal-{{ $ad->id }}"
                                        data-modal-toggle="delete-modal-{{ $ad->id }}"
                                        class="text-red-600 dark:text-red-400 hover:underline">Xóa</button>
                                </td>
                            </tr>
                            <!-- Modal xác nhận xóa -->
                            <div id="delete-modal-{{ $ad->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow">
                                        <div class="p-6 text-center">
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Bạn có chắc muốn xóa nội dung "{{ $ad->ad_title }}"?</h3>
                                            <form action="{{ route('dashboard.aicreator.destroy', $ad->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2">
                                                    Xác nhận
                                                </button>
                                            </form>
                                            <button data-modal-toggle="delete-modal-{{ $ad->id }}"
                                                class="text-gray-500 bg-white dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">
                                                Hủy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-dashboard>