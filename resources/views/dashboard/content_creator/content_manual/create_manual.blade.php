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

            <form action="{{ route('dashboard.content_creator.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="create-content-form">
                @csrf
                <input type="hidden" name="type" value="manual">
                
                <!-- Chọn loại nội dung -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg border-2 border-green-100 dark:border-gray-700 shadow-sm">
                    <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">
                        🎯 Chọn loại bài đăng:
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:bg-green-50 dark:hover:bg-gray-700 media-type-label border-green-500 bg-green-50" id="label-text">
                            <input type="radio" name="media_type" value="text" checked class="w-5 h-5 text-green-600 focus:ring-green-500" onchange="toggleMediaType('text')">
                            <div class="ml-4">
                                <span class="block text-base font-bold text-gray-900 dark:text-white">📝 Chỉ văn bản</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">Đăng status thuần túy</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:bg-green-50 dark:hover:bg-gray-700 media-type-label border-gray-200" id="label-image">
                            <input type="radio" name="media_type" value="image" class="w-5 h-5 text-green-600 focus:ring-green-500" onchange="toggleMediaType('image')">
                            <div class="ml-4">
                                <span class="block text-base font-bold text-gray-900 dark:text-white">🖼️ Văn bản + Ảnh</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">Đăng kèm album hình ảnh</span>
                            </div>
                        </label>

                        <label class="flex items-center p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:bg-green-50 dark:hover:bg-gray-700 media-type-label border-gray-200" id="label-video">
                            <input type="radio" name="media_type" value="video" class="w-5 h-5 text-green-600 focus:ring-green-500" onchange="toggleMediaType('video')">
                            <div class="ml-4">
                                <span class="block text-base font-bold text-gray-900 dark:text-white">🎬 Văn bản + Video</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400">Đăng kèm 1 video clip</span>
                            </div>
                        </label>
                    </div>
                </div>
                
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

                        <!-- Upload Ảnh Section -->
                        <div id="section-image" class="hidden animate-fade-in">
                            <label for="ad_images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                🖼️ Hình ảnh nội dung
                            </label>
                            <div class="w-full">
                                <!-- Upload zone (hiển thị khi chưa có ảnh) -->
                                <label for="ad_images" id="upload-zone" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 transition-all duration-200">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Nhấn để upload</span> hoặc kéo thả</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Chọn nhiều ảnh: SVG, PNG, JPG hoặc GIF (Mỗi file MAX. 2MB)</p>
                                    </div>
                                    <input id="ad_images" type="file" name="ad_images[]" class="hidden" accept="image/*" multiple onchange="previewImages(event)"/>
                                </label>
                                
                                <!-- Preview images grid (hiển thị khi đã có ảnh) -->
                                <div class="hidden" id="images-preview">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Đã chọn <span id="images-count">0</span> ảnh</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button" onclick="addMoreImages()" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm transition-colors duration-200">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Thêm ảnh
                                            </button>
                                            <button type="button" onclick="removeAllImages()" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md text-sm transition-colors duration-200">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Xóa tất cả
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="preview-grid">
                                    </div>
                                </div>
                            </div>
                            @error('ad_images')
                                <p class="text-red-500 text-sm mt-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @endif
                            <p class="text-xs text-gray-500 mt-1">💡 Bạn có thể chọn nhiều ảnh cùng lúc.</p>
                        </div>

                        <!-- Upload/Chọn Video Section -->
                        <div id="section-video" class="hidden animate-fade-in border-t border-gray-200 dark:border-gray-700 pt-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                🎬 Video nội dung
                            </label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <!-- Option 1: Upload Video -->
                                <div class="relative">
                                    <label for="ad_video" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 transition-all duration-200">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-2 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold">Tải video mới</p>
                                        </div>
                                        <input id="ad_video" type="file" name="ad_video" class="hidden" accept="video/*" onchange="previewVideo(this)"/>
                                    </label>
                                </div>

                                <!-- Option 2: Select from Library -->
                                <div class="relative">
                                    <div class="w-full h-32 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 dark:bg-gray-700 p-2 overflow-y-auto">
                                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2 text-center">Chọn từ thư viện</p>
                                        <div class="grid grid-cols-3 gap-2">
                                            @foreach($videos as $video)
                                                <div class="relative cursor-pointer group video-option" onclick="selectVideo('{{ $video->id }}', '{{ $video->original_filename }}', '{{ $video->thumbnail_url ?: $video->original_url }}')">
                                                    <img src="{{ $video->thumbnail_url ?: 'https://via.placeholder.com/320x180.png?text=Video' }}" 
                                                         alt="{{ $video->original_filename }}" 
                                                         class="w-full h-16 object-cover rounded border border-gray-200 group-hover:border-green-500">
                                                    <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 rounded transition-opacity">
                                                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="hidden" name="video_id" id="selected_video_id">
                                </div>
                            </div>

                            <!-- Video Preview Container -->
                            <div id="video-preview-container" class="hidden relative mt-4 p-4 bg-gray-100 dark:bg-gray-900 rounded-lg border border-gray-300">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Video đã chọn: <span id="video-name" class="font-bold"></span></span>
                                    <button type="button" onclick="clearVideoSelection()" class="text-red-500 hover:text-red-700">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="aspect-video w-full max-w-md mx-auto overflow-hidden rounded-lg bg-black">
                                    <video id="video-preview-player" class="w-full h-full" controls></video>
                                    <img id="video-preview-thumb" class="w-full h-full object-contain hidden" src="" alt="Thumbnail">
                                </div>
                            </div>
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
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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
                
                <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                    <h4 class="font-medium text-orange-800 dark:text-orange-400 mb-2">🖼️ Sử dụng hình ảnh</h4>
                    <p class="text-sm text-orange-700 dark:text-orange-300">Hình ảnh chất lượng cao sẽ làm nội dung nổi bật và thu hút hơn</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedFiles = [];

        function previewImages(event) {
            const files = Array.from(event.target.files);
            const uploadZone = document.getElementById('upload-zone');
            const imagesPreview = document.getElementById('images-preview');
            
            // Validate files
            const validFiles = [];
            for (let file of files) {
                // Validate file size (2MB = 2 * 1024 * 1024 bytes)
                if (file.size > 2 * 1024 * 1024) {
                    alert(`File "${file.name}" quá lớn! Vui lòng chọn file dưới 2MB.`);
                    continue;
                }
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
                if (!validTypes.includes(file.type)) {
                    alert(`File "${file.name}" không được hỗ trợ! Vui lòng chọn file JPG, PNG, GIF hoặc SVG.`);
                    continue;
                }
                
                validFiles.push(file);
            }
            
            if (validFiles.length > 0) {
                selectedFiles = [...selectedFiles, ...validFiles];
                updatePreviewGrid();
                uploadZone.classList.add('hidden');
                imagesPreview.classList.remove('hidden');
            }
            
            // Clear input
            event.target.value = '';
        }

        function updatePreviewGrid() {
            const previewGrid = document.getElementById('preview-grid');
            const imagesCount = document.getElementById('images-count');
            
            previewGrid.innerHTML = '';
            imagesCount.textContent = selectedFiles.length;
            
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageContainer = document.createElement('div');
                    imageContainer.className = 'relative group border-2 border-gray-200 dark:border-gray-600 rounded-lg overflow-hidden';
                    
                    const fileSizeKB = Math.round(file.size / 1024);
                    imageContainer.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-80 object-cover">
                        <button type="button" onclick="removeImage(${index})" 
                            class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 opacity-75 hover:opacity-100 transition-all duration-200 shadow-lg z-10" 
                            title="Xóa ảnh này">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black via-black/70 to-transparent text-white text-xs p-2">
                            <div class="truncate">${file.name}</div>
                            <div class="text-gray-300">${fileSizeKB} KB</div>
                        </div>
                    `;
                    previewGrid.appendChild(imageContainer);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeImage(index) {
            selectedFiles.splice(index, 1);
            
            if (selectedFiles.length === 0) {
                const uploadZone = document.getElementById('upload-zone');
                const imagesPreview = document.getElementById('images-preview');
                uploadZone.classList.remove('hidden');
                imagesPreview.classList.add('hidden');
            } else {
                updatePreviewGrid();
            }
            
            updateFileInput();
        }

        function removeAllImages() {
            selectedFiles = [];
            const uploadZone = document.getElementById('upload-zone');
            const imagesPreview = document.getElementById('images-preview');
            
            uploadZone.classList.remove('hidden');
            imagesPreview.classList.add('hidden');
            
            updateFileInput();
        }

        function addMoreImages() {
            document.getElementById('ad_images').click();
        }

        function updateFileInput() {
            const fileInput = document.getElementById('ad_images');
            const dt = new DataTransfer();
            
            selectedFiles.forEach(file => {
                dt.items.add(file);
            });
            
            fileInput.files = dt.files;
        }

        // Form submit handler để đảm bảo files được gửi
        document.getElementById('create-content-form').addEventListener('submit', function(e) {
            updateFileInput();
        });

        function previewVideo(input) {
            const file = input.files[0];
            if (file) {
                // Clear selection from library
                document.getElementById('selected_video_id').value = '';
                
                const container = document.getElementById('video-preview-container');
                const nameDisplay = document.getElementById('video-name');
                const player = document.getElementById('video-preview-player');
                const thumb = document.getElementById('video-preview-thumb');
                
                container.classList.remove('hidden');
                nameDisplay.textContent = file.name;
                player.classList.remove('hidden');
                thumb.classList.add('hidden');
                
                const url = URL.createObjectURL(file);
                player.src = url;
            }
        }

        function selectVideo(id, title, url) {
            // Clear file input
            document.getElementById('ad_video').value = '';
            
            document.getElementById('selected_video_id').value = id;
            
            const container = document.getElementById('video-preview-container');
            const nameDisplay = document.getElementById('video-name');
            const player = document.getElementById('video-preview-player');
            const thumb = document.getElementById('video-preview-thumb');
            
            container.classList.remove('hidden');
            nameDisplay.textContent = title;
            
            if (url.toLowerCase().endsWith('.mp4') || url.includes('video/upload')) {
                player.classList.remove('hidden');
                thumb.classList.add('hidden');
                player.src = url;
            } else {
                player.classList.add('hidden');
                thumb.classList.remove('hidden');
                thumb.src = url;
            }
        }

        function clearVideoSelection() {
            document.getElementById('ad_video').value = '';
            document.getElementById('selected_video_id').value = '';
            document.getElementById('video-preview-container').classList.add('hidden');
            document.getElementById('video-preview-player').src = '';
        }

        function toggleMediaType(type) {
            // Hide all sections
            document.getElementById('section-image').classList.add('hidden');
            document.getElementById('section-video').classList.add('hidden');
            
            // Remove active classes from labels
            document.querySelectorAll('.media-type-label').forEach(el => {
                el.classList.remove('border-green-500', 'bg-green-50');
                el.classList.add('border-gray-200');
            });
            
            // Show selected section and activate label
            const activeLabel = document.getElementById(`label-${type}`);
            activeLabel.classList.remove('border-gray-200');
            activeLabel.classList.add('border-green-500', 'bg-green-50');
            
            if (type === 'image') {
                document.getElementById('section-image').classList.remove('hidden');
            } else if (type === 'video') {
                document.getElementById('section-video').classList.remove('hidden');
            }
        }
    </script>
</x-app-dashboard>