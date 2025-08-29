<x-app-dashboard>
    <div class="p-6 sm:p-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <!-- Header với gradient -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white p-6 rounded-xl shadow-lg">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-1">Tạo nội dung thủ công</h1>
                        <p class="text-green-100">Viết tay nội dung marketing chuyên nghiệp theo ý tưởng của bạn</p>
                    </div>
                </div>
                
                <!-- Breadcrumb -->
                <nav class="flex items-center space-x-2 text-sm text-green-200">
                    <a href="{{ route('dashboard.content_creator.index') }}" class="hover:text-white transition-colors duration-200">Khởi tạo Content</a>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-white font-medium">Tạo nội dung thủ công</span>
                </nav>
            </div>
        </div>

        <!-- Form tạo content thủ công với card design -->
        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Viết tay nội dung</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Tạo nội dung marketing thủ công với đầy đủ các yếu tố cần thiết</p>
                </div>
            </div>

            <form action="{{ route('dashboard.content_creator.store') }}" method="POST" class="space-y-6" id="create-content-form">
                @csrf
                <input type="hidden" name="type" value="manual">
                <!-- Phần nhập nội dung thủ công - Main Section -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-gray-700 dark:to-gray-600 p-6 rounded-lg border border-green-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Viết tay nội dung marketing
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Nhập tiêu đề, nội dung chính, hashtags và emojis để tạo bài viết hoàn chỉnh.</p>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="ad_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                📝 Tiêu đề nội dung *
                            </label>
                            <input type="text" name="ad_title" id="ad_title" value="{{ old('ad_title') }}" required
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-green-500 p-4 transition-all duration-200 text-base"
                                placeholder="Nhập tiêu đề nội dung...">
                            @error('ad_title')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @endif
                        </div>

                        <div>
                            <label for="ad_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                📄 Nội dung chính *
                            </label>
                            <textarea name="ad_content" id="ad_content" rows="8" required
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-green-500 p-4 transition-all duration-200 text-base"
                                placeholder="Viết nội dung chi tiết tại đây...">{{ old('ad_content') }}</textarea>
                            @error('ad_content')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @endif
                        </div>

                        <div>
                            <label for="hashtags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                # Hashtags (tùy chọn)
                            </label>
                            <input type="text" name="hashtags" id="hashtags" value="{{ old('hashtags') }}"
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-green-500 p-4 transition-all duration-200 text-base"
                                placeholder="#hashtag1, #hashtag2, #hashtag3...">
                            @error('hashtags')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">💡 Phân cách bằng dấu phẩy</p>
                        </div>

                        <div>
                            <label for="emojis" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                😊 Emojis (tùy chọn)
                            </label>
                            <input type="text" name="emojis" id="emojis" value="{{ old('emojis') }}"
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-green-500 focus:border-green-500 p-4 transition-all duration-200 text-base"
                                placeholder="😊, 🔥, ⭐...">
                            @error('emojis')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">💡 Phân cách bằng dấu phẩy</p>
                        </div>
                    </div>
                </div>

                <!-- AI Features Display (Điều chỉnh cho thủ công) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                        <div class="flex items-center mb-2">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h4 class="font-semibold text-green-800 dark:text-green-400">Tùy chỉnh hoàn toàn</h4>
                        </div>
                        <p class="text-sm text-green-700 dark:text-green-300">Viết nội dung theo ý tưởng riêng của bạn</p>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                            </svg>
                            <h4 class="font-semibold text-purple-800 dark:text-purple-400">Thêm yếu tố hấp dẫn</h4>
                        </div>
                        <p class="text-sm text-purple-700 dark:text-purple-300">Sử dụng hashtags và emojis để tăng tương tác</p>
                    </div>
                </div>

                <!-- Nút hành động với gradient -->
                <div class="flex justify-end space-x-4">
                    <button type="submit" formaction="#" formmethod="POST"
                        class="flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-600 to-gray-700 text-white font-medium rounded-lg hover:from-gray-700 hover:to-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Lưu bản nháp
                    </button>
                    <button type="submit" formaction="{{ route('dashboard.content_creator.store') }}" formmethod="POST"
                        class="flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-medium rounded-lg hover:from-green-700 hover:to-emerald-700 focus:outline-none focus:ring-4 focus:ring-green-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Tạo nội dung
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips Section -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                💡 Mẹo để có nội dung thủ công tốt nhất
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                    <h4 class="font-medium text-green-800 dark:text-green-400 mb-2">📝 Viết rõ ràng, hấp dẫn</h4>
                    <p class="text-sm text-green-700 dark:text-green-300">Sử dụng ngôn ngữ đơn giản, tập trung vào lợi ích và lời kêu gọi hành động</p>
                </div>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                    <h4 class="font-medium text-blue-800 dark:text-blue-400 mb-2">🎯 Tùy chỉnh theo nền tảng</h4>
                    <p class="text-sm text-blue-700 dark:text-blue-300">Nội dung ngắn gọn cho TikTok, chi tiết hơn cho Facebook</p>
                </div>
                
                <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg">
                    <h4 class="font-medium text-purple-800 dark:text-purple-400 mb-2">✨ Thêm hashtags & emojis</h4>
                    <p class="text-sm text-purple-700 dark:text-purple-300">Tăng khả năng lan tỏa và tính hấp dẫn thị giác cho bài viết</p>
                </div>
            </div>
        </div>
    </div>
</x-app-dashboard>