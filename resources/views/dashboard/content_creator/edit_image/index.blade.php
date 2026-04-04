<x-app-dashboard>
    <div class="min-h-screen bg-gray-50 px-8 py-8">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] p-6 mb-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-indigo-50 p-4 rounded-xl flex items-center justify-center">
                        <i class="fas fa-image text-indigo-600 text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Trình chỉnh sửa ảnh</h1>
                        <p class="text-gray-500 mt-1">Giao diện chuyên nghiệp, dễ nhìn và đầy đủ công cụ</p>
                    </div>
                </div>

                <!-- Nút hành động bên phải -->
                <div class="flex items-center gap-3">
                    <!-- Nút Quay về -->
                    <a href="{{ route('dashboard.content_creator.index') }}"
                    class="px-5 py-2.5 bg-white border-2 border-gray-200 text-gray-700 rounded-xl hover:border-gray-300 hover:bg-gray-50 shadow-sm transition-all duration-300 flex items-center gap-2 font-medium">
                        <i class="fas fa-arrow-left"></i>
                        <span>Quay về</span>
                    </a>
                </div>
            </div>

            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mt-5">
                <a href="{{ route('dashboard.content_creator.index') }}" class="hover:text-indigo-600 font-medium transition-colors duration-200">Khởi tạo Content</a>
                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-indigo-600 font-semibold">Công cụ</span>
            </nav>
        </div>

        <!-- Filerobot Image Editor Container -->
        <div class="bg-white rounded-2xl shadow-[0_2px_15px_-3px_rgba(6,81,237,0.1)] border border-gray-100 overflow-hidden relative flex flex-col items-center justify-center p-0" style="height: calc(100vh - 160px); min-height: 750px;">
            
            <!-- Upload Area (Trạng thái rỗng ban đầu) -->
            <div id="upload_area" class="w-full max-w-xl mx-auto p-12 text-center h-full flex flex-col items-center justify-center">
                <label for="image_upload" class="flex flex-col items-center justify-center w-full h-80 border-2 border-dashed border-gray-300 rounded-3xl cursor-pointer hover:bg-indigo-50/50 hover:border-indigo-400 transition-all duration-300">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <div class="p-5 bg-indigo-100/50 rounded-full mb-5 transition-transform duration-300 hover:scale-110">
                            <i class="fas fa-cloud-upload-alt text-indigo-500 text-5xl"></i>
                        </div>
                        <p class="mb-3 text-2xl font-bold text-gray-800">Tải ảnh lên</p>
                        <p class="text-base text-gray-500">Nhấp vào đây để chọn ảnh từ thiết bị của bạn</p>
                    </div>
                    <input id="image_upload" type="file" accept="image/*" class="hidden" />
                </label>
            </div>

            <!-- Nơi chứa Filerobot Editor -->
            <div id="editor_container" class="hidden w-full h-full"></div>
        </div>
    </div>

    <!-- Filerobot Image Editor CDN (Latest Version 4+) -->
    <script src="https://scaleflex.cloudimg.io/v7/plugins/filerobot-image-editor/latest/filerobot-image-editor.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const uploadInput = document.getElementById('image_upload');
            const uploadArea = document.getElementById('upload_area');
            const editorContainer = document.getElementById('editor_container');
            let filerobotImageEditor = null;

            uploadInput.addEventListener('change', (e) => {
                if (e.target.files && e.target.files[0]) {
                    const file = e.target.files[0];
                    const imageUrl = URL.createObjectURL(file);
                    
                    // Ẩn upload, hiện editor
                    uploadArea.classList.add('hidden');
                    editorContainer.classList.remove('hidden');

                    initEditor(imageUrl);
                }
            });

            function initEditor(imageUrl) {
                const { TABS, TOOLS } = FilerobotImageEditor;

                const config = {
                    source: imageUrl, 
                    onSave: (editedImageObject, designState) => {
                        const { imageBase64, fullName } = editedImageObject;
                        const link = document.createElement('a');
                        link.href = imageBase64;
                        link.download = fullName || 'edited-image.png';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    annotationsCommon: {
                        fill: '#ff0000',
                    },
                    Text: { text: 'Nhập văn bản...' },
                    translations: {
                        profile: 'Hồ sơ',
                        coverPhoto: 'Ảnh bìa',
                        facebook: 'Facebook',
                        twitter: 'Twitter',
                        instagram: 'Instagram',
                        igSquare: 'IG Vuông',
                        igPortrait: 'IG Dọc',
                        igStory: 'IG Story',
                        fbPost: 'FB Bài viết',
                        fbProfile: 'FB Hồ sơ',
                        fbCover: 'FB Ảnh bìa',
                        custom: 'Tùy chỉnh',
                        save: 'Lưu ảnh',
                        saveAs: 'Lưu bản mới',
                        back: 'Quay lại',
                        download: 'Tải xuống',
                        downloadAs: 'Tải xuống...',
                        open: 'Tải lên',
                        uploadImage: 'Chọn ảnh',
                        crop: 'Cắt',
                        adjust: 'Điều chỉnh',
                        filters: 'Bộ lọc',
                        watermark: 'Đóng dấu',
                        annotate: 'Vẽ & Chữ',
                        resize: 'Kích thước',
                        brightness: 'Độ sáng',
                        contrast: 'Độ tương phản',
                        exposure: 'Phơi sáng',
                        saturation: 'Bão hòa',
                        text: 'Chữ',
                        image: 'Thêm ảnh',
                        polygon: 'Đa giác',
                        rect: 'Chữ nhật',
                        circle: 'Tròn',
                        line: 'Đường thẳng',
                        arrow: 'Mũi tên',
                        undo: 'Hoàn tác',
                        redo: 'Làm lại',
                        reset: 'Cài lại gốc',
                        cancel: 'Hủy'
                    }
                    // Bỏ cấu hình theme để Filerobot tự động sử dụng giao diện Light Mode tuyệt đẹp mặc định.
                };

                // Dọn dẹp editor cũ nếu có
                if (filerobotImageEditor) {
                    filerobotImageEditor.terminate();
                }

                filerobotImageEditor = new FilerobotImageEditor(
                    document.querySelector('#editor_container'),
                    config
                );

                filerobotImageEditor.render({
                    onClose: (closingReason) => {
                        console.log('Editor closed', closingReason);
                        filerobotImageEditor.terminate();
                        filerobotImageEditor = null;
                        
                        editorContainer.classList.add('hidden');
                        uploadArea.classList.remove('hidden');
                        uploadInput.value = ''; 
                    }
                });
            }
        });
    </script>
</x-app-dashboard>