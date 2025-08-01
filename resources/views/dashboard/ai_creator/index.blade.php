<x-app-dashboard>
    <div class="p-6 sm:p-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <!-- Header với gradient -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-5 rounded-xl shadow-lg">
                <h1 class="text-3xl font-bold mb-2">Khởi tạo Content AI</h1>
                <p class="text-blue-100">Tạo và quản lý nội dung quảng cáo tự động với AI</p>
            </div>
        </div>

        <!-- Form tạo content AI với card design -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Tạo nội dung mới</h2>
            </div>

            <form action="{{ route('dashboard.aicreator.store') }}" method="POST" class="space-y-6" id="create-content-form">
                @csrf
                <!-- Nút cài đặt AI với style mới -->
                <div class="flex justify-end">
                    <button type="button" data-modal-target="ai-settings-modal" data-modal-toggle="ai-settings-modal"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-purple-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Cài đặt AI
                    </button>
                </div>

                <!-- Thông tin cơ bản với card layout -->
                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Thông tin nội dung
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="ad_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📝 Tiêu đề quảng cáo
                            </label>
                            <input type="text" name="ad_title" id="ad_title" value="{{ old('ad_title') }}"
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3 transition-all duration-200"
                                placeholder="Nhập tiêu đề quảng cáo...">
                            @error('ad_title')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                🛍️ Chọn sản phẩm
                            </label>
                            <select name="product_id" id="product_id"
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3 transition-all duration-200">
                                <option value="">Chọn sản phẩm</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <input type="hidden" name="ai_setting_id" id="ai_setting_id" value="{{$setting->id}}">

                <!-- Phần tạo nội dung AI -->
                <div class="bg-gradient-to-r from-green-50 to-blue-50 dark:from-gray-700 dark:to-gray-600 p-6 rounded-lg border border-green-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Tạo nội dung AI
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Chọn sản phẩm và áp dụng cài đặt AI để tạo nội dung tự động.</p>
                </div>

                <!-- Nút hành động với design mới -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <button type="submit" name="action" value="draft"
                        class="flex items-center justify-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Lưu bản nháp
                    </button>
                    <button type="submit" formaction="{{ route('dashboard.aicreator.store') }}" formmethod="POST"
                        class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-lg hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Tạo bằng AI
                    </button>
                </div>
            </form>

            <!-- Modal AI Settings với design mới -->
            <div id="ai-settings-modal" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full bg-black bg-opacity-50">
                <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
                    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700">
                        <div class="flex justify-between items-center p-6 border-b border-gray-200 dark:border-gray-600 bg-gradient-to-r from-purple-600 to-blue-600 rounded-t-xl">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Cài đặt AI
                            </h3>
                            <button type="button" data-modal-toggle="ai-settings-modal"
                                class="text-white hover:text-gray-200 transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <form action="{{ route('dashboard.aicreator.update-setting') }}" method="POST" class="p-6 space-y-6">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="tone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🎭 Giọng điệu</label>
                                    <select name="tone" id="tone" class="block w-full rounded-lg bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 p-3">
                                        <option value="friendly" {{ old('tone', $setting->tone ?? 'friendly') == 'friendly' ? 'selected' : '' }}>Thân thiện</option>
                                        <option value="professional" {{ old('tone', $setting->tone ?? 'friendly') == 'professional' ? 'selected' : '' }}>Chuyên nghiệp</option>
                                        <option value="funny" {{ old('tone', $setting->tone ?? 'friendly') == 'funny' ? 'selected' : '' }}>Hài hước</option>
                                        <option value="emotional" {{ old('tone', $setting->tone ?? 'friendly') == 'emotional' ? 'selected' : '' }}>Cảm xúc</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="length" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📏 Độ dài nội dung</label>
                                    <select name="length" id="length" class="block w-full rounded-lg bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 p-3">
                                        <option value="short" {{ old('length', $setting->length ?? 'medium') == 'short' ? 'selected' : '' }}>Ngắn</option>
                                        <option value="medium" {{ old('length', $setting->length ?? 'medium') == 'medium' ? 'selected' : '' }}>Trung bình</option>
                                        <option value="long" {{ old('length', $setting->length ?? 'medium') == 'long' ? 'selected' : '' }}>Dài</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="platform" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">📱 Nền tảng</label>
                                    <select name="platform" id="platform" class="block w-full rounded-lg bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 p-3">
                                        <option value="Facebook" {{ old('platform', $setting->platform ?? 'Facebook') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                        <option value="Zalo" {{ old('platform', $setting->platform ?? 'Facebook') == 'Zalo' ? 'selected' : '' }}>Zalo</option>
                                        <option value="TikTok" {{ old('platform', $setting->platform ?? 'Facebook') == 'TikTok' ? 'selected' : '' }}>TikTok</option>
                                        <option value="Shopee" {{ old('platform', $setting->platform ?? 'Facebook') == 'Shopee' ? 'selected' : '' }}>Shopee</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">🌐 Ngôn ngữ</label>
                                    <select name="language" id="language" class="block w-full rounded-lg bg-gray-50 dark:bg-gray-700 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 p-3">
                                        <option value="Vietnamese" {{ old('language', $setting->language ?? 'Vietnamese') == 'Vietnamese' ? 'selected' : '' }}>Tiếng Việt</option>
                                        <option value="English" {{ old('language', $setting->language ?? 'Vietnamese') == 'English' ? 'selected' : '' }}>Tiếng Anh</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" data-modal-toggle="ai-settings-modal"
                                    class="px-6 py-3 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-200">
                                    Hủy
                                </button>
                                <button type="submit"
                                    class="px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-medium rounded-lg hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-purple-300 transition-all duration-200">
                                    Lưu cài đặt
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danh sách nội dung với card design -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-600">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Danh sách nội dung
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Tiêu đề</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Sản phẩm</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Trạng thái</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Ngày tạo</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $ad)
                            <tr class="cursor-pointer bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $ad->ad_title }}</td>
                                <td class="px-6 py-4">{{ $ad->product ? $ad->product->name : 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $ad->status == 'draft' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                        {{ $ad->status == 'draft' ? '📝 Bản nháp' : '✅ Đã xuất bản' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">{{ $ad->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <a href="#" data-modal-target="detail-modal-{{ $ad->id }}" data-modal-toggle="detail-modal-{{ $ad->id }}"
                                        class="inline-flex items-center px-3 py-1 text-xs font-medium text-white bg-primary-300 hover:bg-primary-500 dark:bg-primary-700 dark:hover:bg-primary-800 rounded-full transition-colors duration-200">
                                            Xem
                                        </a>
                                        <a href="{{ route('dashboard.aicreator.edit', $ad->id) }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-blue-600 dark:text-blue-400 bg-blue-100 dark:bg-blue-900 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200">
                                            Sửa
                                        </a>
                                        <button type="button" data-modal-target="delete-modal-{{ $ad->id }}"
                                            data-modal-toggle="delete-modal-{{ $ad->id }}"
                                            class="inline-flex items-center px-3 py-1 text-xs font-medium text-red-600 dark:text-red-400 bg-red-100 dark:bg-red-900 rounded-full hover:bg-red-200 dark:hover:bg-red-800 transition-colors duration-200">
                                            Xóa
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Chi tiết - Facebook Post Style -->
                            <div id="detail-modal-{{ $ad->id }}" tabindex="-1" aria-hidden="true"
                                class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto inset-0 h-full justify-center items-center bg-black bg-opacity-75">
                                <div class="relative w-full max-w-3xl max-h-[100vh] mx-auto">
                                    <!-- Facebook Post Container -->
                                    <div class="relative bg-white rounded-lg shadow-2xl border border-gray-300 overflow-hidden">
                                        <!-- Close Button -->
                                        <button type="button"
                                            class="absolute top-4 right-4 z-10 text-gray-400 bg-white hover:bg-gray-100 hover:text-gray-900 rounded-full text-sm w-8 h-8 inline-flex justify-center items-center shadow-lg"
                                            data-modal-hide="detail-modal-{{ $ad->id }}">
                                            ✕
                                        </button>
                                        
                                        <!-- Facebook Post Header -->
                                        <div class="p-4 border-b border-gray-200">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                                    <span class="text-white font-bold text-sm">AI</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900">Content AI Creator</h3>
                                                    <p class="text-xs text-gray-500 flex items-center">
                                                        {{ $ad->created_at->format('d/m/Y H:i') }} • 
                                                        <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 0111.336 0C16.153 8.9 16.153 9.433 15.67 9.93c-.482.497-1.264.497-1.747 0L10 6.006 6.077 9.93c-.483.497-1.265.497-1.747 0-.483-.497-.483-1.03 0-1.527L8.253 4.48c.483-.497 1.265-.497 1.747 0l3.923 3.923z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </p>
                                                </div>
                                                <div class="ml-auto">
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $ad->status == 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                        {{ $ad->status == 'draft' ? '📝 Bản nháp' : '✅ Đã xuất bản' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Facebook Post Content -->
                                        <div class="max-h-96 overflow-y-auto">
                                            <div class="p-4">
                                                <!-- Post Title -->
                                                <h2 class="text-lg font-bold text-gray-900 mb-3">{{ $ad->ad_title }}</h2>
                                                
                                                <!-- Product Info -->
                                                @if($ad->product)
                                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                                            <span class="text-white text-xs font-bold">🛍️</span>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-blue-900">Sản phẩm:</p>
                                                            <p class="text-blue-700 font-semibold">{{ $ad->product->name }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <!-- Post Content -->
                                                <div class="prose prose-sm max-w-none mb-4">
                                                    <div class="text-gray-800 whitespace-pre-line leading-relaxed">{{ $ad->ad_content }}</div>
                                                </div>
                                                
                                                <!-- Hashtags -->
                                                @if($ad->hashtags)
                                                <div class="mb-4">
                                                    <div class="text-blue-600 font-medium text-sm">
                                                        {!! str_replace('#', '<span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-1 mb-1">#</span>', nl2br(e($ad->hashtags))) !!}
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Facebook-like Action Bar -->
                                            <div class="border-t border-gray-200 px-4 py-3">
                                                <div class="flex items-center justify-between text-gray-500 text-sm mb-3">
                                                    <div class="flex items-center space-x-4">
                                                        <span class="flex items-center">
                                                            <svg class="w-4 h-4 text-blue-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                                            </svg>
                                                            42 lượt thích
                                                        </span>
                                                        <span>8 bình luận</span>
                                                        <span>3 chia sẻ</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="flex items-center justify-around border-t border-gray-200 pt-2">
                                                    <button class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                                        </svg>
                                                        <span class="text-gray-600 font-medium">Thích</span>
                                                    </button>
                                                    <button class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                        </svg>
                                                        <span class="text-gray-600 font-medium">Bình luận</span>
                                                    </button>
                                                    <button class="flex items-center space-x-2 px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                                        </svg>
                                                        <span class="text-gray-600 font-medium">Chia sẻ</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Screenshot watermark -->
                                        <div class="absolute bottom-2 right-2 opacity-50">
                                            <div class="bg-black bg-opacity-20 text-white text-xs px-2 py-1 rounded">
                                                📸 AI Content Preview
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal xác nhận xóa với design mới -->
                            <div id="delete-modal-{{ $ad->id }}" tabindex="-1"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full bg-black bg-opacity-50">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700">
                                        <div class="p-6 text-center">
                                            <div class="w-16 h-16 bg-red-100 dark:bg-red-900 rounded-full flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                Xác nhận xóa
                                            </h3>
                                            <p class="mb-6 text-gray-500 dark:text-gray-400">
                                                Bạn có chắc muốn xóa nội dung "<span class="font-medium text-gray-900 dark:text-gray-100">{{ $ad->ad_title }}</span>"? 
                                                <br><span class="text-sm">Hành động này không thể hoàn tác.</span>
                                            </p>
                                            <div class="flex justify-center space-x-3">
                                                <button data-modal-toggle="delete-modal-{{ $ad->id }}"
                                                    class="px-6 py-3 text-gray-500 bg-white dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 font-medium transition-all duration-200">
                                                    Hủy
                                                </button>
                                                <form action="{{ route('dashboard.aicreator.destroy', $ad->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-6 py-3 text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg transition-all duration-200">
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
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Chưa có nội dung nào</h3>
                                    <p class="text-gray-500 dark:text-gray-400">Hãy tạo nội dung AI đầu tiên của bạn!</p>
                                </div>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-dashboard>