<x-app-dashboard>
    <div class="min-h-screen bg-gradient-to-br from-slate-800 via-indigo-900 to-slate-800 px-8 py-8">
        <!-- Header -->
        <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-8 mb-6 border border-white/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-indigo-400 to-purple-400 p-3 rounded-xl">
                        <i class="fas fa-video text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Trình chỉnh sửa video chuyên nghiệp</h1>
                        <p class="text-indigo-200">Chỉnh sửa video chất lượng với đầy đủ công cụ chỉnh sửa</p>
                    </div>
                </div>

                <!-- Buttons right -->
                <div class="flex items-center gap-3">
                    <!-- Upload Video Button -->
                    <label for="upload" class="px-5 py-3 bg-gradient-to-r from-blue-400 to-blue-500 text-white rounded-xl hover:from-blue-500 hover:to-blue-600 shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2 cursor-pointer">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span>Tải lên Video</span>
                    </label>
                    <input id="upload" type="file" accept="video/*" class="hidden" />

                    <!-- Back Button -->
                    <a href="{{ route('dashboard.content_creator.index') }}"
                    class="px-5 py-3 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl hover:from-gray-500 hover:to-gray-600 shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Quay lại</span>
                    </a>

                    <!-- Save Video Button -->
                    <button id="downloadVideo"
                            class="px-6 py-3 bg-gradient-to-r from-emerald-400 to-teal-500 text-white rounded-xl hover:from-emerald-500 hover:to-teal-600 shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-download"></i>
                        <span>Tải về</span>
                    </button>
                </div>
            </div>

            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm text-indigo-200 mt-4">
                <a href="{{ route('dashboard.content_creator.index') }}" class="hover:text-white transition-colors duration-200">Khởi tạo nội dung</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-white font-medium">Công cụ chỉnh sửa video</span>
            </nav>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <!-- Left Sidebar - Tools -->
            <div class="col-span-12 lg:col-span-3">
                <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-6 border border-white/10">
                    <h3 class="text-white font-bold mb-6 flex items-center gap-2">
                        <i class="fas fa-tools"></i>
                        Công cụ chỉnh sửa
                    </h3>

                    <!-- Video List -->
                    <div class="mb-8">
                        <h4 class="text-indigo-200 text-sm font-bold mb-3">Video của bạn</h4>
                        <div id="videoList" class="space-y-2 max-h-64 overflow-y-auto">
                            <div class="text-indigo-300 text-sm">Chưa có video nào được tải lên</div>
                        </div>
                    </div>

                    <!-- Edit Options -->
                    <div class="space-y-3">
                        <!-- Trim -->
                        <button id="btnTrim" class="w-full px-4 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-cut"></i>
                            <span>Cắt/Trim</span>
                        </button>

                        <!-- Text Overlay -->
                        <button id="btnTextOverlay" class="w-full px-4 py-3 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="fas fa-font"></i>
                            <span>Thêm Văn Bản</span>
                        </button>

                        <!-- Filters -->
                        <div class="space-y-2">
                            <h5 class="text-indigo-200 text-sm font-bold">Bộ Lọc</h5>
                            <div class="grid grid-cols-2 gap-2">
                                <button id="btnGrayscale" class="px-3 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Xám
                                </button>
                                <button id="btnSepia" class="px-3 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Xưa
                                </button>
                                <button id="btnBlur" class="px-3 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Làm Mờ
                                </button>
                                <button id="btnSharpen" class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Làm Sắc
                                </button>
                                <button id="btnBrightness" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Độ Sáng
                                </button>
                                <button id="btnContrast" class="px-3 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Tương Phản
                                </button>
                            </div>
                        </div>

                        <!-- Transform -->
                        <div class="space-y-2">
                            <h5 class="text-indigo-200 text-sm font-bold">Biến Đổi</h5>
                            <div class="grid grid-cols-2 gap-2">
                                <button id="btnResize" class="px-3 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Thay Đổi Kích Thước
                                </button>
                                <button id="btnRotate" class="px-3 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Xoay
                                </button>
                                <button id="btnSpeed" class="px-3 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all text-xs disabled:opacity-50 disabled:cursor-not-allowed">
                                    Tốc Độ
                                </button>
                            </div>
                        </div>

                        <!-- Audio -->
                        <div class="space-y-2">
                            <h5 class="text-indigo-200 text-sm font-bold">Âm Thanh</h5>
                            <label for="audioUpload" class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed border-indigo-300 rounded-lg cursor-pointer hover:bg-white/5 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-music text-indigo-300 text-l mb-1"></i>
                                    <p class="text-xs text-indigo-200">Thêm Âm Thanh</p>
                                </div>
                                <input id="audioUpload" type="file" accept="audio/*" class="hidden" disabled />
                            </label>
                            <button id="btnExtractAudio" class="w-full px-4 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-all flex items-center justify-center text-sm disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-music"></i>
                                <span>Trích Xuất Âm Thanh</span>
                            </button>
                        </div>

                        <!-- History -->
                        <div class="mt-4">
                            <h5 class="text-indigo-200 text-sm font-bold mb-2">Lịch Sử Chỉnh Sửa</h5>
                            <div id="editHistory" class="space-y-1 max-h-32 overflow-y-auto text-xs">
                                <div class="text-indigo-300">Chưa có chỉnh sửa</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Center - Video Player and Controls -->
            <div class="col-span-12 lg:col-span-6">
                <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-6 border border-white/10">
                    <!-- Video Container -->
                    <div class="mb-4 bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl p-4 flex justify-center">
                        <video id="videoPlayer"
                               class="w-full max-w-2xl max-h-96 rounded-lg shadow-xl border-4 border-white/10"
                               controls
                               preload="metadata">
                            Trình duyệt của bạn không hỗ trợ video.
                        </video>
                    </div>

                    <!-- Video Controls -->
                    <div class="space-y-4">
                        <!-- Playback Controls -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <button id="btnPlayPause" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all">
                                    <i class="fas fa-play"></i>
                                </button>
                                <span id="currentTime" class="text-indigo-200 text-sm">00:00</span>
                                <span class="text-indigo-200 text-sm">/</span>
                                <span id="duration" class="text-indigo-200 text-sm">00:00</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="range" id="seekBar" min="0" max="100" value="0" class="w-64" />
                            </div>
                        </div>

                        <!-- Quality/Settings -->
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div class="bg-gray-700 rounded-lg p-3">
                                <div class="text-xs text-indigo-200">Độ phân giải</div>
                                <div id="resolution" class="text-white font-bold">Đang tải...</div>
                            </div>
                            <div class="bg-gray-700 rounded-lg p-3">
                                <div class="text-xs text-indigo-200">Codec</div>
                                <div id="codec" class="text-white font-bold">Đang tải...</div>
                            </div>
                            <div class="bg-gray-700 rounded-lg p-3">
                                <div class="text-xs text-indigo-200">Kích thước</div>
                                <div id="fileSize" class="text-white font-bold">Đang tải...</div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div id="statusMessage" class="text-center text-sm text-indigo-200 p-2 bg-blue-500/20 rounded-lg hidden">
                            Đang xử lý video...
                        </div>

                        <!-- Upload Progress -->
                        <div id="uploadProgress" class="hidden mt-2">
                            <div class="flex items-center justify-between mb-1">
                                <span id="progressText" class="text-xs text-indigo-200">0%</span>
                                <span id="progressSize" class="text-xs text-indigo-200">0MB / 0MB</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-2">
                                <div id="progressBar" class="bg-gradient-to-r from-blue-400 to-purple-400 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar - Properties -->
            <div class="col-span-12 lg:col-span-3">
                <!-- Edit Panels -->
                <div id="editPanel" class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-6 border border-white/10 hidden">

                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Trim Modal -->
    <div id="trimModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 max-w-md w-full mx-4 border border-white/10">
            <h3 class="text-white text-xl font-bold mb-4">Cắt Video</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-indigo-200 text-sm">Thời gian bắt đầu (giây)</label>
                    <input type="number" id="trimStart" min="0" step="0.1" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                </div>
                <div>
                    <label class="text-indigo-200 text-sm">Thời gian kết thúc (giây)</label>
                    <input type="number" id="trimEnd" min="0" step="0.1" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                </div>
                <div class="flex gap-2">
                    <button id="applyTrim" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all">
                        Áp dụng
                    </button>
                    <button id="cancelTrim" class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                        Hủy bỏ
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Text Overlay Modal -->
    <div id="textModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 max-w-md w-full mx-4 border border-white/10">
            <h3 class="text-white text-xl font-bold mb-4">Add Text Overlay</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-indigo-200 text-sm">Text</label>
                    <input type="text" id="textContent" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-indigo-200 text-sm">X Position</label>
                        <input type="number" id="textX" min="0" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                    </div>
                    <div>
                        <label class="text-indigo-200 text-sm">Y Position</label>
                        <input type="number" id="textY" min="0" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-indigo-200 text-sm">Font Size</label>
                        <input type="number" id="textFontSize" min="10" max="200" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                    </div>
                    <div>
                        <label class="text-indigo-200 text-sm">Font Color</label>
                        <input type="color" id="textColor" class="w-full h-10 bg-gray-600 rounded-lg" />
                    </div>
                </div>
                <div>
                    <label class="text-indigo-200 text-sm">Start Time (optional)</label>
                    <input type="number" id="textStartTime" min="0" step="0.1" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                </div>
                <div class="flex gap-2">
                    <button id="applyText" class="flex-1 px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-all">
                        Apply
                    </button>
                    <button id="cancelText" class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Resize Modal -->
    <div id="resizeModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 max-w-md w-full mx-4 border border-white/10">
            <h3 class="text-white text-xl font-bold mb-4">Resize Video</h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-indigo-200 text-sm">Width</label>
                        <input type="number" id="resizeWidth" min="1" max="7680" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                    </div>
                    <div>
                        <label class="text-indigo-200 text-sm">Height</label>
                        <input type="number" id="resizeHeight" min="1" max="4320" class="w-full px-3 py-2 bg-gray-600 text-white rounded-lg" />
                    </div>
                </div>
                <div class="flex gap-2">
                    <button id="applyResize" class="flex-1 px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-all">
                        Resize
                    </button>
                    <button id="cancelResize" class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Rotate Modal -->
    <div id="rotateModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 max-w-md w-full mx-4 border border-white/10">
            <h3 class="text-white text-xl font-bold mb-4">Rotate Video</h3>
            <div class="space-y-4">
                <div class="flex gap-4">
                    <button id="rotate90" class="flex-1 px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-all">
                        90°
                    </button>
                    <button id="rotate180" class="flex-1 px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all">
                        180°
                    </button>
                    <button id="rotate270" class="flex-1 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all">
                        270°
                    </button>
                </div>
                <button id="cancelRotate" class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Speed Modal -->
    <div id="speedModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 max-w-md w-full mx-4 border border-white/10">
            <h3 class="text-white text-xl font-bold mb-4">Adjust Video Speed</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-indigo-200 text-sm">Speed Multiplier</label>
                    <input type="range" id="speedValue" min="0.25" max="4" step="0.25" class="w-full" />
                    <span id="speedValueText" class="text-indigo-200 text-sm">1x</span>
                </div>
                <div class="flex gap-2">
                    <button id="applySpeed" class="flex-1 px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all">
                        Apply
                    </button>
                    <button id="cancelSpeed" class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Strength Modal -->
    <div id="filterModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-2xl p-6 max-w-md w-full mx-4 border border-white/10">
            <h3 id="filterModalTitle" class="text-white text-xl font-bold mb-4">Adjust Filter</h3>
            <div class="space-y-4">
                <div id="brightnessControl" class="hidden">
                    <label class="text-indigo-200 text-sm">Brightness</label>
                    <input type="range" id="brightnessValue" min="-1" max="1" step="0.1" class="w-full" />
                </div>
                <div id="contrastControl" class="hidden">
                    <label class="text-indigo-200 text-sm">Contrast</label>
                    <input type="range" id="contrastValue" min="-1" max="1" step="0.1" class="w-full" />
                </div>
                <div id="blurControl" class="hidden">
                    <label class="text-indigo-200 text-sm">Blur Intensity</label>
                    <input type="range" id="blurValue" min="0.1" max="2" step="0.1" class="w-full" />
                </div>
                <div id="sharpenControl" class="hidden">
                    <label class="text-indigo-200 text-sm">Sharpen Intensity</label>
                    <input type="range" id="sharpenValue" min="0.1" max="2" step="0.1" class="w-full" />
                </div>
                <div class="flex gap-2">
                    <button id="applyFilter" class="flex-1 px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-all">
                        Apply
                    </button>
                    <button id="cancelFilter" class="flex-1 px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables
        let currentVideoId = null;
        let videos = [];
        let currentFilter = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadVideos();
        });

        // Load user's videos
        function loadVideos() {
            fetch('/dashboard/content_creator/videos', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    videos = data.videos;
                    renderVideoList();
                }
            })
            .catch(error => {
                console.error('Error loading videos:', error);
            });
        }

        // Render video list
        function renderVideoList() {
            const videoList = document.getElementById('videoList');
            if (videos.length === 0) {
                videoList.innerHTML = '<div class="text-indigo-300 text-sm">No videos uploaded yet</div>';
                return;
            }

            videoList.innerHTML = videos.map(video => `
                <div class="bg-gray-700/50 p-2 rounded-lg hover:bg-gray-700 transition-all relative group">
                    <div class="flex items-center gap-2 cursor-pointer" onclick="selectVideo(${video.id})">
                        <div class="w-12 h-9 bg-gray-600 rounded overflow-hidden flex items-center justify-center">
                            ${video.thumbnail_path ? `<img src="${video.thumbnail_url}" class="w-full h-full object-cover" />` : '<i class="fas fa-video text-indigo-300"></i>'}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-white text-sm font-medium truncate">${video.title || 'Untitled'}</div>
                            <div class="text-indigo-300 text-xs">${video.formatted_duration}</div>
                        </div>
                        <div class="text-xs px-2 py-1 bg-${video.status === 'completed' ? 'green' : video.status === 'processing' ? 'yellow' : 'red'}-500/20 text-${video.status === 'completed' ? 'green' : video.status === 'processing' ? 'yellow' : 'red'}-300 rounded">
                            ${video.status}
                        </div>
                    </div>
                    <button class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 bg-red-600 hover:bg-red-700 text-white p-1 rounded text-xs transition-opacity"
                            onclick="deleteVideo(${video.id}, event)"
                            title="Delete video">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `).join('');
        }

        // Select a video
        function selectVideo(videoId) {
            const video = videos.find(v => v.id === videoId);
            if (!video) return;

            currentVideoId = videoId;
            const videoPlayer = document.getElementById('videoPlayer');
            videoPlayer.src = video.edited_url || video.original_url;
            videoPlayer.load();

            // Update info
            document.getElementById('resolution').textContent = `${video.width}x${video.height}`;
            document.getElementById('codec').textContent = video.codec || 'Unknown';
            document.getElementById('fileSize').textContent = video.formatted_file_size;

            // Update duration display
            videoPlayer.onloadedmetadata = function() {
                document.getElementById('duration').textContent = formatTime(videoPlayer.duration);
                updateSeekBar();
            };

            // Enable edit buttons
            document.querySelectorAll('.lg\\:col-span-3 button:not(#downloadVideo)').forEach(btn => {
                btn.disabled = false;
                btn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
            });

            document.getElementById('downloadVideo').disabled = true;
            document.getElementById('audioUpload').disabled = false;

            // Load edit history
            loadEditHistory(video);

            // Hide edit panel initially
            document.getElementById('editPanel').classList.add('hidden');
        }

        // Load edit history
        function loadEditHistory(video) {
            const historyContainer = document.getElementById('editHistory');
            if (!video.edit_history || video.edit_history.length === 0) {
                historyContainer.innerHTML = '<div class="text-indigo-300">No edits yet</div>';
                return;
            }

            historyContainer.innerHTML = video.edit_history.map(edit => `
                <div class="bg-gray-700/50 px-2 py-1 rounded text-xs text-indigo-200">
                    ${edit.action} - ${edit.timestamp}
                </div>
            `).join('');
        }

        // Video player controls
        const videoPlayer = document.getElementById('videoPlayer');
        const playPauseBtn = document.getElementById('btnPlayPause');

        playPauseBtn.addEventListener('click', async function() {
            try {
                if (videoPlayer.paused) {
                    await videoPlayer.play();
                    this.innerHTML = '<i class="fas fa-pause"></i>';
                } else {
                    videoPlayer.pause();
                    this.innerHTML = '<i class="fas fa-play"></i>';
                }
            } catch (error) {
                console.warn('Video play interrupted:', error);
                this.innerHTML = '<i class="fas fa-play"></i>';
            }
        });

        videoPlayer.addEventListener('play', function() {
            playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
        });

        videoPlayer.addEventListener('pause', function() {
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        });

        videoPlayer.addEventListener('ended', function() {
            playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
        });

        videoPlayer.addEventListener('timeupdate', function() {
            document.getElementById('currentTime').textContent = formatTime(this.currentTime);
            updateSeekBar();
        });

        function updateSeekBar() {
            const video = document.getElementById('videoPlayer');
            const seekBar = document.getElementById('seekBar');
            if (video.duration) {
                seekBar.value = (video.currentTime / video.duration) * 100;
            }
        }

        document.getElementById('seekBar').addEventListener('input', function() {
            const video = document.getElementById('videoPlayer');
            video.currentTime = (this.value / 100) * video.duration;
        });

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        // Upload video
        document.getElementById('upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('video', file);
            formData.append('title', file.name);

            // Show loading and progress
            document.getElementById('statusMessage').textContent = 'Uploading video...';
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            // Show progress bar
            const progressContainer = document.getElementById('uploadProgress');
            const progressBar = document.getElementById('progressBar');
            const progressText = document.getElementById('progressText');
            const progressSize = document.getElementById('progressSize');

            progressContainer.classList.remove('hidden');
            progressBar.style.width = '0%';
            progressText.textContent = '0%';
            progressSize.textContent = `0MB / ${(file.size / (1024 * 1024)).toFixed(2)}MB`;

            // Use XMLHttpRequest for upload progress
            const xhr = new XMLHttpRequest();

            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    const loadedMB = (e.loaded / (1024 * 1024)).toFixed(2);
                    const totalMB = (e.total / (1024 * 1024)).toFixed(2);

                    progressBar.style.width = percentComplete + '%';
                    progressText.textContent = Math.round(percentComplete) + '%';
                    progressSize.textContent = loadedMB + 'MB / ' + totalMB + 'MB';
                }
            });

            xhr.addEventListener('load', function() {
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        document.getElementById('statusMessage').textContent = 'Video uploaded successfully!';
                        document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                        document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');
                        videos.push(data.video);
                        renderVideoList();
                        selectVideo(data.video.id);
                        setTimeout(() => {
                            document.getElementById('statusMessage').classList.add('hidden');
                            progressContainer.classList.add('hidden');
                        }, 3000);
                    } else {
                        throw new Error(data.message || 'Upload failed');
                    }
                } else {
                    throw new Error('Upload failed');
                }
            });

            xhr.addEventListener('error', function() {
                console.error('Upload error:', xhr.responseText);
                document.getElementById('statusMessage').textContent = 'Upload failed';
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
                progressContainer.classList.add('hidden');
            });

            xhr.addEventListener('abort', function() {
                document.getElementById('statusMessage').textContent = 'Upload cancelled';
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-gray-500/20', 'text-gray-300');
                progressContainer.classList.add('hidden');
            });

            xhr.open('POST', '/dashboard/content_creator/videos');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.send(formData);
        });

        // Modal controls
        function showModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function hideModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Trim functionality
        document.getElementById('btnTrim').addEventListener('click', function() {
            showModal('trimModal');
        });

        document.getElementById('cancelTrim').addEventListener('click', function() {
            hideModal('trimModal');
        });

        document.getElementById('applyTrim').addEventListener('click', function() {
            const startTime = parseFloat(document.getElementById('trimStart').value);
            const endTime = parseFloat(document.getElementById('trimEnd').value);

            if (!startTime || !endTime || startTime >= endTime) {
                alert('Please enter valid start and end times');
                return;
            }

            // Show processing
            document.getElementById('statusMessage').textContent = 'Trimming video...';
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/trim`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    start_time: startTime,
                    end_time: endTime
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = 'Video trimmed successfully!';
                    document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    // Update video in list and reselect
                    const index = videos.findIndex(v => v.id === currentVideoId);
                    if (index !== -1) {
                        videos[index] = data.video;
                        loadEditHistory(data.video);
                        selectVideo(currentVideoId);
                    }

                    document.getElementById('downloadVideo').disabled = false;
                } else {
                    throw new Error(data.message || 'Trim failed');
                }
                hideModal('trimModal');
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Trim error:', error);
                document.getElementById('statusMessage').textContent = 'Trim failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
                hideModal('trimModal');
            });
        });

        // Text overlay functionality
        document.getElementById('btnTextOverlay').addEventListener('click', function() {
            showModal('textModal');
        });

        document.getElementById('cancelText').addEventListener('click', function() {
            hideModal('textModal');
        });

        document.getElementById('applyText').addEventListener('click', function() {
            const textData = {
                text: document.getElementById('textContent').value,
                x: parseInt(document.getElementById('textX').value) || 0,
                y: parseInt(document.getElementById('textY').value) || 0,
                font_size: parseInt(document.getElementById('textFontSize').value) || 24,
                font_color: document.getElementById('textColor').value,
                start_time: parseFloat(document.getElementById('textStartTime').value) || null,
                duration: null
            };

            if (!textData.text) {
                alert('Please enter text to add');
                return;
            }

            // Show processing
            document.getElementById('statusMessage').textContent = 'Adding text overlay...';
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/text`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(textData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = 'Text added successfully!';
                    document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    // Update video
                    const index = videos.findIndex(v => v.id === currentVideoId);
                    if (index !== -1) {
                        videos[index] = data.video;
                        loadEditHistory(data.video);
                        selectVideo(currentVideoId);
                    }

                    document.getElementById('downloadVideo').disabled = false;
                } else {
                    throw new Error(data.message || 'Add text failed');
                }
                hideModal('textModal');
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Add text error:', error);
                document.getElementById('statusMessage').textContent = 'Add text failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
                hideModal('textModal');
            });
        });

        // Filter functionality
        function setupFilterButton(buttonId, filterType) {
            document.getElementById(buttonId).addEventListener('click', function() {
                currentFilter = filterType;
                if (filterType === 'grayscale' || filterType === 'sepia') {
                    applyFilter(filterType, 1.0);
                } else {
                    showFilterModal(filterType);
                }
            });
        }

        setupFilterButton('btnGrayscale', 'grayscale');
        setupFilterButton('btnSepia', 'sepia');
        setupFilterButton('btnBlur', 'blur');
        setupFilterButton('btnSharpen', 'sharpen');
        setupFilterButton('btnBrightness', 'brightness');
        setupFilterButton('btnContrast', 'contrast');

        function showFilterModal(filterType) {
            document.getElementById('filterModalTitle').textContent = `Adjust ${filterType.charAt(0).toUpperCase() + filterType.slice(1)}`;

            // Hide all controls
            ['brightnessControl', 'contrastControl', 'blurControl', 'sharpenControl'].forEach(id => {
                document.getElementById(id).classList.add('hidden');
            });

            // Show relevant control
            const controlMap = {
                'brightness': 'brightnessControl',
                'contrast': 'contrastControl',
                'blur': 'blurControl',
                'sharpen': 'sharpenControl'
            };

            document.getElementById(controlMap[filterType]).classList.remove('hidden');
            showModal('filterModal');
        }

        function applyFilter(filterType, intensity) {
            document.getElementById('statusMessage').textContent = `Applying ${filterType} filter...`;
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/filter`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    filter: filterType,
                    intensity: intensity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = `Filter applied successfully!`;
                    document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    const index = videos.findIndex(v => v.id === currentVideoId);
                    if (index !== -1) {
                        videos[index] = data.video;
                        loadEditHistory(data.video);
                        selectVideo(currentVideoId);
                    }

                    document.getElementById('downloadVideo').disabled = false;
                    document.getElementById('btnBlur').disabled = false;
                } else {
                    throw new Error(data.message || 'Filter failed');
                }
                hideModal('filterModal');
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Filter error:', error);
                document.getElementById('statusMessage').textContent = 'Filter failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
                hideModal('filterModal');
            });
        }

        document.getElementById('applyFilter').addEventListener('click', function() {
            let intensity = 1.0;
            if (currentFilter === 'brightness') {
                intensity = parseFloat(document.getElementById('brightnessValue').value);
            } else if (currentFilter === 'contrast') {
                intensity = parseFloat(document.getElementById('contrastValue').value);
            } else if (currentFilter === 'blur') {
                intensity = parseFloat(document.getElementById('blurValue').value);
            } else if (currentFilter === 'sharpen') {
                intensity = parseFloat(document.getElementById('sharpenValue').value);
            }
            applyFilter(currentFilter, intensity);
        });

        document.getElementById('cancelFilter').addEventListener('click', function() {
            hideModal('filterModal');
        });

        // Resize functionality
        document.getElementById('btnResize').addEventListener('click', function() {
            const video = videos.find(v => v.id === currentVideoId);
            if (video) {
                document.getElementById('resizeWidth').value = video.width;
                document.getElementById('resizeHeight').value = video.height;
            }
            showModal('resizeModal');
        });

        document.getElementById('cancelResize').addEventListener('click', function() {
            hideModal('resizeModal');
        });

        document.getElementById('applyResize').addEventListener('click', function() {
            const width = parseInt(document.getElementById('resizeWidth').value);
            const height = parseInt(document.getElementById('resizeHeight').value);

            if (!width || !height) {
                alert('Please enter valid dimensions');
                return;
            }

            document.getElementById('statusMessage').textContent = 'Resizing video...';
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/resize`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    width: width,
                    height: height
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = 'Video resized successfully!';
                    document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    const index = videos.findIndex(v => v.id === currentVideoId);
                    if (index !== -1) {
                        videos[index] = data.video;
                        loadEditHistory(data.video);
                        selectVideo(currentVideoId);
                    }

                    document.getElementById('downloadVideo').disabled = false;
                } else {
                    throw new Error(data.message || 'Resize failed');
                }
                hideModal('resizeModal');
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Resize error:', error);
                document.getElementById('statusMessage').textContent = 'Resize failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
                hideModal('resizeModal');
            });
        });

        // Rotate functionality
        document.getElementById('btnRotate').addEventListener('click', function() {
            showModal('rotateModal');
        });

        ['rotate90', 'rotate180', 'rotate270'].forEach(id => {
            document.getElementById(id).addEventListener('click', function() {
                const angle = parseInt(this.id.replace('rotate', ''));
                applyRotation(angle);
                hideModal('rotateModal');
            });
        });

        document.getElementById('cancelRotate').addEventListener('click', function() {
            hideModal('rotateModal');
        });

        function applyRotation(angle) {
            document.getElementById('statusMessage').textContent = `Rotating video ${angle}°...`;
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/rotate`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    angle: angle
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = 'Video rotated successfully!';
                    document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    const index = videos.findIndex(v => v.id === currentVideoId);
                    if (index !== -1) {
                        videos[index] = data.video;
                        loadEditHistory(data.video);
                        selectVideo(currentVideoId);
                    }

                    document.getElementById('downloadVideo').disabled = false;
                } else {
                    throw new Error(data.message || 'Rotate failed');
                }
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Rotate error:', error);
                document.getElementById('statusMessage').textContent = 'Rotate failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
            });
        }

        // Speed functionality
        document.getElementById('btnSpeed').addEventListener('click', function() {
            document.getElementById('speedValue').value = '1';
            document.getElementById('speedValueText').textContent = '1x';
            showModal('speedModal');
        });

        document.getElementById('speedValue').addEventListener('input', function() {
            document.getElementById('speedValueText').textContent = this.value + 'x';
        });

        document.getElementById('cancelSpeed').addEventListener('click', function() {
            hideModal('speedModal');
        });

        document.getElementById('applySpeed').addEventListener('click', function() {
            const speed = parseFloat(document.getElementById('speedValue').value);

            document.getElementById('statusMessage').textContent = `Adjusting video speed to ${speed}x...`;
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/speed`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    speed: speed
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = 'Video speed adjusted successfully!';
                    document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    const index = videos.findIndex(v => v.id === currentVideoId);
                    if (index !== -1) {
                        videos[index] = data.video;
                        loadEditHistory(data.video);
                        selectVideo(currentVideoId);
                    }

                    document.getElementById('downloadVideo').disabled = false;
                } else {
                    throw new Error(data.message || 'Speed adjust failed');
                }
                hideModal('speedModal');
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Speed error:', error);
                document.getElementById('statusMessage').textContent = 'Speed adjust failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
                hideModal('speedModal');
            });
        });

        // Audio functionality
        document.getElementById('audioUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('audio', file);
            formData.append('volume', 1);

            document.getElementById('statusMessage').textContent = 'Adding audio to video...';
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/audio`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = 'Audio added successfully!';
                    document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    const index = videos.findIndex(v => v.id === currentVideoId);
                    if (index !== -1) {
                        videos[index] = data.video;
                        loadEditHistory(data.video);
                        selectVideo(currentVideoId);
                    }

                    document.getElementById('downloadVideo').disabled = false;
                } else {
                    throw new Error(data.message || 'Audio add failed');
                }
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Audio error:', error);
                document.getElementById('statusMessage').textContent = 'Audio add failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
            });
        });

        // Extract audio functionality
        document.getElementById('btnExtractAudio').addEventListener('click', function() {
            document.getElementById('statusMessage').textContent = 'Extracting audio...';
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-blue-500/20', 'text-blue-300');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/extract-audio`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = 'Audio extracted successfully!';
                    document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    // Trigger download
                    const link = document.createElement('a');
                    link.href = data.audio_url;
                    link.download = 'extracted_audio.mp3';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                } else {
                    throw new Error(data.message || 'Extract audio failed');
                }
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Extract audio error:', error);
                document.getElementById('statusMessage').textContent = 'Extract audio failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-blue-500/20', 'text-blue-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
            });
        });

        // Delete video functionality
        function deleteVideo(videoId, event) {
            event.stopPropagation(); // Prevent triggering selectVideo

            if (!confirm('Bạn có chắc chắn muốn xóa video này? Thao tác này không thể hoàn tác.')) {
                return;
            }

            document.getElementById('statusMessage').textContent = 'Deleting video...';
            document.getElementById('statusMessage').classList.remove('hidden');
            document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');

            fetch(`/dashboard/content_creator/videos/${videoId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('statusMessage').textContent = 'Video deleted successfully!';
                    document.getElementById('statusMessage').classList.remove('bg-red-500/20', 'text-red-300');
                    document.getElementById('statusMessage').classList.add('bg-green-500/20', 'text-green-300');

                    // Remove from videos array
                    videos = videos.filter(v => v.id !== videoId);

                    // Clear current video if it was deleted
                    if (currentVideoId === videoId) {
                        currentVideoId = null;
                        document.getElementById('videoPlayer').src = '';
                        document.getElementById('resolution').textContent = 'Loading...';
                        document.getElementById('codec').textContent = 'Loading...';
                        document.getElementById('fileSize').textContent = 'Loading...';
                        document.getElementById('downloadVideo').disabled = true;
                    }

                    renderVideoList();
                    loadEditHistory({ edit_history: [] });
                } else {
                    throw new Error(data.message || 'Delete failed');
                }
                setTimeout(() => {
                    document.getElementById('statusMessage').classList.add('hidden');
                }, 3000);
            })
            .catch(error => {
                console.error('Delete error:', error);
                document.getElementById('statusMessage').textContent = 'Delete failed: ' + error.message;
                document.getElementById('statusMessage').classList.remove('bg-red-500/20', 'text-red-300');
                document.getElementById('statusMessage').classList.add('bg-red-500/20', 'text-red-300');
            });
        }

        // Download video functionality
        document.getElementById('downloadVideo').addEventListener('click', function() {
            window.open(`/dashboard/content_creator/videos/${currentVideoId}/download`, '_blank');
        });
    </script>
</x-app-dashboard>
