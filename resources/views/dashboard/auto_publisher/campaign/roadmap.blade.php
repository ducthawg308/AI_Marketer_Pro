<x-app-dashboard>
    <div class="container mx-auto px-8 py-8">
        <!-- Header -->
        <header class="mb-8 bg-gradient-to-r from-white via-gray-50 to-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-3 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Roadmap chiến dịch</h1>
                            <p class="text-base text-gray-600">Quản lý tính lịch đăng bài theo chiến dịch</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="text-right text-sm text-gray-600">
                            <p class="font-medium">{{ $campaign->name }}</p>
                            <p> từ {{ $campaign->start_date->format('d/m/Y') }}</p>
                            <p>đến {{ $campaign->end_date ? $campaign->end_date->format('d/m/Y') : 'Không giới hạn' }}</p>
                        </div>
                        @if($campaign->status == 'draft')
                            <span class="px-4 py-2 text-sm font-medium bg-yellow-100 text-yellow-800 rounded-full">
                                Nháp
                            </span>
                        @elseif($campaign->status == 'active')
                            <span class="px-4 py-2 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                                Đang chạy
                            </span>
                        @else
                            <span class="px-4 py-2 text-sm font-medium bg-gray-100 text-gray-800 rounded-full">
                                {{ ucfirst($campaign->status) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-2 gap-6 mb-8 lg:grid-cols-4">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-4V3a2 2 0 00-2-2H7a2 2 0 00-2 2v4a2 2 0 002 2h10a2 2 0 002-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 15a2 2 0 012-2h6a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $statistics['total_posts'] }}</div>
                <div class="text-sm text-gray-600 font-medium">Tổng bài đăng</div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $statistics['total_days'] }}</div>
                <div class="text-sm text-gray-600 font-medium">Tổng ngày</div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $statistics['total_platforms'] }}</div>
                <div class="text-sm text-gray-600 font-medium">Nền tảng</div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-2">{{ $statistics['avg_posts'] }}</div>
                <div class="text-sm text-gray-600 font-medium">TB/ngày</div>
            </div>
        </div>

        <!-- Content Management Area -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mb-8">
            <div class="border-b border-gray-200 p-6">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16l13-8L7 4z"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-medium text-gray-900">Tạo roadmap</h2>
                </div>
                <p class="text-sm text-gray-600 mt-2">Kéo thả content từ danh sách bên trái vào các slot theo thời gian</p>
            </div>

            <!-- Content Area -->
            <div class="p-6">
                <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
                    <!-- Ads Sidebar -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6">
                            <div class="flex items-center space-x-3 mb-4">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2H9a2 2 0 01-2-2v-2a2 2 0 012-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Content đã có</h3>
                            </div>
                            <div id="ads-list" class="space-y-4 max-h-96 overflow-y-auto">
                                @foreach($ads as $ad)
                                    <div class="ad-item bg-white p-4 border border-gray-200 rounded-xl cursor-move hover:border-primary-300 hover:shadow-md transition-all duration-200"
                                         data-ad-id="{{ $ad->id }}">
                                        <div class="flex items-start space-x-3">
                                            @php
                                                $image = $ad->adImages->first();
                                            @endphp
                                            @if($image)
                                                <img src="{{ Storage::disk('public')->url($image->image_path) }}"
                                                     alt="Ad Image"
                                                     class="w-12 h-12 object-cover rounded-lg flex-shrink-0 shadow-sm">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center shadow-sm">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-medium text-sm text-gray-900 truncate">{{ $ad->ad_title }}</h4>
                                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($ad->ad_content, 60) }}</p>
                                                <span class="inline-block px-2 py-1 text-xs rounded-full mt-2 font-medium
                                                    {{ $ad->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $ad->status == 'approved' ? '✓ Đã duyệt' : '⏳ Nháp' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Roadmap Timeline -->
                    <div class="lg:col-span-3">
                        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6">
                            <div class="flex items-center space-x-3 mb-6">
                                <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Lịch đăng theo thời gian</h3>
                            </div>
                            <div class="space-y-6 max-h-96 overflow-y-auto" id="roadmap">
                                @foreach($roadmap as $day)
                                    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden hover:shadow-md transition-shadow duration-200">
                                        <div class="flex items-center justify-between p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                                            <div class="flex items-center space-x-4">
                                                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center shadow-sm">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-lg text-gray-900">{{ $day['day_name'] }}</h4>
                                                    <p class="text-sm text-gray-600">{{ $day['date']->format('d/m/Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-2xl font-bold text-primary-600">{{ $day['post_count'] }}</div>
                                                <div class="text-sm text-gray-600 font-medium">bài đăng</div>
                                            </div>
                                        </div>
                                        <div class="p-6">
                                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-{{ min(4, $day['post_count']) }}">
                                                @foreach($day['posts'] as $post)
                                                    <div class="slot-item bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl p-4 flex items-center justify-between min-h-[80px] hover:bg-gray-100 hover:border-primary-300 transition-all duration-200 cursor-pointer group"
                                                         data-slot-id="{{ $post['slot_id'] }}"
                                                         data-date="{{ $day['date']->format('Y-m-d') }}"
                                                         data-time="{{ $post['suggested_time'] }}"
                                                         data-page-index="{{ $post['page_index'] }}">
                                                        <div class="flex-1">
                                                            <div class="text-lg font-semibold text-gray-900 mb-1">{{ $post['suggested_time'] }}</div>
                                                            <div class="text-sm text-gray-600">
                                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v2H8V5z"></path>
                                                                </svg>
                                                                Page {{ $post['page_index'] + 1 }}
                                                            </div>
                                                        </div>
                                                        <button class="remove-ad text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200 opacity-0 group-hover:opacity-100" data-slot-id="{{ $post['slot_id'] }}">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6">
                <div class="flex justify-end items-center space-x-4">
                    <a href="{{ route('dashboard.auto_publisher.campaign.index') }}"
                        class="px-6 py-3 text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Quay lại danh sách
                    </a>

                    <button type="button" id="save-draft"
                            class="px-6 py-3 text-white bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-xl hover:from-yellow-600 hover:to-yellow-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:shadow-lg flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Lưu nháp
                    </button>

                    <button type="button" id="launch-campaign"
                            class="px-6 py-3 text-white bg-gradient-to-r from-green-500 to-green-600 rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:hover:shadow-lg flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Khởi chạy chiến dịch
                    </button>
                </div>
            </div>
        </div>

        <!-- Ad Selection Modal -->
        <div id="ad-select-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen p-6">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
                    <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2H9a2 2 0 01-2-2v-2a2 2 0 012-2z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">Chọn Content</h3>
                            </div>
                            <button type="button" data-modal-toggle="ad-select-modal" class="text-gray-500 hover:text-gray-700 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-4 max-h-96 overflow-y-auto md:grid-cols-2" id="modal-ads-list">
                            @foreach($ads as $ad)
                                <div class="ad-selection-item cursor-pointer border border-gray-200 rounded-xl p-4 hover:bg-primary-50 hover:border-primary-300 hover:shadow-md transition-all duration-200"
                                     data-ad-id="{{ $ad->id }}">
                                    <div class="flex items-start space-x-3">
                                        @php
                                            $image = $ad->adImages->first();
                                        @endphp
                                        @if($image)
                                            <img src="{{ Storage::disk('public')->url($image->image_path) }}"
                                                 alt="Ad Image"
                                                 class="w-16 h-16 object-cover rounded-lg flex-shrink-0 shadow-sm">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center shadow-sm">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1">
                                            <h4 class="font-medium text-sm text-gray-900">{{ $ad->ad_title }}</h4>
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($ad->ad_content, 80) }}</p>
                                            <div class="flex items-center mt-2">
                                                <span class="inline-block px-2 py-1 text-xs rounded-full font-medium
                                                    {{ $ad->status == 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $ad->status == 'approved' ? '✓ Đã duyệt' : '⏳ Nháp' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                            <button type="button" id="cancel-select" class="px-6 py-3 text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Hủy bỏ
                            </button>
                            <button type="button" id="clear-slot" class="px-6 py-3 text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Xóa slot này
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden form for slot assignment -->
        <form id="slot-assignment-form" method="POST" style="display: none;">
            @csrf
            <input type="hidden" id="slot_data" name="slots" value="">
            <input type="hidden" name="campaign_id" value="{{ $campaign->id }}">
        </form>
    </div>

    <!-- Modal Thông báo xác nhận -->
    <div id="confirm-modal" tabindex="-1" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-6">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
                <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-orange-50 to-white">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 id="confirm-title" class="text-xl font-bold text-gray-900">Xác nhận hành động</h3>
                            <p class="text-sm text-gray-600 mt-1">Hãy suy nghĩ kỹ trước khi tiếp tục</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <p id="confirm-message" class="text-gray-700 mb-6">Bạn có chắc chắn muốn thực hiện hành động này?</p>

                    <div class="flex justify-end space-x-4">
                        <button type="button" onclick="closeConfirmModal()" class="px-6 py-3 text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors duration-200 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Hủy bỏ
                        </button>
                        <button type="button" onclick="executeConfirmedAction()" class="px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Xác nhận
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Thông báo thành công -->
    <div id="success-modal" tabindex="-1" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-6">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-green-50 to-white">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Thành công!</h3>
                    </div>
                </div>

                <div class="p-6 text-center">
                    <p id="success-message" class="text-gray-700 mb-6">Hành động đã được thực hiện thành công!</p>
                    <button type="button" onclick="closeSuccessModal()" class="px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 hover:scale-105">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let slotAssignments = {}; // Track ad assignments
            let currentEditingSlot = null;
            let pendingAction = null;

            // Drag and drop functionality
            const adsList = document.getElementById('ads-list');
            const slots = document.querySelectorAll('.slot-item');

            // Make ads draggable
            const adItems = adsList.querySelectorAll('.ad-item');
            adItems.forEach(ad => {
                ad.draggable = true;
                ad.addEventListener('dragstart', dragStart);
            });

            // Make slots droppable
            slots.forEach(slot => {
                slot.addEventListener('dragenter', dragEnter);
                slot.addEventListener('dragover', dragOver);
                slot.addEventListener('dragleave', dragLeave);
                slot.addEventListener('drop', drop);
                slot.addEventListener('click', editSlot);
            });

            // Remove ad buttons
            document.addEventListener('click', function(e) {
                if (e.target.closest('.remove-ad')) {
                    e.preventDefault();
                    const button = e.target.closest('.remove-ad');
                    const slotId = button.dataset.slotId;
                    removeAdFromSlot(slotId);
                }
            });

            function dragStart(e) {
                e.dataTransfer.setData('text/plain', e.target.dataset.adId);
                e.dataTransfer.effectAllowed = 'copy';
            }

            function dragEnter(e) {
                e.preventDefault();
                e.currentTarget.classList.add('border-primary-500', 'bg-primary-100');
            }

            function dragOver(e) {
                e.preventDefault();
                e.currentTarget.classList.add('border-primary-500', 'bg-primary-100');
            }

            function dragLeave(e) {
                e.currentTarget.classList.remove('border-primary-500', 'bg-primary-100');
            }

            function drop(e) {
                e.preventDefault();
                e.currentTarget.classList.remove('border-primary-500', 'bg-primary-100');

                const adId = e.dataTransfer.getData('text/plain');
                const slotId = e.currentTarget.dataset.slotId;

                assignAdToSlot(slotId, adId);
            }

            function assignAdToSlot(slotId, adId) {
                const slot = document.querySelector(`[data-slot-id="${slotId}"]`);
                const ad = document.querySelector(`[data-ad-id="${adId}"]`);

                // Clone ad content and put it in slot
                const adClone = ad.querySelector('.flex.items-start').cloneNode(true);
                adClone.className = 'flex items-start space-x-3 w-full';
                adClone.querySelector('h4').className = 'font-medium text-sm text-gray-900 truncate';
                adClone.querySelector('p').className = 'text-xs text-gray-500 mt-1 line-clamp-2';

                // Clear slot content and add new ad
                const slotContent = slot.querySelector('div:first-child');
                slotContent.innerHTML = '';
                slotContent.appendChild(adClone);

                // Change slot styling to indicate assignment
                slot.classList.remove('bg-gray-50', 'border-dashed', 'border-gray-300');
                slot.classList.add('bg-white', 'border-solid', 'border-green-300', 'shadow-sm');

                // Update remove button
                const removeBtn = slot.querySelector('.remove-ad');
                removeBtn.classList.remove('opacity-0');
                removeBtn.classList.add('opacity-100');

                // Store assignment
                slotAssignments[slotId] = adId;

                updateButtons();
            }

            function removeAdFromSlot(slotId) {
                const slot = document.querySelector(`[data-slot-id="${slotId}"]`);
                const originalContent = `
                    <div class="flex-1">
                        <div class="text-lg font-semibold text-gray-900 mb-1">${slot.dataset.time}</div>
                        <div class="text-sm text-gray-600">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h2a2 2 0 012 2v2H8V5z"></path>
                            </svg>
                            Page ${parseInt(slot.dataset.pageIndex) + 1}
                        </div>
                    </div>
                    <button class="remove-ad text-red-600 hover:text-red-800 p-2 rounded-lg hover:bg-red-50 transition-colors duration-200 opacity-0 group-hover:opacity-100" data-slot-id="${slotId}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;

                slot.innerHTML = originalContent;
                slot.classList.remove('bg-white', 'border-solid', 'border-green-300', 'shadow-sm');
                slot.classList.add('bg-gray-50', 'border-dashed', 'border-gray-300');

                delete slotAssignments[slotId];
                updateButtons();
            }

            function editSlot(e) {
                if (e.target.closest('.remove-ad')) return;

                currentEditingSlot = e.currentTarget.dataset.slotId;

                // Show modal
                document.getElementById('ad-select-modal').classList.remove('hidden');

                // Reset modal selections
                document.querySelectorAll('#modal-ads-list .ad-selection-item').forEach(item => {
                    item.classList.remove('bg-primary-100', 'border-primary-300', 'ring-2', 'ring-primary-500');
                });

                // Select current ad if exists
                if (slotAssignments[currentEditingSlot]) {
                    const currentAd = document.querySelector(`#modal-ads-list [data-ad-id="${slotAssignments[currentEditingSlot]}"]`);
                    if (currentAd) {
                        currentAd.classList.add('bg-primary-100', 'border-primary-300', 'ring-2', 'ring-primary-500');
                    }
                }
            }

            // Modal event listeners
            document.getElementById('cancel-select').addEventListener('click', function() {
                document.getElementById('ad-select-modal').classList.add('hidden');
                currentEditingSlot = null;
            });

            document.getElementById('clear-slot').addEventListener('click', function() {
                if (currentEditingSlot) {
                    removeAdFromSlot(currentEditingSlot);
                    document.getElementById('ad-select-modal').classList.add('hidden');
                    currentEditingSlot = null;
                }
            });

            // Ad selection in modal
            document.addEventListener('click', function(e) {
                if (e.target.closest('.ad-selection-item')) {
                    const item = e.target.closest('.ad-selection-item');
                    const adId = item.dataset.adId;

                    // Remove previous selections
                    document.querySelectorAll('#modal-ads-list .ad-selection-item').forEach(item => {
                        item.classList.remove('bg-primary-100', 'border-primary-300', 'ring-2', 'ring-primary-500');
                    });

                    // Select new item
                    item.classList.add('bg-primary-100', 'border-primary-300', 'ring-2', 'ring-primary-500');
                }
            });

            document.addEventListener('dblclick', function(e) {
                if (e.target.closest('.ad-selection-item')) {
                    const adItem = e.target.closest('.ad-selection-item');
                    const adId = adItem.dataset.adId;

                    if (currentEditingSlot) {
                        assignAdToSlot(currentEditingSlot, adId);
                        document.getElementById('ad-select-modal').classList.add('hidden');
                        currentEditingSlot = null;
                    }
                }
            });

            function updateButtons() {
                const hasAssignments = Object.keys(slotAssignments).length > 0;
                const totalSlots = document.querySelectorAll('.slot-item').length;
                const assignedSlots = Object.keys(slotAssignments).length;
                const allSlotsFilled = assignedSlots === totalSlots;

                document.getElementById('save-draft').disabled = !hasAssignments;
                document.getElementById('launch-campaign').disabled = !allSlotsFilled;
            }

            // Modal functions
            function showConfirmModal(message, title = 'Xác nhận hành động', confirmCallback = null) {
                document.getElementById('confirm-title').textContent = title;
                document.getElementById('confirm-message').textContent = message;
                pendingAction = confirmCallback;
                document.getElementById('confirm-modal').classList.remove('hidden');
            }

            function closeConfirmModal() {
                document.getElementById('confirm-modal').classList.add('hidden');
                pendingAction = null;
            }

            function executeConfirmedAction() {
                if (pendingAction && typeof pendingAction === 'function') {
                    pendingAction();
                }
                closeConfirmModal();
            }

            function showSuccessModal(message) {
                document.getElementById('success-message').textContent = message;
                document.getElementById('success-modal').classList.remove('hidden');
            }

            function closeSuccessModal() {
                document.getElementById('success-modal').classList.add('hidden');
            }

            // Action buttons - replaced confirm() with showConfirmModal()
            document.getElementById('save-draft').addEventListener('click', function() {
                showConfirmModal(
                    'Bạn có chắc muốn lưu nháp chiến dịch?',
                    'Lưu nháp chiến dịch',
                    function() {
                        saveAssignments('draft');
                    }
                );
            });

            document.getElementById('launch-campaign').addEventListener('click', function() {
                showConfirmModal(
                    'Bạn có chắc muốn khởi chạy chiến dịch? Sau khi khởi chạy sẽ không thể sửa đổi lịch đăng.',
                    'Khởi chạy chiến dịch',
                    function() {
                        saveAssignments('launch');
                    }
                );
            });

            function saveAssignments(action) {
                // Convert slotAssignments to array format needed by backend
                const slotsData = Object.entries(slotAssignments).map(([slotId, adId]) => {
                    const slot = document.querySelector(`[data-slot-id="${slotId}"]`);
                    return {
                        date: slot.dataset.date,
                        time: slot.dataset.time,
                        page_index: parseInt(slot.dataset.pageIndex),
                        ad_id: parseInt(adId)
                    };
                });

                document.getElementById('slot_data').value = JSON.stringify(slotsData);

                const form = document.getElementById('slot-assignment-form');
                form.action = action === 'draft' ? '{{ route("dashboard.auto_publisher.campaign.update", $campaign->id) }}' : '{{ route("dashboard.auto_publisher.campaign.launch", $campaign->id) }}';
                form.submit();
            }

            // Make modal functions globally available
            window.closeConfirmModal = closeConfirmModal;
            window.executeConfirmedAction = executeConfirmedAction;
            window.closeSuccessModal = closeSuccessModal;
        });
    </script>

    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        /* Custom scrollbar */
        #ads-list::-webkit-scrollbar,
        #roadmap::-webkit-scrollbar,
        #modal-ads-list::-webkit-scrollbar {
            width: 6px;
        }

        #ads-list::-webkit-scrollbar-track,
        #roadmap::-webkit-scrollbar-track,
        #modal-ads-list::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        #ads-list::-webkit-scrollbar-thumb,
        #roadmap::-webkit-scrollbar-thumb,
        #modal-ads-list::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        #ads-list::-webkit-scrollbar-thumb:hover,
        #roadmap::-webkit-scrollbar-thumb:hover,
        #modal-ads-list::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</x-app-dashboard>
