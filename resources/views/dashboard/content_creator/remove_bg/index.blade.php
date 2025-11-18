<x-app-dashboard>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-indigo-50 to-purple-50 py-8 px-4" x-data="backgroundRemoval()">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-xl p-6 mb-8 border border-white/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-3 rounded-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Công cụ xóa phông nền</h1>
                            <p class="text-indigo-600">Xóa phông nền ảnh nhanh chóng và chuyên nghiệp</p>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.content_creator.index') }}" class="px-5 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white rounded-xl hover:from-gray-600 hover:to-gray-700 shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Quay về</span>
                    </a>
                </div>
                <nav class="flex items-center space-x-2 text-sm text-indigo-600 mt-4">
                    <a href="{{ route('dashboard.content_creator.index') }}" class="hover:text-indigo-800 transition-colors">Khởi tạo Content</a>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-indigo-800 font-medium">Công cụ xóa phông nền</span>
                </nav>
            </div>

            <!-- Main Card -->
            <div class="bg-white/95 backdrop-blur-lg rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                <!-- Upload Section -->
                <div class="p-8 lg:p-12">
                    <div class="relative">
                        <!-- Upload Area -->
                        <div x-show="!previewUrl" class="border-4 border-dashed border-gray-300 rounded-2xl p-12 text-center hover:border-indigo-500 hover:bg-indigo-50/30 transition-all duration-300 cursor-pointer group"
                             @dragover.prevent="$el.classList.add('border-indigo-500', 'bg-indigo-50')"
                             @dragleave.prevent="$el.classList.remove('border-indigo-500', 'bg-indigo-50')"
                             @drop.prevent="handleDrop($event); $el.classList.remove('border-indigo-500', 'bg-indigo-50')">
                            <input type="file" id="imageInput" accept="image/png,image/jpeg,image/jpg" class="hidden" @change="handleFileSelect($event)">
                            <label for="imageInput" class="cursor-pointer block">
                                <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Kéo thả ảnh vào đây</h3>
                                <p class="text-gray-500 mb-1">hoặc <span class="text-indigo-600 font-semibold">nhấn để chọn file</span></p>
                                <p class="text-sm text-gray-400">PNG, JPG tối đa 12MB</p>
                            </label>
                        </div>

                        <!-- Image Preview -->
                        <div x-show="previewUrl" x-cloak class="space-y-6">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 shadow-inner">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Ảnh đã chọn</h3>
                                        <p class="text-sm text-gray-600 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <span x-text="fileName" class="font-medium"></span>
                                        </p>
                                    </div>
                                    <button @click="reset()" class="p-2 hover:bg-white rounded-lg transition-colors group" title="Xóa ảnh">
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div class="relative rounded-xl overflow-hidden bg-white shadow-lg border">
                                    <img :src="previewUrl" class="w-full h-auto" alt="Preview">
                                </div>
                            </div>

                            <!-- Process Button -->
                            <button @click="processImage()" x-show="!processing && !processedUrl"
                                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-4 px-8 rounded-xl font-semibold text-lg shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Xóa phông nền
                            </button>

                            <!-- Loading -->
                            <div x-show="processing" x-cloak class="text-center py-8">
                                <div class="relative inline-flex items-center justify-center">
                                    <div class="w-16 h-16 border-4 border-indigo-200 border-t-indigo-600 rounded-full animate-spin"></div>
                                    <div class="absolute">
                                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="mt-4 text-lg font-semibold text-gray-700">Đang xử lý ảnh của bạn...</h3>
                                <p class="text-sm text-gray-500 mt-1">Vui lòng chờ trong giây lát</p>
                            </div>
                        </div>

                        <!-- Error -->
                        <div x-show="error" x-cloak class="mt-6">
                            <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 flex items-start gap-3" role="alert">
                                <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" view, viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-red-800">Có lỗi xảy ra</h3>
                                    <p class="text-sm text-red-700 mt-1" x-text="error"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Result Section -->
                <div x-show="processedUrl" x-cloak class="border-t border-gray-200 bg-gradient-to-br from-gray-50 to-white">
                    <div class="p-8 lg:p-12">
                        <div class="text-center mb-8">
                            <div class="inline-flex items-center gap-2 bg-green-100 text-green-800 px-6 py-3 rounded-full font-semibold shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Xóa phông nền thành công!
                            </div>
                        </div>

                        <!-- Before/After -->
                        <div class="grid lg:grid-cols-2 gap-6 mb-8">
                            <div class="space-y-3">
                                <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                                    <span class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-sm">1</span> Ảnh gốc
                                </h3>
                                <div class="relative rounded-xl overflow-hidden shadow-lg border-2 border-gray-200">
                                    <div class="aspect-square bg-gray-100 flex items-center justify-center p-4">
                                        <img :src="previewUrl" class="max-w-full max-h-full object-contain" alt="Original">
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                                    <span class="w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-full flex items-center justify-center text-sm">2</span> Kết quả
                                </h3>
                                <div class="relative rounded-xl overflow-hidden shadow-lg border-2 border-purple-200">
                                    <div class="aspect-square flex items-center justify-center p-4"
                                         :style="'background-image: linear-gradient(45deg, #f3f4f6 25%, transparent 25%), linear-gradient(-45deg, #f3f4f6 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #f3f4f6 75%), linear-gradient(-45deg, transparent 75%, #f3f4f6 75%); background-size: 20px 20px; background-position: 0 0, 0 10px, 10px -10px, -10px 0px;'">
                                        <img :src="processedUrl" class="max-w-full max-h-full object-contain relative z-10" alt="Processed">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button @click="downloadImage()"
                                    class="flex-1 sm:flex-initial bg-gradient-to-r from-green-500 to-emerald-600 text-white py-4 px-8 rounded-xl font-semibold shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Tải xuống ảnh
                            </button>
                            <button @click="reset()"
                                    class="flex-1 sm:flex-initial bg-white border-2 border-gray-300 text-gray-700 py-4 px-8 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Xử lý ảnh khác
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function backgroundRemoval() {
            return {
                selectedFile: null,
                fileName: '',
                previewUrl: null,
                processing: false,
                processedUrl: null,
                error: null,

                handleFileSelect(event) {
                    const file = event.target.files[0];
                    if (file) this.setFile(file);
                },

                handleDrop(event) {
                    const file = event.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) this.setFile(file);
                },

                setFile(file) {
                    if (file.size > 12 * 1024 * 1024) {
                        this.error = 'Kích thước file vượt quá giới hạn 12MB';
                        return;
                    }
                    this.selectedFile = file;
                    this.fileName = file.name;
                    this.previewUrl = URL.createObjectURL(file);
                    this.error = null;
                    this.processedUrl = null;
                },

                async processImage() {
                    if (!this.selectedFile) return;
                    this.processing = true;
                    this.error = null;

                    const formData = new FormData();
                    formData.append('image', this.selectedFile);

                    try {
                        const response = await fetch('{{ route("dashboard.content_creator.remove_background.remove") }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        });
                        const data = await response.json();

                        if (data.success) {
                            this.processedUrl = data.processed_image;
                            setTimeout(() => {
                                document.querySelector('[x-show="processedUrl"]')?.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'nearest'
                                });
                            }, 100);
                        } else {
                            this.error = data.message || 'Không thể xử lý ảnh';
                        }
                    } catch (err) {
                        this.error = 'Lỗi kết nối. Vui lòng kiểm tra và thử lại.';
                        console.error('Error:', err);
                    } finally {
                        this.processing = false;
                    }
                },

                // Hàm fallback: tải tự động
                fallbackDownload(dataURL, filename) {
                    const link = document.createElement('a');
                    link.href = dataURL;
                    link.download = filename;
                    link.style.display = 'none';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                },

                // Hàm chính: tải xuống với showSaveFilePicker
                async downloadImage() {
                    if (!this.processedUrl) return;

                    try {
                        // Tạo tên file mới
                        const originalName = this.fileName.replace(/\.[^/.]+$/, '');
                        const suggestedName = `${originalName}_no_bg.png`;

                        // Chuyển base64 → Blob
                        const base64Data = this.processedUrl.split(',')[1];
                        const byteCharacters = atob(base64Data);
                        const byteNumbers = new Array(byteCharacters.length);
                        for (let i = 0; i < byteCharacters.length; i++) {
                            byteNumbers[i] = byteCharacters.charCodeAt(i);
                        }
                        const byteArray = new Uint8Array(byteNumbers);
                        const blob = new Blob([byteArray], { type: 'image/png' });

                        // Dùng File System Access API (Chrome, Edge, Opera mới)
                        if ('showSaveFilePicker' in window) {
                            try {
                                const handle = await window.showSaveFilePicker({
                                    suggestedName: suggestedName,
                                    types: [{
                                        description: 'PNG Image',
                                        accept: { 'image/png': ['.png'] },
                                    }],
                                });
                                const writable = await handle.createWritable();
                                await writable.write(blob);
                                await writable.close();

                                // Thông báo nhẹ
                                this.showToast('Ảnh đã được lưu thành công!', 'success');
                                return;
                            } catch (err) {
                                if (err.name !== 'AbortError') {
                                    console.warn('showSaveFilePicker failed:', err);
                                }
                                // Người dùng hủy → fallback
                            }
                        }

                        // Fallback: tải tự động
                        const dataURL = this.processedUrl;
                        this.fallbackDownload(dataURL, suggestedName);
                        this.showToast('Đang tải xuống...', 'info');

                    } catch (error) {
                        console.error('Download error:', error);
                        this.error = 'Không thể tải xuống ảnh. Vui lòng thử lại.';
                    }
                },

                // Toast notification (tùy chọn)
                showToast(message, type = 'info') {
                    const toast = document.createElement('div');
                    toast.className = `fixed bottom-6 right-6 px-6 py-3 rounded-xl shadow-xl text-white font-medium z-50 transition-all duration-300 ${
                        type === 'success' ? 'bg-green-600' :
                        type === 'error' ? 'bg-red-600' : 'bg-blue-600'
                    }`;
                    toast.textContent = message;
                    document.body.appendChild(toast);

                    setTimeout(() => {
                        toast.classList.add('opacity-0');
                        setTimeout(() => document.body.removeChild(toast), 300);
                    }, 2500);
                },

                reset() {
                    if (this.previewUrl) URL.revokeObjectURL(this.previewUrl);
                    this.selectedFile = null;
                    this.fileName = '';
                    this.previewUrl = null;
                    this.processedUrl = null;
                    this.error = null;
                    const input = document.getElementById('imageInput');
                    if (input) input.value = '';
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            }
        }
    </script>
</x-app-dashboard>
