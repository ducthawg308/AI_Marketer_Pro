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
    </style>

    <div class="container mx-auto px-6 py-8 max-w-7xl">
        <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen -m-6 p-6">
            <!-- Header -->
            <div class="bg-white shadow-lg border-b border-gray-200 rounded-2xl mb-6">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <button onclick="goBack()" class="flex items-center text-gray-600 hover:text-primary-600 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>
                                <span>Quay lại</span>
                            </button>
                            <h1 class="text-2xl font-bold text-gray-900">Xem Trước Lịch Chiến Dịch</h1>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-sm text-gray-600">
                                <span class="font-medium" id="campaign-name">Chiến dịch Marketing Q4 2024</span>
                            </div>
                            <button onclick="launchCampaign()" class="bg-primary-600 text-white px-6 py-2 rounded-xl hover:bg-primary-700 transition-all duration-200 font-semibold flex items-center">
                                <i class="fas fa-rocket mr-2"></i>
                                Khởi chạy chiến dịch
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Info Summary -->
            <div class="bg-white rounded-2xl shadow-xl p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl">
                        <i class="fas fa-calendar-alt text-2xl text-primary-600 mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900" id="total-days">7</div>
                        <div class="text-sm text-gray-600">Tổng số ngày</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl">
                        <i class="fas fa-file-alt text-2xl text-green-600 mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900" id="total-posts">14</div>
                        <div class="text-sm text-gray-600">Tổng bài viết</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl">
                        <i class="fas fa-share-alt text-2xl text-purple-600 mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900" id="total-platforms">3</div>
                        <div class="text-sm text-gray-600">Nền tảng</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-r from-orange-50 to-red-50 rounded-xl">
                        <i class="fas fa-chart-line text-2xl text-orange-600 mb-2"></i>
                        <div class="text-2xl font-bold text-gray-900" id="avg-posts">2</div>
                        <div class="text-sm text-gray-600">Trung bình/ngày</div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 flex items-center">
                    <i class="fas fa-road mr-3 text-primary-600"></i>
                    Lộ trình đăng bài
                </h2>

                <div class="relative" id="timeline-container">
                    <!-- Day 1 -->
                    <div class="relative flex items-start mb-8">
                        <div class="absolute left-6 top-12 w-0.5 h-full timeline-line"></div>
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg z-10">
                            23
                        </div>
                        <div class="ml-6 flex-grow">
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Thứ Hai, 23 Tháng 9 2024
                                    <span class="inline-block ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Hôm nay</span>
                                </h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                    onclick="openPostModal('2024-09-23', 0, 'Thứ Hai, 23 Tháng 9 2024')">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Bài viết 1</span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        09:00
                                    </div>
                                    <div class="text-sm text-gray-500 italic">
                                        Nhấn để thêm nội dung
                                    </div>
                                </div>
                                <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                    onclick="openPostModal('2024-09-23', 1, 'Thứ Hai, 23 Tháng 9 2024')">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Bài viết 2</span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        18:00
                                    </div>
                                    <div class="text-sm text-gray-500 italic">
                                        Nhấn để thêm nội dung
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Day 2 -->
                    <div class="relative flex items-start mb-8">
                        <div class="absolute left-6 top-12 w-0.5 h-full timeline-line"></div>
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg z-10">
                            26
                        </div>
                        <div class="ml-6 flex-grow">
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">Thứ Năm, 26 Tháng 9 2024</h3>
                            </div>
                            <div class="bg-gray-100 rounded-xl p-4 text-center text-gray-500 italic">
                                Không có bài đăng trong ngày này
                            </div>
                        </div>
                    </div>

                    <!-- Day 1 -->
                    <div class="relative flex items-start mb-8">
                        <div class="absolute left-6 top-12 w-0.5 h-full timeline-line"></div>
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg z-10">
                            23
                        </div>
                        <div class="ml-6 flex-grow">
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Thứ Hai, 23 Tháng 9 2024
                                    <span class="inline-block ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Hôm nay</span>
                                </h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                    onclick="openPostModal('2024-09-23', 0, 'Thứ Hai, 23 Tháng 9 2024')">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Bài viết 1</span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        09:00
                                    </div>
                                    <div class="text-sm text-gray-500 italic">
                                        Nhấn để thêm nội dung
                                    </div>
                                </div>
                                <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                    onclick="openPostModal('2024-09-23', 1, 'Thứ Hai, 23 Tháng 9 2024')">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Bài viết 2</span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        18:00
                                    </div>
                                    <div class="text-sm text-gray-500 italic">
                                        Nhấn để thêm nội dung
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Day 1 -->
                    <div class="relative flex items-start mb-8">
                        <div class="absolute left-6 top-12 w-0.5 h-full timeline-line"></div>
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg z-10">
                            23
                        </div>
                        <div class="ml-6 flex-grow">
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Thứ Hai, 23 Tháng 9 2024
                                    <span class="inline-block ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Hôm nay</span>
                                </h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                    onclick="openPostModal('2024-09-23', 0, 'Thứ Hai, 23 Tháng 9 2024')">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Bài viết 1</span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        09:00
                                    </div>
                                    <div class="text-sm text-gray-500 italic">
                                        Nhấn để thêm nội dung
                                    </div>
                                </div>
                                <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                    onclick="openPostModal('2024-09-23', 1, 'Thứ Hai, 23 Tháng 9 2024')">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Bài viết 2</span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        18:00
                                    </div>
                                    <div class="text-sm text-gray-500 italic">
                                        Nhấn để thêm nội dung
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Day 1 -->
                    <div class="relative flex items-start mb-8">
                        <div class="absolute left-6 top-12 w-0.5 h-full timeline-line"></div>
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg z-10">
                            23
                        </div>
                        <div class="ml-6 flex-grow">
                            <div class="mb-3">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Thứ Hai, 23 Tháng 9 2024
                                    <span class="inline-block ml-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Hôm nay</span>
                                </h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                    onclick="openPostModal('2024-09-23', 0, 'Thứ Hai, 23 Tháng 9 2024')">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Bài viết 1</span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        09:00
                                    </div>
                                    <div class="text-sm text-gray-500 italic">
                                        Nhấn để thêm nội dung
                                    </div>
                                </div>
                                <div class="post-card border-2 border-dashed border-gray-300 rounded-xl p-4 hover:shadow-lg transition-all duration-200 cursor-pointer" 
                                    onclick="openPostModal('2024-09-23', 1, 'Thứ Hai, 23 Tháng 9 2024')">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-plus text-gray-600 text-sm"></i>
                                            </div>
                                            <span class="text-sm font-medium text-gray-700">Bài viết 2</span>
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-600 mb-2">
                                        <i class="fas fa-clock mr-1"></i>
                                        18:00
                                    </div>
                                    <div class="text-sm text-gray-500 italic">
                                        Nhấn để thêm nội dung
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Content Modal -->
        <div id="post-modal" class="fixed inset-0 z-50 hidden modal-backdrop">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
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
                                        <option value="09:00">9:00 AM - Sáng sớm</option>
                                        <option value="12:00">12:00 PM - Trưa</option>
                                        <option value="15:00">3:00 PM - Chiều</option>
                                        <option value="18:00">6:00 PM - Tối</option>
                                        <option value="21:00">9:00 PM - Tối muộn</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Content Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Nội dung bài viết</label>
                            <textarea id="post-content" rows="6" class="w-full p-4 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-200 focus:border-primary-600 transition-all duration-200 resize-none" placeholder="Nhập nội dung bài viết..."></textarea>
                        </div>

                        <!-- Platform Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">Nền tảng đăng</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                <label class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 cursor-pointer transition-all duration-200">
                                    <input type="checkbox" class="platform-checkbox w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" data-platform="facebook" checked>
                                    <i class="fab fa-facebook text-blue-600 mr-2"></i>
                                    <span class="text-sm">Facebook</span>
                                </label>
                                <label class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 cursor-pointer transition-all duration-200">
                                    <input type="checkbox" class="platform-checkbox w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" data-platform="instagram">
                                    <i class="fab fa-instagram text-pink-600 mr-2"></i>
                                    <span class="text-sm">Instagram</span>
                                </label>
                                <label class="flex items-center p-3 bg-gray-50 border border-gray-200 rounded-xl hover:bg-gray-100 cursor-pointer transition-all duration-200">
                                    <input type="checkbox" class="platform-checkbox w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500 mr-3" data-platform="tiktok">
                                    <i class="fab fa-tiktok text-gray-800 mr-2"></i>
                                    <span class="text-sm">TikTok</span>
                                </label>
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
                document.getElementById('post-content').value = existingPost.content || '';
                document.getElementById('modal-time').textContent = existingPost.time || 'Chọn thời gian đăng';
                
                // Set platforms
                document.querySelectorAll('.platform-checkbox').forEach(checkbox => {
                    checkbox.checked = existingPost.platforms && existingPost.platforms.includes(checkbox.dataset.platform);
                });
            } else {
                document.getElementById('post-time').value = '09:00';
                document.getElementById('post-content').value = '';
                document.getElementById('modal-time').textContent = 'Chọn thời gian đăng';
                document.querySelectorAll('.platform-checkbox').forEach(checkbox => {
                    checkbox.checked = checkbox.dataset.platform === 'facebook';
                });
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
            const content = document.getElementById('post-content').value;
            const platforms = Array.from(document.querySelectorAll('.platform-checkbox:checked')).map(cb => cb.dataset.platform);

            if (!content.trim()) {
                alert('Vui lòng nhập nội dung bài viết!');
                return;
            }

            if (platforms.length === 0) {
                alert('Vui lòng chọn ít nhất một nền tảng để đăng!');
                return;
            }

            const postData = { 
                date: currentEditingPost.date,
                post_index: currentEditingPost.index,
                time, 
                content, 
                platforms 
            };

            // Simulate saving to server
            console.log('Saving post:', postData);
            
            const postKey = `${currentEditingPost.date}_${currentEditingPost.index}`;
            savedPosts[postKey] = postData;
            updatePostCard(currentEditingPost.date, currentEditingPost.index, postData);
            closeModal();
            
            // Show success message
            showNotification('Đã lưu bài viết thành công!', 'success');
        }

        function updatePostCard(date, index, postData) {
            // Find and update the post card UI
            const postCards = document.querySelectorAll('.post-card');
            postCards.forEach(card => {
                if (card.onclick.toString().includes(`'${date}', ${index}`)) {
                    // Update card appearance to show it has content
                    card.classList.remove('border-dashed', 'border-gray-300');
                    card.classList.add('border-green-300', 'bg-green-50');
                    
                    const icon = card.querySelector('.fa-plus');
                    if (icon) {
                        icon.classList.remove('fa-plus', 'text-gray-600');
                        icon.classList.add('fa-check', 'text-white');
                        icon.parentElement.classList.remove('bg-gray-300');
                        icon.parentElement.classList.add('bg-green-500');
                    }
                    
                    // Update content preview
                    const contentDiv = card.querySelector('.text-gray-500');
                    if (contentDiv) {
                        contentDiv.textContent = postData.content.length > 50 ? 
                            postData.content.substring(0, 50) + '...' : 
                            postData.content;
                        contentDiv.classList.remove('text-gray-500', 'italic');
                        contentDiv.classList.add('text-gray-800');
                    }

                    // Update time
                    const timeDiv = card.querySelector('.fas.fa-clock').parentElement;
                    if (timeDiv) {
                        timeDiv.innerHTML = `<i class="fas fa-clock mr-1"></i>${postData.time}`;
                    }
                }
            });

            updateStatistics();
        }

        function updateStatistics() {
            const totalPosts = Object.keys(savedPosts).length;
            const totalScheduledPosts = Object.values(savedPosts).filter(post => post.content.trim()).length;
            
            document.getElementById('total-posts').textContent = totalScheduledPosts;
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

        function launchCampaign() {
            const totalScheduledPosts = Object.values(savedPosts).filter(post => post.content.trim()).length;
            
            if (totalScheduledPosts === 0) {
                showNotification('Vui lòng thiết lập nội dung cho ít nhất một bài viết trước khi khởi chạy chiến dịch.', 'error');
                return;
            }
            
            if (confirm(`Bạn đã thiết lập nội dung cho ${totalScheduledPosts} bài viết. Bạn có chắc chắn muốn khởi chạy chiến dịch không?`)) {
                // Simulate launch
                console.log('Launching campaign with posts:', savedPosts);
                showNotification('Chiến dịch đã được khởi chạy thành công!', 'success');
                
                // Simulate redirect after 2 seconds
                setTimeout(() => {
                    showNotification('Đang chuyển hướng đến dashboard...', 'info');
                }, 2000);
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

        // Update time display when time input changes
        document.addEventListener('DOMContentLoaded', function() {
            const timeInput = document.getElementById('post-time');
            if (timeInput) {
                timeInput.addEventListener('change', function() {
                    document.getElementById('modal-time').textContent = this.value;
                });
            }
        });

        // Close modal when clicking outside
        document.getElementById('post-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('post-modal').classList.contains('hidden')) {
                closeModal();
            }
        });
    </script>
</x-app-dashboard>