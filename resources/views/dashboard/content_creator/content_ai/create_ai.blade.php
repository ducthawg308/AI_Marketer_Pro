<x-app-dashboard>
    <div class="p-6 sm:p-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <!-- Header với gradient -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-1">AI Content theo thông tin sản phẩm</h1>
                        <p class="text-blue-100">Tạo nội dung marketing chuyên nghiệp từ thông tin sản phẩm của bạn</p>
                    </div>
                </div>
                
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-blue-200">
                    <a href="{{ route('dashboard.content_creator.index') }}" class="hover:text-white transition-colors duration-200">Khởi tạo Content</a>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-white font-medium">AI Content theo sản phẩm</span>
                </nav>
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
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Tạo nội dung từ sản phẩm</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">AI sẽ phân tích thông tin sản phẩm và tạo nội dung marketing phù hợp</p>
                </div>
            </div>

            <form action="{{ route('dashboard.content_creator.store') }}" method="POST" class="space-y-6" id="create-content-form">
                @csrf
                <input type="hidden" name="type" value="product">
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

                <!-- Chọn sản phẩm - Main Section -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 p-6 rounded-lg border border-blue-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Chọn sản phẩm để tạo nội dung
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Chọn sản phẩm từ danh sách. AI sẽ sử dụng thông tin sản phẩm để tạo nội dung marketing hiệu quả.</p>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                🛍️ Sản phẩm *
                            </label>
                            <select name="product_id" id="product_id" required
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-4 transition-all duration-200 text-base">
                                <option value="">-- Chọn sản phẩm --</option>
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

                        <div>
                            <label for="ad_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                📝 Tiêu đề nội dung (tùy chọn)
                            </label>
                            <input type="text" name="ad_title" id="ad_title" value="{{ old('ad_title') }}"
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-4 transition-all duration-200 text-base"
                                placeholder="AI sẽ tự tạo tiêu đề nếu để trống...">
                            @error('ad_title')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">💡 Để trống để AI tự động tạo tiêu đề phù hợp</p>
                        </div>
                    </div>
                </div>

                <!-- AI Features Display -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="font-semibold text-green-800 dark:text-green-400">Tự động phân tích</h4>
                        </div>
                        <p class="text-sm text-green-700 dark:text-green-300">AI phân tích đặc điểm, lợi ích sản phẩm</p>
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-400">Tối ưu nền tảng</h4>
                        </div>
                        <p class="text-sm text-blue-700 dark:text-blue-300">Nội dung phù hợp từng nền tảng social</p>
                    </div>
                    
                    <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-200 dark:border-purple-800">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <h4 class="font-semibold text-purple-800 dark:text-purple-400">Hashtags thông minh</h4>
                        </div>
                        <p class="text-sm text-purple-700 dark:text-purple-300">Tự động tạo hashtags trending phù hợp</p>
                    </div>
                </div>

                <input type="hidden" name="ai_setting_id" id="ai_setting_id" value="{{$setting->id}}">

                <!-- Phần tạo nội dung AI -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 p-6 rounded-lg border border-green-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                        Quy trình AI sẽ thực hiện
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center mx-auto mb-2 text-sm font-bold">1</div>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Đọc thông tin sản phẩm</p>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-2 text-sm font-bold">2</div>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Phân tích đối tượng mục tiêu</p>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-purple-600 text-white rounded-full flex items-center justify-center mx-auto mb-2 text-sm font-bold">3</div>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Tạo nội dung theo cài đặt</p>
                        </div>
                        <div class="text-center">
                            <div class="w-10 h-10 bg-orange-600 text-white rounded-full flex items-center justify-center mx-auto mb-2 text-sm font-bold">4</div>
                            <p class="text-sm font-medium text-gray-800 dark:text-gray-200">Tối ưu và hoàn thiện</p>
                        </div>
                    </div>
                </div>

                <!-- Nút hành động với design mới -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" formaction="{{ route('dashboard.content_creator.store') }}" formmethod="POST"
                        class="flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-lg hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Tạo nội dung bằng AI
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
                        <form action="{{ route('dashboard.content_creator.update-setting') }}" method="POST" class="p-6 space-y-6">
                            @csrf
                            @method('PATCH')
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

        <!-- Tips Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                Mẹo để có nội dung AI tốt nhất
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <h4 class="font-medium text-blue-800 dark:text-blue-400 mb-2">📊 Thông tin sản phẩm đầy đủ</h4>
                    <p class="text-sm text-blue-700 dark:text-blue-300">Đảm bảo sản phẩm có đầy đủ thông tin: tên, mô tả, giá, lợi ích để AI tạo nội dung chính xác nhất</p>
                </div>
                
                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                    <h4 class="font-medium text-green-800 dark:text-green-400 mb-2">🎯 Chọn nền tảng phù hợp</h4>
                    <p class="text-sm text-green-700 dark:text-green-300">Mỗi nền tảng có phong cách riêng. Facebook dài hơn, TikTok ngắn gọn, Shopee tập trung vào ưu đãi</p>
                </div>
                
                <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                    <h4 class="font-medium text-purple-800 dark:text-purple-400 mb-2">✨ Điều chỉnh giọng điệu</h4>
                    <p class="text-sm text-purple-700 dark:text-purple-300">Chọn giọng điệu phù hợp với thương hiệu và đối tượng khách hàng của bạn</p>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('create-content-form').addEventListener('submit', function() {
            const buttons = this.querySelectorAll('button[type="submit"]');
            buttons.forEach(button => {
                button.disabled = true;
                button.innerHTML = '<div class="animate-spin inline-block w-4 h-4 border-4 border-solid border-current border-r-transparent rounded-full mr-2" role="status"></div>Đang tạo nội dung...';
            });
        });
    </script>
</x-app-dashboard>
