<x-app-dashboard>
    <div class="p-6 sm:p-8 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-5 rounded-xl shadow-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Chỉnh sửa Content AI</h1>
                        <p class="text-blue-100">Cập nhật và tối ưu nội dung quảng cáo của bạn</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard.aicreator.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium rounded-lg transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 mb-8">
            <div class="flex items-center mb-6">
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Chỉnh sửa nội dung</h2>
                    <p class="text-gray-600 dark:text-gray-400">ID: #{{ $item->id }} • Tạo lúc: {{ $item->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <form action="{{ route('dashboard.aicreator.update', $item->id) }}" method="POST" class="space-y-6" id="edit-content-form">
                @csrf
                @method('PUT')
                
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-3">Trạng thái hiện tại:</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $item->status == 'draft' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                {{ $item->status == 'draft' ? '📝 Bản nháp' : '✅ Đã xuất bản' }}
                            </span>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Cập nhật: {{ $item->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Thông tin cơ bản
                    </h3>
                    <div class="grid grid-cols-1">
                        <div>
                            <label for="ad_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                📝 Tiêu đề quảng cáo
                            </label>
                            <input type="text" name="ad_title" id="ad_title" value="{{ old('ad_title', $item->ad_title) }}"
                                class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3 transition-all duration-200"
                                placeholder="Nhập tiêu đề quảng cáo..." required>
                            @error('ad_title')
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

                <div class="bg-blue-50 dark:bg-gray-700 p-6 rounded-lg border border-blue-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Nội dung quảng cáo
                    </h3>
                    <div>
                        <label for="ad_content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            ✍️ Nội dung
                        </label>
                        <textarea name="ad_content" id="ad_content" rows="10"
                            class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 p-3 transition-all duration-200"
                            placeholder="Nhập nội dung quảng cáo...">{{ old('ad_content', $item->ad_content) }}</textarea>
                        @error('ad_content')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                        @enderror
                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            💡 Mẹo: Sử dụng emoji và hashtag để tăng tương tác
                        </div>
                    </div>
                </div>

                <div class="bg-purple-50 dark:bg-gray-700 p-6 rounded-lg border border-purple-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                        </svg>
                        Hashtags
                    </h3>
                    <div>
                        <label for="hashtags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            #️⃣ Hashtags (mỗi hashtag một dòng)
                        </label>
                        <textarea name="hashtags" id="hashtags" rows="4"
                            class="block w-full rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 p-3 transition-all duration-200"
                            placeholder="#hastag1&#10;#hastag2&#10;#hastag3">{{ old('hashtags', $item->hashtags) }}</textarea>
                        @error('hashtags')
                            <p class="text-red-500 text-sm mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            💡 Ví dụ: #sale #giảmgiá #muasắm #hotdeal
                        </div>
                    </div>
                </div>

                <div class="bg-green-50 dark:bg-gray-700 p-6 rounded-lg border border-green-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Trạng thái xuất bản
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="flex items-center p-4 border-2 border-yellow-200 dark:border-yellow-700 rounded-lg cursor-pointer hover:bg-yellow-50 dark:hover:bg-yellow-900 transition-all duration-200 {{ old('status', $item->status) == 'draft' ? 'bg-yellow-100 dark:bg-yellow-900 border-yellow-400' : '' }}">
                            <input type="radio" name="status" value="draft" {{ old('status', $item->status) == 'draft' ? 'checked' : '' }}
                                class="w-4 h-4 text-yellow-600 bg-gray-100 border-gray-300 focus:ring-yellow-500 focus:ring-2">
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">📝 Bản nháp</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Lưu để chỉnh sửa sau</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border-2 border-green-200 dark:border-green-700 rounded-lg cursor-pointer hover:bg-green-50 dark:hover:bg-green-900 transition-all duration-200 {{ old('status', $item->status) == 'approved' ? 'bg-green-100 dark:bg-green-900 border-green-400' : '' }}">
                            <input type="radio" name="status" value="approved" {{ old('status', $item->status) == 'approved' ? 'checked' : '' }}
                                class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 focus:ring-green-500 focus:ring-2">
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">✅ Xuất bản</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Sẵn sàng sử dụng</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200 dark:border-gray-600">
                    <button type="button" id="live-preview-btn" data-modal-target="preview-modal" data-modal-toggle="preview-modal"
                        class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Live Preview
                    </button>
                    <button type="submit"
                        class="flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Cập nhật nội dung
                    </button>
                    <a href="{{ route('dashboard.aicreator.index') }}"
                        class="flex items-center justify-center px-6 py-3 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-4 focus:ring-gray-300 transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Hủy thay đổi
                    </a>
                </div>
            </form>
        </div>

        <div id="preview-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full">
                <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-600">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Xem trước nội dung
                        </h2>
                        <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="preview-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="max-w-4xl mx-auto bg-white border border-gray-300 rounded-lg shadow-lg">
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">AI</span>
                                    </div>
                                    <div>
                                        <h3 id="preview-title" class="font-semibold text-gray-900">{{ $item->ad_title ?: 'Tiêu đề quảng cáo' }}</h3>
                                        <p class="text-xs text-gray-500 flex items-center">
                                            <span id="preview-date">{{ $item->updated_at->format('d/m/Y H:i') }}</span> • 
                                            <svg class="w-3 h-3 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 0111.336 0C16.153 8.9 16.153 9.433 15.67 9.93c-.482.497-1.264.497-1.747 0L10 6.006 6.077 9.93c-.483.497-1.265.497-1.747 0-.483-.497-.483-1.03 0-1.527L8.253 4.48c.483-.497 1.265-.497 1.747 0l3.923 3.923z" clip-rule="evenodd"></path>
                                            </svg>
                                        </p>
                                    </div>
                                    <div class="ml-auto">
                                        <span id="preview-status" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $item->status == 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $item->status == 'draft' ? '📝 Bản nháp' : '✅ Đã xuất bản' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                @if($item->product)
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                            <span class="text-white text-xs font-bold">🛍️</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-blue-900">Sản phẩm:</p>
                                            <p class="text-blue-700 font-semibold">{{ $item->product->name }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                
                                <div id="preview-content" class="prose prose-sm max-w-none mb-4">
                                    <div class="text-gray-800 whitespace-pre-line leading-relaxed">{{ $item->ad_content ?: 'Nội dung quảng cáo sẽ hiển thị ở đây...' }}</div>
                                </div>
                                
                                <div id="preview-hashtags" class="mb-4">
                                    <div class="text-blue-600 font-medium text-sm">
                                        {!! str_replace('#', '<span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-1 mb-1">#</span>', nl2br(e($item->hashtags))) !!}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 px-4 py-3">
                                <div class="flex items-center justify-between text-gray-500 text-sm mb-3">
                                    <div class="flex items-center space-x-4">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 text-blue-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                            </svg>
                                            Preview
                                        </span>
                                        <span>Mode</span>
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
                            
                            <div class="absolute bottom-2 right-2 opacity-50">
                                <div class="bg-black bg-opacity-20 text-white text-xs px-2 py-1 rounded">
                                    📝 Preview Mode
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adTitle = document.getElementById('ad_title');
            const adContent = document.getElementById('ad_content');
            const hashtags = document.getElementById('hashtags');
            const statusRadios = document.querySelectorAll('input[name="status"]');
            const previewBtn = document.getElementById('live-preview-btn');
            
            const previewTitle = document.getElementById('preview-title');
            const previewContent = document.getElementById('preview-content');
            const previewHashtags = document.getElementById('preview-hashtags');
            const previewStatus = document.getElementById('preview-status');
            const previewDate = document.getElementById('preview-date');

            function updatePreview() {
                previewTitle.textContent = adTitle.value || 'Tiêu đề quảng cáo';

                previewContent.innerHTML = `<div class="text-gray-800 whitespace-pre-line leading-relaxed">${adContent.value || 'Nội dung quảng cáo sẽ hiển thị ở đây...'}</div>`;

                const hashtagsArray = hashtags.value.split('\n').filter(tag => tag.trim() !== '');
                if (hashtagsArray.length > 0) {
                    const formattedHashtags = hashtagsArray.map(tag => 
                        `<span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-1 mb-1">${tag}</span>`
                    ).join('');
                    previewHashtags.innerHTML = `<div class="text-blue-600 font-medium text-sm">${formattedHashtags}</div>`;
                } else {
                    previewHashtags.innerHTML = '';
                }

                const selectedStatus = document.querySelector('input[name="status"]:checked').value;
                previewStatus.className = `inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${
                    selectedStatus === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'
                }`;
                previewStatus.textContent = selectedStatus === 'draft' ? '📝 Bản nháp' : '✅ Đã xuất bản';
            }

            previewBtn.addEventListener('click', updatePreview);
        });
    </script>
</x-app-dashboard>