<x-app-dashboard>
    <style>
        .timeline-line {
            background: linear-gradient(to bottom, transparent 0%, #e5e7eb 50%, transparent 100%);
        }
        .post-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .modal-backdrop {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f5f9;
        }
    </style>

    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <div class="min-h-screen -m-6 p-6">
            <!-- Header -->
            <div class="bg-white shadow-lg border-b border-gray-200 rounded-2xl mb-6">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button onclick="goBack()" class="flex items-center text-gray-600 hover:text-primary-600 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                <span>Quay lại</span>
                            </button>
                            <h1 class="text-2xl font-bold text-gray-900">Xem Trước Lộ Trình Chiến Dịch</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-600">
                                <span class="font-medium" id="campaign-name">{{ $campaignInfo['name'] ?? 'Chiến dịch Marketing' }}</span>
                            </div>
                            <button onclick="launchCampaign()" class="bg-primary-600 text-white px-6 py-2 rounded-xl hover:bg-primary-700 transition-all duration-200 font-semibold flex items-center">
                                <i class="fas fa-rocket mr-2"></i>
                                Khởi chạy chiến dịch
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Info Banner -->
            <div class="bg-gradient-to-r from-primary-50 to-blue-50 rounded-2xl shadow-md p-6 mb-8 border border-primary-100">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Mục tiêu chiến dịch</div>
                        <div class="font-semibold text-gray-900">
                            @switch($campaignInfo['objective'] ?? 'awareness')
                                @case('awareness')
                                    Tăng nhận diện thương hiệu
                                    @break
                                @case('engagement')
                                    Tăng tương tác
                                    @break
                                @case('leads')
                                    Thu thập khách hàng tiềm năng
                                    @break
                                @case('sales')
                                    Tăng doanh số
                                    @break
                                @default
                                    Khác
                            @endswitch
                        </div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-600 mb-1">Tần suất đăng</div>
                        <div class="font-semibold text-gray-900">
                            @switch($campaignInfo['frequency'] ?? 'daily')
                                @case('daily')
                                    Hàng ngày - {{ $campaignInfo['posts_per_day'] ?? 2 }} bài/ngày
                                    @break
                                @case('weekly')
                                    Hàng tuần - {{ $campaignInfo['posts_per_day'] ?? 2 }} bài/tuần
                                    @break
                                @case('custom')
                                    Tùy chỉnh theo ngày
                                    @break
                            @endswitch
                        </div>
                    </div>
                    @if($campaignInfo['description'] ?? false)
                    <div class="md:col-span-2">
                        <div class="text-sm text-gray-600 mb-1">Mô tả</div>
                        <div class="text-gray-900">{{ $campaignInfo['description'] }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Campaign Statistics -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
                        <i class="fas fa-calendar-alt text-2xl text-primary-600 mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900" id="total-days">{{ $statistics['total_days'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Tổng số ngày</div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $campaignInfo['start_date']->format('d/m/Y') }} - {{ $campaignInfo['end_date']->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl">
                        <i class="fas fa-file-alt text-2xl text-green-600 mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900" id="total-posts">{{ $statistics['total_posts'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Tổng bài viết</div>
                        <div class="text-xs text-gray-500 mt-1">Cần thiết lập nội dung</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                        <i class="fas fa-share-alt text-2xl text-purple-600 mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900" id="total-platforms">{{ $statistics['total_platforms'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Nền tảng</div>
                        <div class="text-xs text-gray-500 mt-1">Facebook Pages</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-xl">
                        <i class="fas fa-chart-line text-2xl text-orange-600 mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900" id="avg-posts">{{ $statistics['avg_posts'] ?? 0 }}</div>
                        <div class="text-sm text-gray-600">Trung bình/ngày</div>
                        <div class="text-xs text-gray-500 mt-1">Bài đăng tự động</div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                    <i class="fas fa-road mr-3 text-primary-600"></i>
                    Lộ trình đăng bài ({{ count($roadmap) }} ngày có bài đăng)
                </h2>

                <div class="relative" id="timeline-container">
                    @forelse($roadmap as $index => $day)
                        <div class="relative flex items-start mb-8">
                            @if(!$loop->last)
                                <div class="absolute left-6 top-12 w-0.5 h-full timeline-line"></div>
                            @endif
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg z-10">
                                {{ $day['date']->format('d') }}
                            </div>
                            <div class="ml-6 flex-grow">
                                <div class="mb-3">
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        {{ $day['day_name'] }}, {{ $day['date']->format('d') }} Tháng {{ $day['date']->format('n') }} {{ $day['date']->format('Y') }}
                                        @if($day['date']->isToday())
                                            <span class="inline-block ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Hôm nay</span>
                                        @elseif($day['date']->isTomorrow())
                                            <span class="inline-block ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Ngày mai</span>
                                        @endif
                                    </h3>
                                    <div class="text-sm text-gray-500">
                                        {{ $day['post_count'] }} bài đăng trong ngày này
                                    </div>
                                </div>
                                
                                @if($day['post_count'] > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($day['posts'] as $post)
                                            <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                                onclick="openPostModal('{{ $day['date']->format('Y-m-d') }}', {{ $post['index'] }}, '{{ $day['day_name'] }}, {{ $day['date']->format('d') }} Tháng {{ $day['date']->format('n') }} {{ $day['date']->format('Y') }}')">
                                                <div class="flex items-center justify-between mb-3">
                                                    <div class="flex items-center">
                                                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                            <i class="fas fa-plus text-gray-600 text-sm"></i>
                                                        </div>
                                                        <span class="text-sm font-medium text-gray-700">{{ $post['title'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="text-xs text-gray-600 mb-2">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    <span class="font-medium">Đề xuất:</span> {{ $post['suggested_time'] }}
                                                </div>
                                                <div class="text-sm text-gray-500 italic post-content-preview">
                                                    Nhấn để thêm nội dung
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="bg-gray-100 rounded-xl p-4 text-center text-gray-500 italic">
                                        Không có bài đăng trong ngày này
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <i class="fas fa-calendar-times text-4xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-600 mb-2">Không có lộ trình đăng bài</h3>
                            <p class="text-gray-500">Vui lòng kiểm tra lại thông tin chiến dịch</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Post Content Modal -->
        <div id="post-modal" class="fixed inset-0 z-50 hidden modal-backdrop">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900">Thiết lập nội dung bài viết</h3>
                            <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                        </div>
                        <div class="mt-2 text-sm text-gray-600">
                            <span id="modal-date"></span> - <span id="modal-time">Chọn thời gian đăng</span>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Time Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Thời gian đăng bài</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="time" id="post-time" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200" value="09:00">
                                </div>
                                <div>
                                    <select id="time-presets" class="w-full p-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200" onchange="setPresetTime(this.value)">
                                        <option value="">Thời gian mẫu</option>
                                        <option value="07:00">7:00 AM - Sáng sớm</option>
                                        <option value="09:00">9:00 AM - Sáng</option>
                                        <option value="12:00">12:00 PM - Trưa</option>
                                        <option value="15:00">3:00 PM - Chiều</option>
                                        <option value="18:00">6:00 PM - Tối</option>
                                        <option value="21:00">9:00 PM - Tối muộn</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Content Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Chọn nội dung quảng cáo</label>
                            
                            <!-- Search Bar -->
                            <div class="relative mb-4">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" id="ad-search" placeholder="Tìm kiếm theo tiêu đề quảng cáo..." 
                                    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200">
                                <div id="search-clear" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer hidden">
                                    <i class="fas fa-times text-gray-400 hover:text-gray-600"></i>
                                </div>
                            </div>

                            <div id="content-list" class="space-y-4 max-h-[400px] overflow-y-auto pr-3 custom-scrollbar">
                                @foreach($ads as $ad)
                                <div class="border border-gray-200 rounded-xl p-5 hover:bg-blue-50 hover:border-blue-300 cursor-pointer transition-all duration-300 group ad-item" data-title="{{ strtolower($ad->ad_title) }}" data-content="{{ $ad->ad_content }}" data-id="{{ $ad->id }}">
                                    <div class="flex items-start space-x-4">
                                        <input type="radio" name="selected_ad" value="{{ $ad->id }}" class="mt-2 w-5 h-5 text-blue-600 border-gray-300 focus:ring-blue-500 transition-all duration-200 ad-radio">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-3">
                                                <h3 class="font-bold text-lg text-gray-900 group-hover:text-blue-700 transition-colors duration-200 ad-title">{{ $ad->ad_title }}</h3>
                                            </div>
                                            <p class="text-gray-700 mb-4 leading-relaxed" title="{{ $ad->ad_content }}">{{ Str::limit($ad->ad_content, 100) }}</p>
                                            <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                                @if($ad->link)
                                                <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full">1 liên kết</span>
                                                @endif
                                                @if($ad->hashtags)
                                                <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full">{{ count(explode(',', $ad->hashtags)) }} hashtag</span>
                                                @endif
                                                @if($ad->emojis)
                                                <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full">{{ count(explode(',', $ad->emojis)) }} emoji</span>
                                                @endif
                                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-full">
                                                    Tạo: {{ $ad->created_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- No results message -->
                            <div id="no-results" class="hidden text-center py-8 text-gray-500">
                                <i class="fas fa-search text-4xl text-gray-300 mb-3"></i>
                                <p>Không tìm thấy quảng cáo nào phù hợp</p>
                            </div>
                        </div>

                        <!-- Platform Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Nền tảng đăng</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($user_pages as $page)
                                <label class="flex items-center p-4 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-all duration-300 group">
                                    <input type="checkbox" name="selected_pages[]" class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-4 platform-checkbox" value="{{ $page->id }}">
                                    <div class="flex items-center flex-1">
                                        <!-- Avatar và Facebook Icon -->
                                        <div class="relative mr-3">
                                            <!-- Page Avatar -->
                                            <div class="w-10 h-10 rounded-lg overflow-hidden ring-2 ring-gray-200">
                                                @if($page->avatar_url)
                                                    <img src="{{ $page->avatar_url }}" 
                                                        alt="{{ $page->page_name }}" 
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
                                                        <span class="text-white font-bold text-lg">{{ substr($page->page_name, 0, 1) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Facebook Icon Badge -->
                                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center ring-2 ring-white">
                                                <i class="fab fa-facebook-f text-white text-xs"></i>
                                            </div>
                                        </div>
                                        <!-- Page Info -->
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $page->page_name }}</div>
                                            <div class="text-sm text-gray-600">{{ number_format($page->fan_count ?? 0) }} followers</div>
                                        </div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-4 pt-4">
                            <button onclick="savePost()" class="flex-1 bg-primary-600 text-white py-3 px-6 rounded-xl hover:bg-primary-700 transition-all duration-200 font-semibold flex items-center justify-center">
                                <i class="fas fa-save mr-2"></i>
                                Lưu bài viết
                            </button>
                            <button onclick="closeModal()" class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-xl hover:bg-gray-300 transition-all duration-200 font-semibold">
                                Hủy
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentEditingPost = null;
        let savedPosts = {};

        function openPostModal(date, index, formattedDate) {
            currentEditingPost = { date, index };
            const postKey = `${date}_${index}`;
            const existingPost = savedPosts[postKey];
            
            document.getElementById('modal-date').textContent = formattedDate;
            
            if (existingPost) {
                document.getElementById('post-time').value = existingPost.time || '09:00';
                document.getElementById('modal-time').textContent = existingPost.time || 'Chọn thời gian đăng';
                
                if (existingPost.ad_id) {
                    const adRadio = document.querySelector(`input[name="selected_ad"][value="${existingPost.ad_id}"]`);
                    if (adRadio) adRadio.checked = true;
                }
                
                document.querySelectorAll('.platform-checkbox').forEach(checkbox => {
                    checkbox.checked = existingPost.platforms && existingPost.platforms.includes(checkbox.value);
                });
            } else {
                document.getElementById('post-time').value = '09:00';
                document.getElementById('modal-time').textContent = 'Chọn thời gian đăng';
                
                document.querySelectorAll('input[name="selected_ad"]').forEach(radio => radio.checked = false);
                document.querySelectorAll('.platform-checkbox').forEach(checkbox => checkbox.checked = false);
            }
            
            document.getElementById('post-modal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('post-modal').classList.add('hidden');
            currentEditingPost = null;
        }

        function setPresetTime(time) {
            if (time) {
                document.getElementById('post-time').value = time;
                document.getElementById('modal-time').textContent = time;
            }
        }

        function savePost() {
            if (!currentEditingPost) return;

            const time = document.getElementById('post-time').value;
            const selectedAdRadio = document.querySelector('input[name="selected_ad"]:checked');
            const platforms = Array.from(document.querySelectorAll('.platform-checkbox:checked')).map(cb => cb.value);

            if (!selectedAdRadio) {
                alert('Vui lòng chọn nội dung quảng cáo!');
                return;
            }

            if (platforms.length === 0) {
                alert('Vui lòng chọn ít nhất một nền tảng để đăng!');
                return;
            }

            const selectedAdElement = selectedAdRadio.closest('.ad-item');
            const adTitle = selectedAdElement.querySelector('.ad-title').textContent;
            const adContent = selectedAdElement.dataset.content;
            const adId = selectedAdElement.dataset.id;

            const postData = { 
                date: currentEditingPost.date,
                post_index: currentEditingPost.index,
                time, 
                ad_id: adId,
                ad_title: adTitle,
                ad_content: adContent,
                platforms 
            };

            const postKey = `${currentEditingPost.date}_${currentEditingPost.index}`;
            savedPosts[postKey] = postData;
            updatePostCard(currentEditingPost.date, currentEditingPost.index, postData);
            closeModal();
            
            showNotification('Đã lưu bài viết thành công!', 'success');
        }

        function updatePostCard(date, index, postData) {
            const postCards = document.querySelectorAll('.post-card');
            postCards.forEach(card => {
                if (card.onclick.toString().includes(`'${date}', ${index}`)) {
                    card.classList.remove('border-dashed', 'border-gray-300');
                    card.classList.add('border-green-300', 'bg-green-50');
                    
                    const icon = card.querySelector('.fa-plus');
                    if (icon) {
                        icon.classList.remove('fa-plus', 'text-gray-600');
                        icon.classList.add('fa-check', 'text-white');
                        icon.parentElement.classList.remove('bg-gray-300');
                        icon.parentElement.classList.add('bg-green-500');
                    }
                    
                    const contentDiv = card.querySelector('.post-content-preview');
                    if (contentDiv) {
                        contentDiv.textContent = postData.ad_title;
                        contentDiv.classList.remove('text-gray-500', 'italic');
                        contentDiv.classList.add('text-gray-800');
                    }

                    const timeDiv = card.querySelector('.fas.fa-clock').parentElement;
                    if (timeDiv) {
                        timeDiv.innerHTML = `<i class="fas fa-clock mr-1"></i><span class="font-medium">Lên lịch:</span> ${postData.time}`;
                    }
                }
            });

            updateStatistics();
        }

        function updateStatistics() {
            const totalScheduledPosts = Object.values(savedPosts).filter(post => post.ad_title).length;
            const totalPostsElement = document.getElementById('total-posts');
            
            if (totalPostsElement) {
                const originalTotal = {{ $statistics['total_posts'] ?? 0 }};
                totalPostsElement.innerHTML = `${totalScheduledPosts}<span class="text-sm text-gray-500">/${originalTotal}</span>`;
            }
        }

        function goBack() {
            if (Object.keys(savedPosts).length > 0) {
                if (confirm('Bạn có chắc chắn muốn quay lại? Các thay đổi chưa lưu sẽ bị mất.')) {
                    window.history.back();
                }
            } else {
                window.history.back();
            }
        }

        async function launchCampaign() {
            const totalScheduledPosts = Object.values(savedPosts).filter(post => post.ad_title).length;
            
            if (totalScheduledPosts === 0) {
                showNotification('Vui lòng thiết lập nội dung cho ít nhất một bài viết trước khi khởi chạy chiến dịch.', 'error');
                return;
            }
            
            if (confirm(`Bạn đã thiết lập nội dung cho ${totalScheduledPosts} bài viết. Bạn có chắc chắn muốn khởi chạy chiến dịch không?`)) {
                showNotification('Đang khởi chạy chiến dịch...', 'info');
                
                const campaignData = {
                    campaign_name: document.getElementById('campaign-name').textContent,
                    posts: Object.values(savedPosts).map(post => ({
                        scheduled_date: post.date,
                        scheduled_time: post.time,
                        ad_id: post.ad_id,
                        page_ids: post.platforms
                    }))
                };
                
                try {
                    const response = await fetch('{{ route("dashboard.campaign.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(campaignData)
                    });
                    
                    const result = await response.json();
                    
                    if (response.ok) {
                        showNotification('Chiến dịch đã được khởi chạy thành công!', 'success');
                        
                        setTimeout(() => {
                            if (result.redirect_url) {
                                window.location.href = result.redirect_url;
                            } else {
                                window.location.href = '{{ route("dashboard.auto_publisher.index") }}';
                            }
                        }, 2000);
                    } else {
                        showNotification(result.message || 'Có lỗi xảy ra khi khởi chạy chiến dịch.', 'error');
                    }
                } catch (error) {
                    console.error('Error launching campaign:', error);
                    showNotification('Có lỗi xảy ra khi kết nối đến máy chủ.', 'error');
                }
            }
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-60 p-4 rounded-lg shadow-lg transition-all duration-300 ${
                type === 'success' ? 'bg-green-500 text-white' :
                type === 'error' ? 'bg-red-500 text-white' :
                type === 'warning' ? 'bg-yellow-500 text-white' :
                'bg-blue-500 text-white'
            }`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const timeInput = document.getElementById('post-time');
            if (timeInput) {
                timeInput.addEventListener('change', function() {
                    document.getElementById('modal-time').textContent = this.value;
                });
            }

            document.querySelectorAll('.ad-item').forEach(item => {
                item.addEventListener('click', function(e) {
                    if (e.target.type !== 'radio') {
                        const radio = this.querySelector('input[name="selected_ad"]');
                        radio.checked = true;
                    }
                });
            });

            const searchInput = document.getElementById('ad-search');
            const searchClear = document.getElementById('search-clear');
            const contentList = document.getElementById('content-list');
            const noResults = document.getElementById('no-results');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase().trim();
                    const adItems = contentList.querySelectorAll('.ad-item');
                    let visibleCount = 0;

                    if (searchTerm) {
                        searchClear.classList.remove('hidden');
                    } else {
                        searchClear.classList.add('hidden');
                    }

                    adItems.forEach(item => {
                        const title = item.dataset.title;
                        if (title.includes(searchTerm)) {
                            item.style.display = 'block';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    if (visibleCount === 0 && searchTerm) {
                        noResults.classList.remove('hidden');
                        contentList.classList.add('hidden');
                    } else {
                        noResults.classList.add('hidden');
                        contentList.classList.remove('hidden');
                    }
                });

                searchClear.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                    searchInput.focus();
                });
            }
        });

        document.getElementById('post-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('post-modal').classList.contains('hidden')) {
                closeModal();
            }
        });
    </script>
</x-app-dashboard>