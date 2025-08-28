<x-app-dashboard>
    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <!-- Header -->
        <header class="mb-8 bg-gradient-to-r from-white via-blue-50 to-white rounded-2xl shadow-lg border border-blue-200 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-3 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Lên lịch bình thường</h1>
                            <p class="text-base text-gray-600">Tạo lịch đăng đơn giản cho các bài viết của bạn</p>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Normal Scheduling Form -->
        <form id="normal-schedule-form" action="{{ route('dashboard.auto_publisher.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                <!-- Left Panel - Content Selection -->
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            Chọn nội dung
                        </h2>
                    </div>

                    <div class="p-8">
                        <!-- Content Search -->
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Tìm kiếm nội dung</label>
                            <div class="relative">
                                <input type="text" id="search-input" class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 transition-all duration-200" placeholder="Nhập từ khóa tìm kiếm..." onkeyup="filterAds()">
                                <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        <!-- Content List -->
                        <div id="content-list" class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
                            @foreach($ads as $ad)
                            <div class="border border-gray-200 rounded-xl p-5 hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition-all duration-300 group ad-item" data-title="{{ $ad->ad_title }}">
                                <div class="flex items-start space-x-4">
                                    <input type="checkbox" name="selected_ads[]" value="{{ $ad->id }}" class="mt-2 w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500 transition-all duration-200">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between mb-3">
                                            <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-700 transition-colors duration-200">{{ $ad->ad_title }}</h3>
                                        </div>
                                        <p class="text-gray-700 mb-4 leading-relaxed" title="{{ $ad->ad_content }}">{{ Str::limit($ad->ad_content, 100) }}</p>
                                        <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                            @if($ad->link)
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                1 liên kết
                                            </span>
                                            @endif
                                            @if($ad->hashtags)
                                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                                {{ count(explode(',', $ad->hashtags)) }} hashtag
                                            </span>
                                            @endif
                                            @if($ad->emojis)
                                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                                                </svg>
                                                {{ count(explode(',', $ad->emojis)) }} emoji
                                            </span>
                                            @endif
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                                </svg>
                                                Tạo: {{ $ad->created_at->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Panel - Scheduling Options -->
                <div class="space-y-8">
                    <!-- Scheduling Settings -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-8 py-6 border-b border-gray-200">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                                <div class="w-10 h-10 bg-primary-500 rounded-xl flex items-center justify-center mr-4">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                Cài đặt lịch đăng
                            </h2>
                        </div>

                        <div class="p-8 space-y-8">
                            <!-- Page Selection -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-4">Chọn Page</label>
                                <div class="space-y-3 max-h-48 overflow-y-auto">
                                    @foreach($user_pages as $page)
                                    <label class="flex items-center p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-300 group">
                                        <input type="checkbox" name="selected_pages[]" class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-4" value="{{ $page->id }}">
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $page->page_name }}</div>
                                            <div class="text-sm text-gray-600">{{ $page->fan_count }} followers</div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Date & Time -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Ngày giờ đăng</label>
                                <input type="text" name="scheduled_time" id="normal-datepicker" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-4 focus:ring-primary-200 focus:border-primary-500 transition-all duration-200" data-datepicker data-datepicker-format="dd/mm/yyyy HH:MM" placeholder="Chọn ngày giờ đăng">
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 space-y-4">
                        <button type="submit" class="w-full bg-primary-600 text-white py-4 px-6 rounded-xl hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-6 h-6 mr-3 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                            Lên lịch đăng bài
                        </button>
                        <a href="{{ route('dashboard.auto_publisher.index') }}" class="w-full bg-gray-200 text-gray-800 py-4 px-6 rounded-xl hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-xl transform hover:-translate-y-1 text-center block">
                            <svg class="w-6 h-6 mr-3 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Quay về
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</x-app-dashboard>

<script>
    flatpickr("#normal-datepicker", {
        enableTime: true,
        dateFormat: "d/m/Y H:i",
        minDate: "today",
        defaultDate: new Date(),
        time_24hr: true,
        minuteIncrement: 1,
        onChange: function(selectedDates, dateStr, instance) {
            instance.input.value = dateStr;
        }
    });

    function filterAds() {
        let input = document.getElementById('search-input').value.toLowerCase();
        let adItems = document.getElementsByClassName('ad-item');
        
        for (let i = 0; i < adItems.length; i++) {
            let title = adItems[i].getAttribute('data-title').toLowerCase();
            if (title.includes(input)) {
                adItems[i].style.display = '';
            } else {
                adItems[i].style.display = 'none';
            }
        }
    }
</script>