<!-- Normal Scheduling Tab -->
<div id="normal-content" class="tab-content">
    <form id="normal-schedule-form" action="{{ route('dashboard.auto_publisher.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Panel - Content Selection -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-file-alt mr-3 text-primary-500"></i> Chọn nội dung
                </h2>
                <!-- Content Search -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm nội dung</label>
                    <div class="relative">
                        <input type="text" id="search-input" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-colors" placeholder="Nhập từ khóa...">
                        <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>
                <!-- Content List -->
                <div id="content-list" class="space-y-4 max-h-96 overflow-y-auto pr-2">
                    @foreach($ads as $ad)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 cursor-pointer transition-colors duration-200" data-title="{{ $ad->ad_title }}" data-content="{{ $ad->ad_content }}">
                        <div class="flex items-start space-x-3">
                            <input type="checkbox" name="selected_ads[]" value="{{ $ad->id }}" class="mt-1 w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">{{ $ad->ad_title }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ \Str::limit($ad->ad_content, 100) }}</p>
                                <div class="flex items-center mt-2 text-xs text-gray-500 space-x-3">
                                    @if($ad->type === 'link' && $ad->link)
                                    <span><i class="fas fa-link mr-1"></i>1 liên kết</span>
                                    @elseif($ad->hashtags)
                                    <span><i class="fas fa-hashtag mr-1"></i>{{ count(explode(',', $ad->hashtags)) }} hashtag</span>
                                    @elseif($ad->emojis)
                                    <span><i class="fas fa-smile mr-1"></i>{{ count(explode(',', $ad->emojis)) }} emoji</span>
                                    @endif
                                    <span><i class="fas fa-calendar mr-1"></i>Tạo: {{ $ad->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Panel - Scheduling Options -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-cog mr-3 text-primary-500"></i> Cài đặt lịch đăng
                </h2>
                <!-- Page Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Chọn Page</label>
                    <div class="grid grid-cols-1 gap-3 max-h-40 overflow-y-auto">
                        @foreach($user_pages as $page)
                        <label class="flex items-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors duration-200">
                            <input type="checkbox" name="selected_pages[]" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" value="{{ $page->id }}">
                            <i class="fab fa-facebook text-blue-600 mr-2"></i>
                            <span class="text-sm font-medium">{{ $page->page_name }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <!-- Date & Time -->
                <div class="grid grid-cols-1 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ngày giờ đăng</label>
                        <input type="text" name="scheduled_time" id="normal-datepicker" class="w-full p-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500" data-datepicker data-datepicker-format="dd/mm/yyyy" placeholder="Chọn ngày giờ đăng">
                    </div>
                </div>
                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button type="submit" class="flex-1 bg-primary-600 text-white py-3 px-4 rounded-lg hover:bg-primary-700 transition-colors font-semibold">
                        <i class="fas fa-calendar-plus mr-2"></i> Lên lịch đăng
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>