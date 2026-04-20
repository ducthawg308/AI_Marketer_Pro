<x-app-dashboard>
    <div class="min-h-screen bg-gray-50 flex flex-col font-sans">
        <!-- HEADER -->
        <div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] z-10">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-50 p-3 rounded-lg flex items-center justify-center">
                    <i class="fas fa-video text-indigo-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-semibold text-gray-800 tracking-tight">Trình chỉnh sửa Video</h1>
                    <nav class="flex items-center space-x-2 text-xs text-gray-500 mt-0.5">
                        <a href="{{ route('dashboard.content_creator.index') }}" class="hover:text-indigo-600 font-medium transition-colors">Khởi tạo Content</a>
                        <i class="fas fa-chevron-right text-[10px]"></i>
                        <span class="text-indigo-600 font-semibold">Công cụ</span>
                    </nav>
                </div>
            </div>

            <!-- Nút hành động -->
            <div class="flex items-center gap-3">
                <label for="upload" class="px-4 py-2 bg-indigo-50 text-indigo-600 border border-indigo-100 rounded-lg hover:bg-indigo-100 transition-all cursor-pointer font-medium text-sm flex items-center gap-2">
                    <i class="fas fa-cloud-upload-alt"></i> Tải lên Video
                </label>
                <input id="upload" type="file" accept="video/*" class="hidden" />

                <a href="{{ route('dashboard.content_creator.index') }}" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition-all font-medium text-sm flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Thoát
                </a>

                <button id="downloadVideo" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 shadow-sm transition-all font-medium text-sm flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-download"></i> Xuất Video
                </button>
            </div>
        </div>

        <!-- MAIN WORKSPACE -->
        <div class="flex-1 flex overflow-hidden">
            
            <!-- LEFT PANEL: Assets & History -->
            <div class="w-72 bg-white border-r border-gray-200 flex flex-col z-0 shadow-[2px_0_10px_-3px_rgba(0,0,0,0.02)]">
                <!-- Video List -->
                <div class="flex-1 overflow-y-auto p-4 border-b border-gray-100">
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3"><i class="fas fa-film mr-1"></i> Media của bạn</h4>
                    <div id="videoList" class="space-y-2">
                        <div class="text-gray-400 text-sm italic text-center py-4 bg-gray-50 rounded-lg border border-dashed border-gray-200">Chưa có video</div>
                    </div>
                </div>

                <!-- History -->
                <div class="h-1/3 overflow-y-auto p-4 bg-gray-50/50">
                    <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3"><i class="fas fa-history mr-1"></i> Lịch sử thao tác</h4>
                    <div id="editHistory" class="space-y-1 text-xs">
                        <div class="text-gray-400 italic">Trống</div>
                    </div>
                </div>
            </div>

            <!-- CENTER STAGE: Player & Timeline -->
            <div class="flex-1 flex flex-col bg-gray-100 relative">
                
                <!-- Status Toast Notification -->
                <div id="statusMessage" class="absolute top-4 left-1/2 transform -translate-x-1/2 z-50 px-4 py-2 rounded-lg shadow-lg text-sm font-medium transition-all duration-300 hidden">
                    Đang xử lý...
                </div>

                <!-- Upload Progress -->
                <div id="uploadProgress" class="absolute top-4 left-1/2 transform -translate-x-1/2 z-50 w-96 bg-white p-3 rounded-xl shadow-lg border border-gray-100 hidden">
                    <div class="flex items-center justify-between mb-2">
                        <span id="progressText" class="text-xs font-semibold text-indigo-600">0%</span>
                        <span id="progressSize" class="text-xs text-gray-500">0MB / 0MB</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-1.5">
                        <div id="progressBar" class="bg-indigo-600 h-1.5 rounded-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                </div>

                <!-- Video Player Area -->
                <div class="flex-1 p-6 flex flex-col justify-center items-center relative">
                    <div class="w-full max-w-5xl aspect-video bg-black rounded-xl shadow-2xl overflow-hidden relative border border-gray-200 flex items-center justify-center">
                        <video id="videoPlayer" class="w-full h-full object-contain" controls preload="metadata">
                            Trình duyệt của bạn không hỗ trợ video.
                        </video>
                        <div id="videoPlaceholder" class="absolute inset-0 flex flex-col items-center justify-center text-gray-500">
                            <i class="fas fa-play-circle text-6xl mb-4 opacity-50"></i>
                            <p>Chọn một video từ danh sách bên trái</p>
                        </div>
                    </div>
                </div>

                <!-- Player Controls & Timeline Simulation -->
                <div class="h-44 bg-white border-t border-gray-200 px-6 py-4 flex flex-col shadow-[0_-2px_10px_-3px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <button id="btnPlayPause" class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-full hover:bg-indigo-100 transition-all flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-play"></i>
                            </button>
                            <div class="text-sm font-medium text-gray-600 font-mono">
                                <span id="currentTime">00:00</span> <span class="text-gray-300 mx-1">/</span> <span id="duration">00:00</span>
                            </div>
                        </div>
                        
                        <!-- Video Info Minified -->
                        <div class="flex gap-4 text-xs font-medium text-gray-500 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                            <div class="flex gap-1.5 items-center"><i class="fas fa-compress"></i> <span id="resolution">-- x --</span></div>
                            <div class="w-px h-3 bg-gray-300"></div>
                            <div class="flex gap-1.5 items-center"><i class="fas fa-file-video"></i> <span id="codec">MP4</span></div>
                            <div class="w-px h-3 bg-gray-300"></div>
                            <div class="flex gap-1.5 items-center"><i class="fas fa-hdd"></i> <span id="fileSize">-- MB</span></div>
                        </div>
                    </div>
                    
                    <div class="relative w-full h-8 flex items-center group">
                        <input type="range" id="seekBar" min="0" max="100" value="0" class="absolute w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer z-10 opacity-0 group-hover:opacity-100 transition-opacity" />
                        <!-- Timeline visual Mockup -->
                        <div class="absolute w-full h-full bg-indigo-50 rounded border border-indigo-100 overflow-hidden flex">
                            <div id="timelineProgress" class="h-full bg-indigo-200/50" style="width: 0%"></div>
                            <div class="flex-1 border-l border-indigo-200/30 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMTAwJSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZTBlN2ZmIi8+PC9zdmc+')]"></div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT PANEL: Inspector Panel -->
            <div class="w-80 bg-white border-l border-gray-200 flex flex-col shadow-[-2px_0_10px_-3px_rgba(0,0,0,0.02)] z-0">
                <div class="p-4 border-b border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-sliders-h text-indigo-600"></i> Bảng Thuộc tính
                    </h3>
                </div>

                <!-- Scrollable panels -->
                <div class="flex-1 overflow-y-auto p-2" id="inspectorPanels">
                    
                    <!-- Tool Menu -->
                    <div class="grid grid-cols-3 gap-2 mb-4 p-2">
                        <button class="tool-btn active flex flex-col items-center justify-center p-2 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100 hover:bg-indigo-100 transition-all text-xs font-medium" data-target="panelTrim" id="btnTrim">
                            <i class="fas fa-cut text-lg mb-1"></i> Cắt
                        </button>
                        <button class="tool-btn flex flex-col items-center justify-center p-2 rounded-lg bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100 hover:text-gray-800 transition-all text-xs font-medium" data-target="panelText" id="btnTextOverlay">
                            <i class="fas fa-font text-lg mb-1"></i> Chữ
                        </button>
                        <button class="tool-btn flex flex-col items-center justify-center p-2 rounded-lg bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100 hover:text-gray-800 transition-all text-xs font-medium" data-target="panelFilter">
                            <i class="fas fa-magic text-lg mb-1"></i> Bộ lọc
                        </button>
                        <button class="tool-btn flex flex-col items-center justify-center p-2 rounded-lg bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100 hover:text-gray-800 transition-all text-xs font-medium" data-target="panelTransform">
                            <i class="fas fa-crop-alt text-lg mb-1"></i> Cỡ & Xoay
                        </button>
                        <button class="tool-btn flex flex-col items-center justify-center p-2 rounded-lg bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100 hover:text-gray-800 transition-all text-xs font-medium" data-target="panelSpeed" id="btnSpeed">
                            <i class="fas fa-tachometer-alt text-lg mb-1"></i> Tốc độ
                        </button>
                        <button class="tool-btn flex flex-col items-center justify-center p-2 rounded-lg bg-gray-50 text-gray-600 border border-transparent hover:bg-gray-100 hover:text-gray-800 transition-all text-xs font-medium" data-target="panelAudio">
                            <i class="fas fa-music text-lg mb-1"></i> Âm Thanh
                        </button>
                    </div>

                    <hr class="border-gray-100 mx-2 mb-4">

                    <!-- Panel: Trim (Cắt Video) -->
                    <div id="panelTrim" class="inspector-section p-2 space-y-4">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">CẮT ĐOẠN (TRIM)</label>
                        <div>
                            <label class="text-gray-500 text-xs">Từ (giây)</label>
                            <input type="number" id="trimStart" min="0" step="0.1" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" placeholder="0.0" />
                        </div>
                        <div>
                            <label class="text-gray-500 text-xs">Phút cuối (giây)</label>
                            <input type="number" id="trimEnd" min="0" step="0.1" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 text-gray-800 rounded-lg text-sm focus:ring-2 focus:ring-indigo-100 focus:border-indigo-400 transition-all" />
                        </div>
                        <button id="applyTrim" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-all text-sm font-medium shadow-sm">
                            Cắt Video Này
                        </button>
                    </div>

                    <!-- Panel: Text (Chữ) -->
                    <div id="panelText" class="inspector-section p-2 space-y-4 hidden">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">THÊM VĂN BẢN</label>
                        <div>
                            <label class="text-gray-500 text-xs">Nội dung</label>
                            <input type="text" id="textContent" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" placeholder="Nhập chữ..." />
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-gray-500 text-xs">Vị trí X</label>
                                <input type="number" id="textX" min="0" value="10" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" />
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs">Vị trí Y</label>
                                <input type="number" id="textY" min="0" value="10" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-gray-500 text-xs">Cỡ chữ</label>
                                <input type="number" id="textFontSize" min="10" max="200" value="32" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" />
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs">Màu</label>
                                <input type="color" id="textColor" value="#ffffff" class="w-full h-[38px] p-0.5 bg-gray-50 border border-gray-200 rounded-lg cursor-pointer" />
                            </div>
                        </div>
                        <div>
                            <label class="text-gray-500 text-xs">Bắt đầu từ (giây - tùy chọn)</label>
                            <input type="number" id="textStartTime" min="0" step="0.1" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm" placeholder="Để trống để hiện cả video" />
                        </div>
                        <button id="applyText" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-all text-sm font-medium shadow-sm">
                            Đóng dấu chữ
                        </button>
                    </div>

                    <!-- Panel: Filter -->
                    <div id="panelFilter" class="inspector-section p-2 space-y-4 hidden">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">BỘ LỌC CĂN BẢN</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button id="btnGrayscale" class="px-3 py-2 bg-gray-100 text-gray-700 hover:bg-gray-200 border border-gray-200 rounded-lg transition-all text-xs font-medium text-left">Đen trắng</button>
                            <button id="btnSepia" class="px-3 py-2 bg-[#f4ebd8] text-[#5e4b3c] hover:bg-[#e6dac3] border border-[#eaddca] rounded-lg transition-all text-xs font-medium text-left">Nâu giả cổ</button>
                        </div>
                        
                        <div class="space-y-4 mt-6">
                            <label class="block text-xs font-semibold text-gray-600 mb-1">TÙY CHỈNH NÂNG CAO</label>
                            <div>
                                <label class="text-gray-500 text-xs flex justify-between">Độ sáng <span id="brightVal">0</span></label>
                                <input type="range" id="brightnessValue" min="-1" max="1" step="0.1" value="0" class="w-full accent-indigo-600" oninput="document.getElementById('brightVal').innerText=this.value" />
                                <button id="applyBrightness" class="mt-1 px-3 py-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded text-xs w-full">Áp dụng Sáng</button>
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs flex justify-between">Tương phản <span id="contrastVal">0</span></label>
                                <input type="range" id="contrastValue" min="-1" max="1" step="0.1" value="0" class="w-full accent-indigo-600" oninput="document.getElementById('contrastVal').innerText=this.value" />
                                <button id="applyContrast" class="mt-1 px-3 py-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded text-xs w-full">Áp dụng Tương phản</button>
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs flex justify-between">Làm mờ <span id="blurVal">0</span></label>
                                <input type="range" id="blurValue" min="0.1" max="2" step="0.1" value="0.1" class="w-full accent-indigo-600" oninput="document.getElementById('blurVal').innerText=this.value" />
                                <button id="applyBlur" class="mt-1 px-3 py-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded text-xs w-full">Thêm hiệu ứng Mờ</button>
                            </div>
                            <div>
                                <label class="text-gray-500 text-xs flex justify-between">Làm nét <span id="sharpenVal">0</span></label>
                                <input type="range" id="sharpenValue" min="0.1" max="2" step="0.1" value="0.5" class="w-full accent-indigo-600" oninput="document.getElementById('sharpenVal').innerText=this.value" />
                                <button id="applySharpen" class="mt-1 px-3 py-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded text-xs w-full">Làm nét sắc sảo</button>
                            </div>
                        </div>
                    </div>

                    <!-- Panel: Resize & Rotate -->
                    <div id="panelTransform" class="inspector-section p-2 space-y-4 hidden">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">BIẾN ĐỔI HÌNH DÁNG</label>
                        
                        <div class="bg-gray-50 border border-gray-200 p-3 rounded-xl mb-4">
                            <h5 class="text-xs font-semibold text-gray-600 mb-2">Đổi kích thước (Resize)</h5>
                            <div class="grid grid-cols-2 gap-2 mb-2">
                                <div>
                                    <label class="text-gray-400 text-xs">Rộng (px)</label>
                                    <input type="number" id="resizeWidth" min="1" max="7680" class="w-full px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm" />
                                </div>
                                <div>
                                    <label class="text-gray-400 text-xs">Cao (px)</label>
                                    <input type="number" id="resizeHeight" min="1" max="4320" class="w-full px-3 py-1.5 bg-white border border-gray-200 rounded-lg text-sm" />
                                </div>
                            </div>
                            <button id="applyResize" class="w-full px-3 py-1.5 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-all text-xs font-medium">Resize Video</button>
                        </div>

                        <div class="bg-gray-50 border border-gray-200 p-3 rounded-xl">
                            <h5 class="text-xs font-semibold text-gray-600 mb-2">Xoay (Rotate)</h5>
                            <div class="grid grid-cols-3 gap-2">
                                <button id="rotate90" class="px-2 py-1.5 bg-white border border-gray-200 hover:bg-gray-100 rounded-lg text-xs font-medium flex items-center justify-center gap-1"><i class="fas fa-undo transform rotate-180"></i> 90°</button>
                                <button id="rotate180" class="px-2 py-1.5 bg-white border border-gray-200 hover:bg-gray-100 rounded-lg text-xs font-medium flex items-center justify-center gap-1"><i class="fas fa-sync"></i> 180°</button>
                                <button id="rotate270" class="px-2 py-1.5 bg-white border border-gray-200 hover:bg-gray-100 rounded-lg text-xs font-medium flex items-center justify-center gap-1"><i class="fas fa-undo"></i> 270°</button>
                            </div>
                        </div>
                    </div>

                    <!-- Panel: Speed -->
                    <div id="panelSpeed" class="inspector-section p-2 space-y-4 hidden">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">TỐC ĐỘ PHÁT</label>
                        <div class="py-4">
                            <div class="flex justify-between items-center mb-2">
                                <label class="text-gray-500 text-xs">Hệ số nhân (Speed Multiplier)</label>
                                <span id="speedValueText" class="font-semibold text-indigo-600 bg-indigo-50 px-2 rounded">1x</span>
                            </div>
                            <input type="range" id="speedValue" min="0.25" max="4" step="0.25" value="1" class="w-full accent-indigo-600 mb-4" />
                            <div class="flex justify-between text-[10px] text-gray-400 mb-4">
                                <span>Chậm 0.25x</span>
                                <span>Thường 1x</span>
                                <span>Nhanh 4x</span>
                            </div>
                            <button id="applySpeed" class="w-full px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-all text-sm font-medium shadow-sm">
                                Áp dụng tốc độ
                            </button>
                        </div>
                    </div>

                    <!-- Panel: Audio -->
                    <div id="panelAudio" class="inspector-section p-2 space-y-4 hidden">
                        <label class="block text-xs font-semibold text-gray-600 mb-1">XỬ LÝ ÂM THANH</label>
                        
                        <div class="bg-gray-50 border border-gray-200 p-4 rounded-xl mb-4 text-center">
                            <label for="audioUpload" class="cursor-pointer block">
                                <i class="fas fa-file-audio text-3xl text-indigo-300 mb-2"></i>
                                <div class="text-sm font-medium text-gray-600">Thêm nhạc nền</div>
                                <div class="text-[10px] text-gray-400 mt-1">Ghi đè file MP3 / WAV</div>
                            </label>
                            <input id="audioUpload" type="file" accept="audio/*" class="hidden" disabled />
                        </div>

                        <div class="bg-amber-50 border border-amber-100 p-4 rounded-xl text-center">
                            <i class="fas fa-headphones text-3xl text-amber-500/50 mb-2"></i>
                            <div class="text-sm font-medium text-amber-800 mb-2">Tách âm thanh ra Tệp riêng</div>
                            <button id="btnExtractAudio" class="w-full px-3 py-1.5 bg-amber-500 text-white hover:bg-amber-600 rounded-lg text-xs font-medium shadow-sm transition-all shadow-amber-500/20 disabled:opacity-50">
                                <i class="fas fa-download mr-1"></i> Trích xuất MP3
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            
        </div>
    </div>

    <!-- SCRIPT TƯƠNG THÍCH LOGIC CŨ -->
    <script>
        // Global variables
        let currentVideoId = null;
        let videos = [];
        let currentFilter = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Logic UI Panels
        document.querySelectorAll('.tool-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Reset all
                document.querySelectorAll('.tool-btn').forEach(b => {
                    b.classList.remove('bg-indigo-50', 'text-indigo-600', 'border-indigo-100');
                    b.classList.add('bg-gray-50', 'text-gray-600', 'border-transparent');
                });
                document.querySelectorAll('.inspector-section').forEach(s => s.classList.add('hidden'));

                // Active clicked
                this.classList.remove('bg-gray-50', 'text-gray-600', 'border-transparent');
                this.classList.add('bg-indigo-50', 'text-indigo-600', 'border-indigo-100');
                
                const target = this.getAttribute('data-target');
                document.getElementById(target).classList.remove('hidden');

                // Điền thông số nếu tab Transform được mở
                if (target === 'panelTransform' && currentVideoId) {
                    const video = videos.find(v => v.id === currentVideoId);
                    if (video) {
                        document.getElementById('resizeWidth').value = video.width;
                        document.getElementById('resizeHeight').value = video.height;
                    }
                }
            });
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            loadVideos();
            disableAllTools();
        });

        function disableAllTools() {
            document.querySelectorAll('.tool-btn input, .tool-btn button, .inspector-section input, .inspector-section button').forEach(el => {
                if(el.id !== 'upload' && el.id !== 'audioUpload') el.disabled = true;
            });
            document.getElementById('audioUpload').disabled = true;
        }

        function enableAllTools() {
            document.querySelectorAll('.tool-btn input, .tool-btn button, .inspector-section input, .inspector-section button').forEach(el => {
                el.disabled = false;
            });
        }

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
            .catch(error => console.error('Error loading videos:', error));
        }

        // Render video list
        function renderVideoList() {
            const videoList = document.getElementById('videoList');
            if (videos.length === 0) {
                videoList.innerHTML = '<div class="text-gray-400 text-sm italic text-center py-4 bg-gray-50 rounded-lg border border-dashed border-gray-200">Chưa có video nào</div>';
                return;
            }

            videoList.innerHTML = videos.map(video => {
                let statusBg = 'gray', statusText = 'gray', statusLabel = video.status;
                if (video.status === 'completed') { statusBg = 'green'; statusText = 'green'; statusLabel = 'Đã sửa'; }
                else if (video.status === 'processing') { statusBg = 'amber'; statusText = 'amber'; statusLabel = 'Đang ghép'; }
                else if (video.status === 'uploaded') { statusBg = 'blue'; statusText = 'blue'; statusLabel = 'Đã tải lên'; }
                else if (video.status === 'failed') { statusBg = 'red'; statusText = 'red'; statusLabel = 'Lỗi'; }

                return `
                <div class="group bg-white border border-gray-100 p-2 rounded-xl shadow-sm hover:border-indigo-300 hover:shadow-md transition-all cursor-pointer relative overflow-hidden flex items-center gap-3 ${currentVideoId === video.id ? 'ring-2 ring-indigo-500' : ''}" onclick="selectVideo(${video.id})">
                    <div class="w-16 h-10 bg-gray-900 rounded overflow-hidden flex-shrink-0 flex items-center justify-center shadow-inner relative">
                        ${video.thumbnail_path ? `<img src="${video.thumbnail_url}" class="w-full h-full object-cover" />` : '<i class="fas fa-film text-gray-500 border"></i>'}
                    </div>
                    <div class="flex-1 min-w-0 pr-6">
                        <div class="text-gray-800 text-xs font-semibold truncate">${video.title || 'Untitled'}</div>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-gray-400 text-[10px]"><i class="far fa-clock"></i> ${video.formatted_duration || '00:00'}</span>
                            <span class="text-[10px] px-1.5 py-0.5 rounded-sm font-medium bg-${statusBg}-100 text-${statusText}-600">
                                ${statusLabel}
                            </span>
                        </div>
                    </div>
                    <button class="absolute top-1/2 right-2 transform -translate-y-1/2 opacity-0 group-hover:opacity-100 bg-red-100 hover:bg-red-500 text-red-600 hover:text-white w-6 h-6 rounded flex items-center justify-center text-xs transition-all z-10"
                            onclick="deleteVideo(${video.id}, event)" title="Xoá video">
                        <i class="fas fa-trash"></i>
                    </button>
                    ${currentVideoId === video.id ? '<div class="absolute left-0 top-0 bottom-0 w-1 bg-indigo-500"></div>' : ''}
                </div>
            `}).join('');
        }

        // Select a video
        function selectVideo(videoId) {
            const video = videos.find(v => v.id === videoId);
            if (!video) return;

            currentVideoId = videoId;
            renderVideoList(); // Re-render to show active state
            
            const videoPlayer = document.getElementById('videoPlayer');
            const placeholder = document.getElementById('videoPlaceholder');
            
            if (!videoPlayer) return;

            placeholder.classList.add('hidden');
            videoPlayer.classList.remove('hidden');

            const videoUrl = video.edited_url || video.original_url;
            videoPlayer.src = videoUrl;
            videoPlayer.load();

            // Update info
            document.getElementById('resolution').textContent = `${video.width}x${video.height}`;
            document.getElementById('codec').textContent = video.codec || 'Unknown';
            document.getElementById('fileSize').textContent = video.formatted_file_size;

            // Update duration
            videoPlayer.onloadedmetadata = function() {
                document.getElementById('duration').textContent = formatTime(videoPlayer.duration);
                updateSeekBar();
            };

            enableAllTools();
            document.getElementById('downloadVideo').disabled = false;
            document.getElementById('audioUpload').disabled = false;
            document.getElementById('btnPlayPause').disabled = false;

            loadEditHistory(video);
        }

        // Display edit history
        function loadEditHistory(video) {
            const historyContainer = document.getElementById('editHistory');
            if (!video.edit_history || video.edit_history.length === 0) {
                historyContainer.innerHTML = '<div class="text-gray-400 italic">Chưa có thao tác nào</div>';
                return;
            }

            historyContainer.innerHTML = video.edit_history.map(edit => `
                <div class="bg-white border border-gray-100 px-3 py-2 rounded-lg text-[11px] text-gray-600 shadow-sm mb-1 border-l-2 border-l-indigo-400">
                    <span class="font-semibold text-gray-800">${edit.action}</span>
                    <div class="text-[9px] text-gray-400 mt-0.5"><i class="far fa-clock"></i> ${edit.timestamp}</div>
                </div>
            `).join('');
        }

        // --- Video Player Controls ---
        const videoPlayer = document.getElementById('videoPlayer');
        const playPauseBtn = document.getElementById('btnPlayPause');
        
        videoPlayer.classList.add('hidden'); // Hide initially

        playPauseBtn.addEventListener('click', async function() {
            try {
                if (videoPlayer.paused) {
                    await videoPlayer.play();
                } else {
                    videoPlayer.pause();
                }
            } catch (error) {
                console.warn('Playback error:', error);
            }
        });

        videoPlayer.addEventListener('play', function() { playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>'; });
        videoPlayer.addEventListener('pause', function() { playPauseBtn.innerHTML = '<i class="fas fa-play"></i>'; });
        videoPlayer.addEventListener('ended', function() { playPauseBtn.innerHTML = '<i class="fas fa-play"></i>'; });

        videoPlayer.addEventListener('timeupdate', function() {
            document.getElementById('currentTime').textContent = formatTime(this.currentTime);
            updateSeekBar();
        });

        document.getElementById('seekBar').addEventListener('input', function() {
            if(videoPlayer.duration) {
                videoPlayer.currentTime = (this.value / 100) * videoPlayer.duration;
            }
        });

        function updateSeekBar() {
            const seekBar = document.getElementById('seekBar');
            const timelineProgress = document.getElementById('timelineProgress');
            if (videoPlayer.duration) {
                const percent = (videoPlayer.currentTime / videoPlayer.duration) * 100;
                seekBar.value = percent;
                timelineProgress.style.width = percent + '%';
            }
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }

        // --- System Status Toasts ---
        function showStatus(msg, type = 'info', autoHide = false) {
            const statusMessage = document.getElementById('statusMessage');
            statusMessage.textContent = msg;
            statusMessage.classList.remove('hidden', 'bg-blue-600', 'bg-green-600', 'bg-red-600', 'text-white');
            
            if(type === 'info') statusMessage.classList.add('bg-blue-600', 'text-white');
            if(type === 'success') statusMessage.classList.add('bg-green-600', 'text-white');
            if(type === 'error') statusMessage.classList.add('bg-red-600', 'text-white');
            
            if(autoHide) setTimeout(() => statusMessage.classList.add('hidden'), 3000);
        }

        // --- Upload Video ---
        document.getElementById('upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('video', file);
            formData.append('title', file.name);

            showStatus('Đang tải lên...', 'info');
            const progressContainer = document.getElementById('uploadProgress');
            progressContainer.classList.remove('hidden');
            
            const xhr = new XMLHttpRequest();
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    document.getElementById('progressBar').style.width = percentComplete + '%';
                    document.getElementById('progressText').textContent = Math.round(percentComplete) + '%';
                    document.getElementById('progressSize').textContent = (e.loaded/(1024*1024)).toFixed(2) + 'MB / ' + (e.total/(1024*1024)).toFixed(2) + 'MB';
                }
            });

            xhr.addEventListener('load', function() {
                progressContainer.classList.add('hidden');
                if (xhr.status === 200) {
                    const data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        showStatus('Tải lên thành công!', 'success', true);
                        videos.push(data.video);
                        selectVideo(data.video.id); // Auto select new video
                    } else throw new Error(data.message);
                } else throw new Error('Upload failed');
            });
            xhr.addEventListener('error', function() {
                progressContainer.classList.add('hidden');
                showStatus('Lỗi tải lên', 'error', true);
            });

            xhr.open('POST', '/dashboard/content_creator/videos');
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.send(formData);
        });

        // --- Common API Fetcher for tools ---
        function runVideoAction(endpoint, bodyData, loadingMsg, successMsg) {
            if(!currentVideoId) { alert("Vui lòng chọn video trước"); return; }
            showStatus(loadingMsg, 'info');

            return fetch(`/dashboard/content_creator/videos/${currentVideoId}/${endpoint}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(bodyData)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    showStatus(successMsg, 'success', true);
                    const index = videos.findIndex(v => v.id === currentVideoId);
                    if (index !== -1) {
                        videos[index] = data.video;
                        selectVideo(currentVideoId); // Reload UI
                    }
                } else throw new Error(data.message);
            })
            .catch(error => {
                showStatus('Lỗi: ' + error.message, 'error', true);
            });
        }

        // --- Trim ---
        document.getElementById('applyTrim').addEventListener('click', function() {
            const s = parseFloat(document.getElementById('trimStart').value);
            const e = parseFloat(document.getElementById('trimEnd').value);
            if (!s || !e || s >= e) { alert('Thông số cắt không hợp lệ (Bắt đầu phải nhỏ hơn Kết thúc)'); return; }
            runVideoAction('trim', { start_time: s, end_time: e }, 'Đang cắt video...', 'Cắt thành công!');
        });

        // --- Text ---
        document.getElementById('applyText').addEventListener('click', function() {
            const t = document.getElementById('textContent').value;
            if(!t) { alert("Nhập văn bản cần đóng dấu!"); return; }
            const payload = {
                text: t,
                x: parseInt(document.getElementById('textX').value) || 10,
                y: parseInt(document.getElementById('textY').value) || 10,
                font_size: parseInt(document.getElementById('textFontSize').value) || 32,
                font_color: document.getElementById('textColor').value,
                start_time: parseFloat(document.getElementById('textStartTime').value) || null,
                duration: null
            };
            runVideoAction('text', payload, 'Đang thêm văn bản...', 'Đã chèn nội dung!');
        });

        // --- Filter Helpers ---
        function runFilterFast(filter, intensity) {
            runVideoAction('filter', { filter: filter, intensity: intensity }, `Đang áp dụng bộ lọc ${filter}...`, 'Đã áp dụng Filter!');
        }
        
        document.getElementById('btnGrayscale').addEventListener('click', () => runFilterFast('grayscale', 1.0));
        document.getElementById('btnSepia').addEventListener('click', () => runFilterFast('sepia', 1.0));
        document.getElementById('applyBrightness').addEventListener('click', () => runFilterFast('brightness', parseFloat(document.getElementById('brightnessValue').value)));
        document.getElementById('applyContrast').addEventListener('click', () => runFilterFast('contrast', parseFloat(document.getElementById('contrastValue').value)));
        document.getElementById('applyBlur').addEventListener('click', () => runFilterFast('blur', parseFloat(document.getElementById('blurValue').value)));
        document.getElementById('applySharpen').addEventListener('click', () => runFilterFast('sharpen', parseFloat(document.getElementById('sharpenValue').value)));

        // --- Resize ---
        document.getElementById('applyResize').addEventListener('click', function() {
            const w = parseInt(document.getElementById('resizeWidth').value);
            const h = parseInt(document.getElementById('resizeHeight').value);
            if(!w || !h) { alert('Nhập kích thước hợp lý!'); return; }
            runVideoAction('resize', { width: w, height: h }, 'Đang thay đổi kích thước...', 'Đã Resize!');
        });

        // --- Rotate ---
        ['90', '180', '270'].forEach(angle => {
            document.getElementById(`rotate${angle}`).addEventListener('click', () => {
                runVideoAction('rotate', { angle: parseInt(angle) }, `Đang xoay ${angle}°...`, 'Đã xoay video!');
            });
        });

        // --- Speed ---
        document.getElementById('speedValue').addEventListener('input', function() {
            document.getElementById('speedValueText').textContent = this.value + 'x';
        });
        document.getElementById('applySpeed').addEventListener('click', function() {
            runVideoAction('speed', { speed: parseFloat(document.getElementById('speedValue').value) }, 'Đang thay đổi tốc độ...', 'Đã cập nhật tốc độ!');
        });

        // --- Audio Upload ---
        document.getElementById('audioUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file || !currentVideoId) return;

            const formData = new FormData();
            formData.append('audio', file);
            formData.append('volume', 1);

            showStatus('Đang hợp nhất âm thanh mới...', 'info');

            fetch(`/dashboard/content_creator/videos/${currentVideoId}/audio`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: formData
            }).then(r=>r.json()).then(data => {
                if(data.success) {
                    showStatus('Ghép âm thanh thành công!', 'success', true);
                    const idx = videos.findIndex(v => v.id === currentVideoId);
                    if (idx !== -1) { videos[idx] = data.video; selectVideo(currentVideoId); }
                } else throw new Error(data.message);
            }).catch(e => showStatus('Lỗi ghép Audio: ' + e.message, 'error', true));
        });

        // --- Extract Audio ---
        document.getElementById('btnExtractAudio').addEventListener('click', function() {
            if(!currentVideoId) return;
            showStatus('Đang xuất âm thanh...', 'info');
            fetch(`/dashboard/content_creator/videos/${currentVideoId}/extract-audio`, {
                method: 'GET',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            }).then(r=>r.json()).then(data => {
                if(data.success) {
                    showStatus('Trích xuất thành công! Đang tải...', 'success', true);
                    const link = document.createElement('a');
                    link.href = data.audio_url; link.download = 'extracted_audio.mp3';
                    document.body.appendChild(link); link.click(); document.body.removeChild(link);
                } else throw new Error(data.message);
            }).catch(e => showStatus('Lỗi xuất Audio: ' + e.message, 'error', true));
        });

        // --- Delete Video ---
        function deleteVideo(videoId, event) {
            event.stopPropagation();
            if (!confirm('Xóa video vĩnh viễn?')) return;
            
            showStatus('Đang xóa...', 'info');
            fetch(`/dashboard/content_creator/videos/${videoId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
            }).then(r=>r.json()).then(data => {
                if(data.success) {
                    showStatus('Đã xóa.', 'success', true);
                    videos = videos.filter(v => v.id !== videoId);
                    if (currentVideoId === videoId) location.reload(); // reset UI for safety
                    else renderVideoList();
                } else throw new Error(data.message);
            }).catch(e => showStatus('Lỗi: ' + e.message, 'error', true));
        }

        // --- Download ---
        document.getElementById('downloadVideo').addEventListener('click', function() {
            if(currentVideoId) window.open(`/dashboard/content_creator/videos/${currentVideoId}/download`, '_blank');
        });

    </script>
</x-app-dashboard>
