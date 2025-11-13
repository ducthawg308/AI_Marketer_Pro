{{-- <x-app-dashboard>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Content Management Dashboard</h1>
            <p class="text-gray-600">Chọn phương thức tạo nội dung phù hợp với nhu cầu của bạn</p>
        </div>

        <!-- Content Creator Cards Section -->
        <div class="mb-12">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2 flex items-center">
                    <svg class="w-7 h-7 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Tạo Nội Dung
                </h2>
                <p class="text-gray-600">Các công cụ tạo và quản lý nội dung marketing</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1: Tạo content thủ công -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 bg-primary-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Viết tay</h3>
                        <p class="text-gray-600 mb-4">Tạo nội dung hoàn toàn thủ công với trình soạn thảo văn bản đầy đủ tính năng.</p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Kiểm soát hoàn toàn nội dung
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Trình soạn thảo WYSIWYG
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Không giới hạn độ dài
                            </div>
                        </div>
                        <a href="{{ route('dashboard.content_creator.manual') }}" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 text-center block">
                            Bắt đầu viết
                        </a>
                    </div>
                </div>

                <!-- Card 2: AI Content theo thông tin sản phẩm -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">AI Content theo thông tin sản phẩm</h3>
                        <p class="text-gray-600 mb-4">Tạo nội dung marketing chuyên nghiệp bằng AI từ thông tin sản phẩm của bạn.</p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Tạo nhanh và chính xác
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Tối ưu SEO tự động
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Đa dạng style viết
                            </div>
                        </div>
                        <a href="{{ route('dashboard.content_creator.product') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 text-center block">
                            Tạo từ sản phẩm
                        </a>
                    </div>
                </div>

                <!-- Card 3: AI Content theo link -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 bg-purple-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">AI Content theo link</h3>
                        <p class="text-gray-600 mb-4">Phân tích và tạo nội dung mới từ các bài viết, tin tức hoặc nguồn thông tin trực tuyến.</p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Phân tích nội dung web
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Viết lại độc đáo
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Tiết kiệm thời gian
                            </div>
                        </div>
                        <a href="{{ route('dashboard.content_creator.link') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 text-center block">
                            Tạo từ link
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Media Editor Section -->
        <div class="mb-12">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2 flex items-center">
                    <svg class="w-7 h-7 mr-3 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Công Cụ Chỉnh Sửa
                </h2>
                <p class="text-gray-600">Chỉnh sửa và tối ưu hóa media cho content marketing</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 4: AI Media Editor -->
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 border border-gray-200">
                    <div class="p-6">
                        <div class="flex items-center justify-center w-12 h-12 bg-gradient-to-r from-pink-100 to-orange-100 rounded-lg mb-4">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Chỉnh sửa Media</h3>
                        <p class="text-gray-600 mb-4">Chỉnh sửa ảnh và video chuyên nghiệp với công nghệ FFmpeg, tối ưu cho content marketing.</p>
                        <div class="space-y-2 mb-6">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Cắt, ghép, resize video
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Thêm watermark, text overlay
                            </div>
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Tối ưu cho social media
                            </div>
                        </div>
                        <a href="#" class="w-full bg-gradient-to-r from-pink-600 to-orange-600 hover:from-pink-700 hover:to-orange-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 text-center block">
                            Chỉnh sửa Media
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Section -->
        <div class="mt-12 bg-gray-50 rounded-xl p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Thống kê hoạt động</h2>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-primary-600">{{ $totalContent }}</div>
                    <div class="text-sm text-gray-600">Nội dung đã tạo</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $aiContent }}</div>
                    <div class="text-sm text-gray-600">AI Content</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $linkContent }}</div>
                    <div class="text-sm text-gray-600">Từ link</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $manualContent }}</div>
                    <div class="text-sm text-gray-600">Viết tay</div>
                </div>
                <div class="bg-white rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-pink-600">{{ $mediaEdited ?? 0 }}</div>
                    <div class="text-sm text-gray-600">Media đã chỉnh sửa</div>
                </div>
            </div>
        </div>

        <!-- Danh sách nội dung với card design -->
        <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 p-6">
            <div class="border-b border-gray-200 dark:border-gray-600">
                <h2 class="mb-4 text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center">
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
                            <th scope="col" class="px-6 py-4 font-semibold">Loại bài</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Trạng thái</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Ngày tạo</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $ad)
                            <tr class="cursor-pointer bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">{{ $ad->ad_title }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if($ad->type == 'manual') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($ad->type == 'product') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        @else bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200 @endif">
                                        {{ $ad->type == 'manual' ? 'Thủ công' : ($ad->type == 'product' ? 'Sản phẩm' : 'Liên kết') }}
                                    </span>
                                </td>
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
                                        <a href="{{ route('dashboard.content_creator.edit', $ad->id) }}"
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
                                    <div class="relative bg-white rounded-lg shadow-2xl border border-gray-300 overflow-hidden">
                                        <button type="button"
                                            class="absolute top-4 right-4 z-10 text-gray-400 bg-white hover:bg-gray-100 hover:text-gray-900 rounded-full text-sm w-8 h-8 inline-flex justify-center items-center shadow-lg"
                                            data-modal-hide="detail-modal-{{ $ad->id }}">
                                            ✕
                                        </button>
                                        
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
                                        
                                        <div class="max-h-96 overflow-y-auto">
                                            <div class="p-4">
                                                <h2 class="text-lg font-bold text-gray-900 mb-3">{{ $ad->ad_title }}</h2>
                                                
                                                @if($ad->product)
                                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                                            <span class="text-white text-xs font-bold">🛒</span>
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-medium text-blue-900">Sản phẩm:</p>
                                                            <p class="text-blue-700 font-semibold">{{ $ad->product->name }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <div class="prose prose-sm max-w-none mb-4">
                                                    <div class="text-gray-800 whitespace-pre-line leading-relaxed">{{ $ad->ad_content }}</div>
                                                </div>
                                                
                                                @if($ad->hashtags)
                                                <div class="mb-4">
                                                    <div class="text-blue-600 font-medium text-sm">
                                                        {!! str_replace('#', '<span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-1 mb-1">#</span>', nl2br(e($ad->hashtags))) !!}
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            
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
                                        
                                        <div class="absolute bottom-2 right-2 opacity-50">
                                            <div class="bg-black bg-opacity-20 text-white text-xs px-2 py-1 rounded">
                                                📸 AI Content Preview
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal xác nhận xóa -->
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
                                                <form action="{{ route('dashboard.content_creator.destroy', $ad->id) }}" method="POST" class="inline">
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
                @if($items->hasPages())
                    <div class="mt-6 flex items-center justify-center">
                        {{ $items->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-dashboard> --}}

<x-app-dashboard>
  <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Upload Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Tải lên Media</h3>
                    <span class="text-sm text-gray-500">Hỗ trợ: JPG, PNG, MP4, MOV (Tối đa 100MB)</span>
                </div>
                
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click để tải lên</span> hoặc kéo thả file vào đây</p>
                            <p class="text-xs text-gray-500">Chọn ảnh hoặc video để bắt đầu chỉnh sửa</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" accept="image/*,video/*" />
                    </label>
                </div>
            </div>

            <!-- Main Editor Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Sidebar - Tools -->
                <div class="lg:col-span-1 space-y-4">
                    
                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-md p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Thao Tác Nhanh</h3>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button" class="flex flex-col items-center justify-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200 border border-gray-200">
                                <svg class="w-6 h-6 text-primary-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243 4.243 3 3 0 004.243-4.243zm0-5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"></path>
                                </svg>
                                <span class="text-xs font-medium">Cắt/Crop</span>
                            </button>
                            <button type="button" class="flex flex-col items-center justify-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200 border border-gray-200">
                                <svg class="w-6 h-6 text-primary-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"></path>
                                </svg>
                                <span class="text-xs font-medium">Resize</span>
                            </button>
                            <button type="button" class="flex flex-col items-center justify-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200 border border-gray-200">
                                <svg class="w-6 h-6 text-primary-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-xs font-medium">Text</span>
                            </button>
                            <button type="button" class="flex flex-col items-center justify-center p-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors duration-200 border border-gray-200">
                                <svg class="w-6 h-6 text-primary-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                </svg>
                                <span class="text-xs font-medium">Watermark</span>
                            </button>
                        </div>
                    </div>

                    <!-- Editing Tools -->
                    <div class="bg-white rounded-lg shadow-md p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Công Cụ Chỉnh Sửa</h3>
                        
                        <!-- Brightness -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Độ sáng</label>
                            <input type="range" min="0" max="200" value="100" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        </div>

                        <!-- Contrast -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Độ tương phản</label>
                            <input type="range" min="0" max="200" value="100" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        </div>

                        <!-- Saturation -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Độ bão hòa</label>
                            <input type="range" min="0" max="200" value="100" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                        </div>

                        <!-- Rotation -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Xoay</label>
                            <div class="flex gap-2">
                                <button type="button" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                    </svg>
                                    90° trái
                                </button>
                                <button type="button" class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    90° phải
                                    <svg class="w-4 h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H11a8 8 0 00-8 8v2m18-10l-6-6m6 6l-6 6"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="bg-white rounded-lg shadow-md p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Bộ Lọc</h3>
                        <div class="grid grid-cols-3 gap-3">
                            <button type="button" class="flex flex-col items-center p-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-600 rounded mb-2"></div>
                                <span class="text-xs">Original</span>
                            </button>
                            <button type="button" class="flex flex-col items-center p-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-gray-300 to-gray-500 rounded mb-2"></div>
                                <span class="text-xs">B&W</span>
                            </button>
                            <button type="button" class="flex flex-col items-center p-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-200 to-orange-400 rounded mb-2"></div>
                                <span class="text-xs">Vintage</span>
                            </button>
                            <button type="button" class="flex flex-col items-center p-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-300 to-blue-500 rounded mb-2"></div>
                                <span class="text-xs">Cool</span>
                            </button>
                            <button type="button" class="flex flex-col items-center p-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-300 to-orange-500 rounded mb-2"></div>
                                <span class="text-xs">Warm</span>
                            </button>
                            <button type="button" class="flex flex-col items-center p-2 bg-gray-50 hover:bg-gray-100 rounded-lg transition-colors border border-gray-200">
                                <div class="w-12 h-12 bg-gradient-to-br from-purple-300 to-pink-400 rounded mb-2"></div>
                                <span class="text-xs">Vivid</span>
                            </button>
                        </div>
                    </div>

                </div>

                <!-- Center - Preview Area -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Preview</h3>
                            <div class="flex gap-2">
                                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </button>
                                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Zoom 100%
                                </button>
                            </div>
                        </div>
                        
                        <!-- Preview Canvas -->
                        <div class="bg-gray-100 rounded-lg flex items-center justify-center" style="min-height: 500px;">
                            <div class="text-center p-8">
                                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-lg">Tải lên media để bắt đầu chỉnh sửa</p>
                                <p class="text-gray-400 text-sm mt-2">Hỗ trợ ảnh (JPG, PNG) và video (MP4, MOV)</p>
                            </div>
                        </div>

                        <!-- Video Timeline (Show when video is loaded) -->
                        <div class="mt-6 hidden" id="video-timeline">
                            <div class="flex items-center gap-4">
                                <button type="button" class="p-2 text-primary-600 hover:bg-primary-50 rounded-lg">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div class="flex-1">
                                    <input type="range" min="0" max="100" value="0" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer">
                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                        <span>0:00</span>
                                        <span>0:30</span>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-600">0:00 / 0:30</span>
                            </div>
                        </div>
                    </div>

                    <!-- Export Settings -->
                    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Cài Đặt Xuất</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Định dạng</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option>MP4 (H.264)</option>
                                    <option>WEBM</option>
                                    <option>MOV</option>
                                    <option>JPG</option>
                                    <option>PNG</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Chất lượng</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option>Cao (1080p)</option>
                                    <option>Trung bình (720p)</option>
                                    <option>Thấp (480p)</option>
                                    <option>Tùy chỉnh</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tối ưu cho</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option>Facebook/Instagram</option>
                                    <option>YouTube</option>
                                    <option>TikTok</option>
                                    <option>Website</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kích thước</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500">
                                    <option>Giữ nguyên</option>
                                    <option>1920x1080 (16:9)</option>
                                    <option>1080x1080 (1:1)</option>
                                    <option>1080x1920 (9:16)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>  
</x-app-dashboard>