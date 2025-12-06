<x-app-dashboard title="Đối tượng mục tiêu">
    <div class="container mx-auto px-8 py-8">
        <!-- Quick Marketing Guide -->
        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-200 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <span class="text-2xl mr-2">🎯</span>
                    <h3 class="text-lg font-semibold text-gray-900">Quy trình Marketing</h3>
                </div>
                <span class="text-xs text-gray-500">Làm theo thứ tự để tối ưu hiệu quả</span>
            </div>

            <!-- Horizontal Flow -->
            <div class="grid grid-cols-5 gap-4 items-center mb-6">
                <!-- Bước 1 -->
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full {{ $items->count() > 0 ? 'bg-green-500 text-white' : 'bg-gray-300 text-gray-600' }} text-sm font-bold mb-2">
                        {{ $items->count() > 0 ? '✓' : '1' }}
                    </div>
                    <span class="text-xs text-center leading-tight {{$items->count() > 0 ? 'text-green-600 font-medium' : 'text-gray-500'}}">Định hướng KH</span>
                </div>

                <!-- Bước 2 -->
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-orange-400 text-white text-sm font-bold mb-2">
                        2
                    </div>
                    <span class="text-xs text-center leading-tight text-gray-600">Phân tích Market</span>
                </div>

                <!-- Bước 3 -->
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-pink-400 text-white text-sm font-bold mb-2">
                        3
                    </div>
                    <span class="text-xs text-center leading-tight text-gray-600">Tạo nội dung</span>
                </div>

                <!-- Bước 4 -->
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-purple-400 text-white text-sm font-bold mb-2">
                        4
                    </div>
                    <span class="text-xs text-center leading-tight text-gray-600">Auto Publish</span>
                </div>

                <!-- Bước 5 -->
                <div class="flex flex-col items-center">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-green-400 text-white text-sm font-bold mb-2">
                        5
                    </div>
                    <span class="text-xs text-center leading-tight text-gray-600">Theo dõi</span>
                </div>
            </div>

            <!-- Quick Actions with Flow Lines -->
            <div class="relative">
                <!-- Flow connectors -->
                <div class="absolute top-2 left-0 right-0 h-0.5 bg-gradient-to-r from-primary-200 via-orange-200 via-pink-200 via-purple-200 to-green-200 rounded"></div>

                <!-- Action Buttons Grid -->
                <div class="grid grid-cols-5 gap-4 relative">
                    @if($items->isEmpty())
                        <div class="flex justify-center">
                            <a href="{{ route('dashboard.audience_config.create') }}" class="inline-flex items-center px-3 py-2 bg-primary-100 text-primary-700 text-xs rounded-lg hover:bg-primary-200 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Bắt đầu
                            </a>
                        </div>
                        <div></div><div></div><div></div><div></div>
                    @else
                        <div class="flex justify-center">
                            <a href="{{ route('dashboard.audience_config.create') }}" class="inline-flex items-center px-3 py-2 bg-primary-100 text-primary-700 text-xs rounded-lg hover:bg-primary-200 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Thiết lập
                            </a>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('dashboard.market_analysis.index') }}" class="inline-flex items-center px-3 py-2 bg-orange-100 text-orange-700 text-xs rounded-lg hover:bg-orange-200 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Phân tích
                            </a>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('dashboard.content_creator.index') }}" class="inline-flex items-center px-3 py-2 bg-pink-100 text-pink-700 text-xs rounded-lg hover:bg-pink-200 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Tạo bài
                            </a>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('dashboard.auto_publisher.create') }}" class="inline-flex items-center px-3 py-2 bg-purple-100 text-purple-700 text-xs rounded-lg hover:bg-purple-200 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                </svg>
                                Đăng bài
                            </a>
                        </div>

                        <div class="flex justify-center">
                            <a href="{{ route('dashboard.campaign_tracking.index') }}" class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 text-xs rounded-lg hover:bg-green-200 transition-colors shadow-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Báo cáo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <!-- Header with Search -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-primary-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h2 class="text-xl font-semibold text-gray-900">Danh sách đối tượng mục tiêu</h2>
                    </div>
                    <a href="{{ route('dashboard.audience_config.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Thêm đối tượng mục tiêu
                    </a>
                </div>

                <!-- Search and Filter Section -->
                <form method="GET" action="{{ route('dashboard.audience_config.index') }}" class="space-y-3">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" name="keyword" value="{{ $search['keyword'] ?? '' }}" placeholder="Tìm kiếm theo tên sản phẩm..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 text-sm bg-gray-50 focus:bg-white">
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <select name="industry" class="block px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 text-sm bg-gray-50 focus:bg-white min-w-[150px]">
                                <option value="">Tất cả ngành nghề</option>
                                @foreach($items->pluck('industry')->unique() as $industry)
                                    <option value="{{ $industry }}" {{ ($search['industry'] ?? '') === $industry ? 'selected' : '' }}>{{ $industry }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200 whitespace-nowrap">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Lọc
                            </button>
                        </div>
                    </div>
                    @if(!empty(array_filter($search ?? [])))
                        <div class="flex justify-start">
                            <a href="{{ route('dashboard.audience_config.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm font-medium rounded-lg hover:bg-gray-600 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Xóa bộ lọc
                            </a>
                        </div>
                    @endif
                </form>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-primary-50 to-primary-100">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Tên sản phẩm
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        Ngành nghề
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-primary-700 uppercase tracking-wider">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Hành động
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($items as $item)
                                <tr class="hover:bg-primary-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ Str::limit($item->name, 80) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ Str::limit($item->industry, 30) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <button data-modal-target="modal-{{ $item->id }}" data-modal-toggle="modal-{{ $item->id }}" class="text-primary-600 hover:text-primary-800 font-medium transition-colors">Xem chi tiết</button>
                                    </td>
                                </tr>

                                <!-- Modal Chi tiết -->
                                <div id="modal-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-2xl max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Chi tiết: {{ $item->name }}
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modal-{{ $item->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <div class="p-6 space-y-4">
                                                <p><strong>Ngành:</strong> {{ $item->industry }}</p>
                                                <p><strong>Mô tả:</strong> {{ $item->description }}</p>
                                                <p><strong>Độ tuổi:</strong> {{ $item->target_customer_age_range }}</p>
                                                <p><strong>Thu nhập:</strong> {{ $item->target_customer_income_level }}</p>
                                                <p><strong>Sở thích:</strong> {{ $item->target_customer_interests }}</p>
                                                <p><strong>Đối thủ:</strong> {{ $item->competitor_name }}</p>
                                                <p><strong>URL đối thủ:</strong> <a href="{{ $item->competitor_url }}" target="_blank" class="text-primary-600 hover:underline">{{ Str::limit($item->competitor_url, 50) }}</a></p>
                                                <p><strong>Mô tả đối thủ:</strong> {{ $item->competitor_description }}</p>
                                            </div>
                                            <div class="flex justify-end p-4 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                <a href="{{ route('dashboard.audience_config.edit', [$item->id]) }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    Sửa
                                                </a>
                                                <button type="button" data-modal-target="confirm-delete-{{ $item->id }}" data-modal-toggle="confirm-delete-{{ $item->id }}" class="ml-2 inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0a2 2 0 00-2 2v1h8V5a2 2 0 00-2-2z"></path></svg>
                                                    Xóa
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Xác nhận xóa -->
                                <div id="confirm-delete-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-md max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white absolute top-2 right-2" data-modal-hide="confirm-delete-{{ $item->id }}">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <div class="p-6 text-center">
                                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Bạn có chắc muốn xóa đối tượng "{{ $item->name }}"?</h3>
                                                <form action="{{ route('dashboard.audience_config.destroy', [$item->id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                        Đúng, xóa nó!
                                                    </button>
                                                </form>
                                                <button data-modal-hide="confirm-delete-{{ $item->id }}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Hủy</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @if($items->isEmpty())
                            <tr>
                                <td colspan="3" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center max-w-md mx-auto">
                                        <div class="p-4 bg-gray-100 rounded-full mb-6">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Chưa có đối tượng mục tiêu nào</h3>
                                        <p class="text-gray-500 mb-6 text-center">Tạo đối tượng mục tiêu đầu tiên để bắt đầu tối ưu hóa chiến dịch marketing của bạn.</p>
                                        <a href="{{ route('dashboard.audience_config.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200 shadow-sm">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tạo đối tượng mục tiêu đầu tiên
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <!-- Phân trang -->
                    @if($items->hasPages())
                        <div class="mt-6 flex items-center justify-center">
                            {{ $items->links('pagination::tailwind') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-dashboard>
