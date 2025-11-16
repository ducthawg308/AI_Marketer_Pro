<x-app-dashboard>
    <div class="min-h-screen bg-gradient-to-br from-slate-800 via-indigo-900 to-slate-800 px-8 py-8">
        <!-- Header -->
        <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-6 mb-4 border border-white/10">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="bg-gradient-to-r from-indigo-400 to-purple-400 p-3 rounded-xl">
                        <i class="fas fa-image text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Trình chỉnh sửa hình ảnh chuyên nghiệp</h1>
                        <p class="text-indigo-200">Chỉnh sửa ảnh chuyên nghiệp với đầy đủ công cụ</p>
                    </div>
                </div>

                <!-- Nút hành động bên phải -->
                <div class="flex items-center gap-3">
                    <!-- Nút Quay về -->
                    <a href="{{ route('dashboard.content_creator.index') }}"
                    class="px-5 py-3 bg-gradient-to-r from-gray-400 to-gray-500 text-white rounded-xl hover:from-gray-500 hover:to-gray-600 shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Quay về</span>
                    </a>

                    <!-- Nút Lưu ảnh -->
                    <button id="save"
                            class="px-6 py-3 bg-gradient-to-r from-emerald-400 to-teal-500 text-white rounded-xl hover:from-emerald-500 hover:to-teal-600 shadow-md hover:shadow-lg transition-all duration-300 flex items-center gap-2">
                        <i class="fas fa-download"></i>
                        <span>Lưu ảnh</span>
                    </button>
                </div>
            </div>

            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm text-indigo-200 mt-4">
                <a href="{{ route('dashboard.content_creator.index') }}" class="hover:text-white transition-colors duration-200">Khởi tạo Content</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-white font-medium">Công cụ chỉnh sửa ảnh</span>
            </nav>
        </div>

        <div class="grid grid-cols-12 gap-4">
            <!-- Left Sidebar - Tools -->
            <div class="col-span-12 lg:col-span-2">
                <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-4 border border-white/10">
                    <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-tools"></i>
                        Công cụ
                    </h3>
                    
                    <!-- Upload -->
                    <div class="mb-4">
                        <label for="upload" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-indigo-300 rounded-xl cursor-pointer hover:bg-white/5 transition-all duration-300">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <i class="fas fa-cloud-upload-alt text-indigo-300 text-3xl mb-2"></i>
                                <p class="text-sm text-indigo-200 font-medium">Tải ảnh lên</p>
                            </div>
                            <input id="upload" type="file" accept="image/*" class="hidden" />
                        </label>
                    </div>

                    <!-- Drawing Tools -->
                    <div class="space-y-2 mb-4">
                        <button id="btnSelect" class="w-full px-4 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-all flex items-center gap-2">
                            <i class="fas fa-mouse-pointer"></i>
                            <span>Chọn</span>
                        </button>
                        <button id="btnDraw" class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all flex items-center gap-2">
                            <i class="fas fa-pen"></i>
                            <span>Vẽ tự do</span>
                        </button>
                        <button id="btnText" class="w-full px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-all flex items-center gap-2">
                            <i class="fas fa-font"></i>
                            <span>Thêm chữ</span>
                        </button>
                        <button id="btnPencil" class="w-full px-4 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-all flex items-center gap-2">
                            <i class="fas fa-pencil-alt"></i>
                            <span>Bút chì</span>
                        </button>
                        <button id="btnSpray" class="w-full px-4 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all flex items-center gap-2">
                            <i class="fas fa-spray-can"></i>
                            <span>Xịt màu</span>
                        </button>
                        <button id="btnArrow" class="w-full px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-all flex items-center gap-2">
                            <i class="fas fa-arrow-right"></i>
                            <span>Mũi tên</span>
                        </button>
                    </div>

                    <!-- Shapes -->
                    <div class="mb-4">
                        <h4 class="text-indigo-200 text-sm font-bold mb-2">Hình dạng</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <button id="btnRect" class="px-3 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-all">
                                <i class="far fa-square"></i>
                            </button>
                            <button id="btnCircle" class="px-3 py-2 bg-teal-500 text-white rounded-lg hover:bg-teal-600 transition-all">
                                <i class="far fa-circle"></i>
                            </button>
                            <button id="btnTriangle" class="px-3 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-all">
                                <i class="fas fa-play" style="transform: rotate(-90deg)"></i>
                            </button>
                            <button id="btnLine" class="px-3 py-2 bg-lime-500 text-white rounded-lg hover:bg-lime-600 transition-all">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button id="btnPolygon" class="px-3 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all">
                                <i class="fas fa-draw-polygon"></i>
                            </button>
                            <button id="btnStar" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all">
                                <i class="fas fa-star"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Color Picker -->
                    <div class="mb-4">
                        <label class="text-indigo-200 text-sm font-bold mb-2 block">Màu sắc</label>
                        <input id="colorPicker" type="color" value="#ff0000" class="w-full h-10 rounded-lg cursor-pointer" />
                    </div>

                    <!-- Brush Size -->
                    <div class="mb-4">
                        <label class="text-indigo-200 text-sm font-bold mb-2 block">Kích thước nét vẽ</label>
                        <input id="brushSize" type="range" min="1" max="50" value="5" class="w-full" />
                        <span id="brushSizeValue" class="text-indigo-200 text-sm">5px</span>
                    </div>

                    <!-- Stroke Width -->
                    <div class="mb-4">
                        <label class="text-indigo-200 text-sm font-bold mb-2 block">Độ dày viền</label>
                        <input id="strokeWidth" type="range" min="0" max="20" value="2" class="w-full" />
                        <span id="strokeWidthValue" class="text-indigo-200 text-sm">2px</span>
                    </div>

                    <!-- Background Color -->
                    <div class="mb-4">
                        <label class="text-indigo-200 text-sm font-bold mb-2 block">Màu nền canvas</label>
                        <input id="bgColor" type="color" value="#ffffff" class="w-full h-10 rounded-lg cursor-pointer" />
                    </div>
                </div>
            </div>

            <!-- Center - Canvas -->
            <div class="col-span-12 lg:col-span-8">
                <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-6 border border-white/10">
                    <!-- Toolbar -->
                    <div class="mb-4 flex flex-wrap gap-2">
                        <!-- Transform -->
                        <div class="flex gap-2 border-r border-white/10 pr-2">
                            <button id="btnRotateLeft" class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all" title="Xoay trái">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button id="btnRotateRight" class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all" title="Xoay phải">
                                <i class="fas fa-redo"></i>
                            </button>
                            <button id="btnFlipH" class="px-3 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-all" title="Lật ngang">
                                <i class="fas fa-arrows-alt-h"></i>
                            </button>
                            <button id="btnFlipV" class="px-3 py-2 bg-cyan-500 text-white rounded-lg hover:bg-cyan-600 transition-all" title="Lật dọc">
                                <i class="fas fa-arrows-alt-v"></i>
                            </button>
                        </div>

                        <!-- Crop & Resize -->
                        <div class="flex gap-2 border-r border-white/10 pr-2">
                            <button id="btnCrop" class="px-3 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600 transition-all" title="Cắt ảnh">
                                <i class="fas fa-crop-alt"></i>
                            </button>
                            <button id="btnApplyCrop" class="px-3 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-all hidden" title="Áp dụng cắt">
                                <i class="fas fa-check"></i> Cắt
                            </button>
                            <button id="btnCancelCrop" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all hidden" title="Hủy cắt">
                                <i class="fas fa-times"></i> Hủy
                            </button>
                            <button id="btnResize" class="px-3 py-2 bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-all" title="Thay đổi kích thước">
                                <i class="fas fa-expand-arrows-alt"></i>
                            </button>
                        </div>

                        <!-- Filters -->
                        <div class="flex gap-2 border-r border-white/10 pr-2">
                            <button id="btnGrayscale" class="px-3 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all" title="Đen trắng">
                                <i class="fas fa-adjust"></i>
                            </button>
                            <button id="btnSepia" class="px-3 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-all" title="Sepia">
                                <i class="fas fa-sun"></i>
                            </button>
                            <button id="btnInvert" class="px-3 py-2 bg-violet-500 text-white rounded-lg hover:bg-violet-600 transition-all" title="Đảo màu">
                                <i class="fas fa-exchange-alt"></i>
                            </button>
                            <button id="btnBlur" class="px-3 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500 transition-all" title="Làm mờ">
                                <i class="fas fa-eye-slash"></i>
                            </button>
                            <button id="btnPixelate" class="px-3 py-2 bg-pink-500 text-white rounded-lg hover:bg-pink-600 transition-all" title="Pixel hóa">
                                <i class="fas fa-th"></i>
                            </button>
                            <button id="btnRemoveColor" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all" title="Xóa màu">
                                <i class="fas fa-tint-slash"></i>
                            </button>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <button id="btnDelete" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all" title="Xóa đối tượng">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button id="btnClear" class="px-3 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 transition-all" title="Xóa tất cả">
                                <i class="fas fa-eraser"></i>
                            </button>
                            <button id="btnUndo" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all" title="Hoàn tác">
                                <i class="fas fa-undo-alt"></i>
                            </button>
                            <button id="btnRedo" class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all" title="Làm lại">
                                <i class="fas fa-redo-alt"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Canvas Container -->
                    <div class="flex justify-center bg-gradient-to-br from-gray-700 to-gray-800 rounded-xl p-4">
                        <canvas id="editor" width="900" height="600" class="border-4 border-white/10 rounded-lg shadow-xl"></canvas>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar - Properties -->
            <div class="col-span-12 lg:col-span-2">
                <div class="bg-white/5 backdrop-blur-md rounded-2xl shadow-xl p-4 border border-white/10">
                    <h3 class="text-white font-bold mb-4 flex items-center gap-2">
                        <i class="fas fa-sliders-h"></i>
                        Thuộc tính
                    </h3>

                    <!-- Brightness -->
                    <div class="mb-4">
                        <label class="text-indigo-200 text-sm font-bold mb-2 block flex items-center gap-2">
                            <i class="fas fa-brightness"></i>
                            Độ sáng
                        </label>
                        <input id="brightness" type="range" min="-1" max="1" step="0.1" value="0" class="w-full" />
                        <span id="brightnessValue" class="text-indigo-200 text-xs">0</span>
                    </div>

                    <!-- Contrast -->
                    <div class="mb-4">
                        <label class="text-indigo-200 text-sm font-bold mb-2 block flex items-center gap-2">
                            <i class="fas fa-adjust"></i>
                            Độ tương phản
                        </label>
                        <input id="contrast" type="range" min="-1" max="1" step="0.1" value="0" class="w-full" />
                        <span id="contrastValue" class="text-indigo-200 text-xs">0</span>
                    </div>

                    <!-- Saturation -->
                    <div class="mb-4">
                        <label class="text-indigo-200 text-sm font-bold mb-2 block flex items-center gap-2">
                            <i class="fas fa-palette"></i>
                            Độ bão hòa
                        </label>
                        <input id="saturation" type="range" min="-1" max="1" step="0.1" value="0" class="w-full" />
                        <span id="saturationValue" class="text-indigo-200 text-xs">0</span>
                    </div>

                    <!-- Opacity -->
                    <div class="mb-4">
                        <label class="text-indigo-200 text-sm font-bold mb-2 block flex items-center gap-2">
                            <i class="fas fa-eye"></i>
                            Độ mờ
                        </label>
                        <input id="opacity" type="range" min="0" max="1" step="0.1" value="1" class="w-full" />
                        <span id="opacityValue" class="text-indigo-200 text-xs">100%</span>
                    </div>

                    <!-- Shadow -->
                    <div class="mb-4">
                        <button id="btnShadow" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-all flex items-center gap-2">
                            <i class="fas fa-moon"></i>
                            <span>Thêm bóng</span>
                        </button>
                    </div>

                    <!-- Gradient -->
                    <div class="mb-4">
                        <button id="btnGradient" class="w-full px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg hover:from-indigo-600 hover:to-purple-600 transition-all flex items-center gap-2">
                            <i class="fas fa-fill-drip"></i>
                            <span>Gradient</span>
                        </button>
                    </div>

                    <!-- Pattern -->
                    <div class="mb-4">
                        <button id="btnPattern" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-all flex items-center gap-2">
                            <i class="fas fa-border-all"></i>
                            <span>Pattern</span>
                        </button>
                    </div>

                    <!-- Layer Order -->
                    <div class="mb-4">
                        <h4 class="text-indigo-200 text-sm font-bold mb-2">Thứ tự lớp</h4>
                        <div class="grid grid-cols-2 gap-2">
                            <button id="btnBringFront" class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all text-xs">
                                <i class="fas fa-level-up-alt"></i> Lên trước
                            </button>
                            <button id="btnSendBack" class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all text-xs">
                                <i class="fas fa-level-down-alt"></i> Xuống sau
                            </button>
                        </div>
                    </div>

                    <!-- Clone & Lock -->
                    <div class="space-y-2">
                        <button id="btnClone" class="w-full px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-all flex items-center gap-2">
                            <i class="fas fa-clone"></i>
                            <span>Sao chép</span>
                        </button>
                        <button id="btnLock" class="w-full px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all flex items-center gap-2">
                            <i class="fas fa-lock"></i>
                            <span>Khóa/Mở</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script giữ nguyên - không thay đổi -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.0/fabric.min.js"></script>
    <script>
        const canvas = new fabric.Canvas('editor', {
            backgroundColor: '#ffffff'
        });
        
        let currentImg = null;
        let isDrawing = false;
        let history = [];
        let historyStep = -1;
        let cropRect = null;    
        let isCropping = false;

        // Save state for undo
        function saveState() {
            if (historyStep < history.length - 1) {
                history = history.slice(0, historyStep + 1);
            }
            history.push(JSON.stringify(canvas));
            historyStep++;
        }

        // Undo
        document.getElementById('btnUndo').onclick = function() {
            if (historyStep > 0) {
                historyStep--;
                canvas.loadFromJSON(history[historyStep], canvas.renderAll.bind(canvas));
            }
        };

        // Upload image
        document.getElementById('upload').onchange = function (e) {
            const reader = new FileReader();
            reader.onload = function (f) {
                fabric.Image.fromURL(f.target.result, function (img) {
                    currentImg = img;
                    img.scaleToWidth(800);
                    canvas.centerObject(img);
                    canvas.add(img);
                    canvas.sendToBack(img);
                    canvas.setActiveObject(img);
                    canvas.renderAll();
                    saveState();
                });
            };
            reader.readAsDataURL(e.target.files[0]);
        };

        // Select mode
        document.getElementById('btnSelect').onclick = function() {
            canvas.isDrawingMode = false;
        };

        // Drawing mode
        document.getElementById('btnDraw').onclick = function() {
            canvas.isDrawingMode = true;
            canvas.freeDrawingBrush.color = document.getElementById('colorPicker').value;
            canvas.freeDrawingBrush.width = parseInt(document.getElementById('brushSize').value);
        };

        // Brush size
        document.getElementById('brushSize').oninput = function() {
            const size = this.value;
            document.getElementById('brushSizeValue').textContent = size + 'px';
            if (canvas.isDrawingMode) {
                canvas.freeDrawingBrush.width = parseInt(size);
            }
        };

        // Color picker
        document.getElementById('colorPicker').onchange = function() {
            const color = this.value;
            if (canvas.isDrawingMode) {
                canvas.freeDrawingBrush.color = color;
            }
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.set('fill', color);
                canvas.renderAll();
            }
        };

        // Add text
        document.getElementById('btnText').onclick = function() {
            const text = new fabric.IText('Nhập văn bản', {
                left: 100,
                top: 100,
                fontSize: 30,
                fill: document.getElementById('colorPicker').value,
                fontFamily: 'Arial'
            });
            canvas.add(text);
            canvas.setActiveObject(text);
            saveState();
        };

        // Add shapes
        document.getElementById('btnRect').onclick = function() {
            const rect = new fabric.Rect({
                left: 100,
                top: 100,
                fill: document.getElementById('colorPicker').value,
                width: 150,
                height: 100,
                stroke: '#000',
                strokeWidth: 2
            });
            canvas.add(rect);
            canvas.setActiveObject(rect);
            saveState();
        };

        document.getElementById('btnCircle').onclick = function() {
            const circle = new fabric.Circle({
                left: 100,
                top: 100,
                fill: document.getElementById('colorPicker').value,
                radius: 75,
                stroke: '#000',
                strokeWidth: 2
            });
            canvas.add(circle);
            canvas.setActiveObject(circle);
            saveState();
        };

        document.getElementById('btnTriangle').onclick = function() {
            const triangle = new fabric.Triangle({
                left: 100,
                top: 100,
                fill: document.getElementById('colorPicker').value,
                width: 100,
                height: 100,
                stroke: '#000',
                strokeWidth: 2
            });
            canvas.add(triangle);
            canvas.setActiveObject(triangle);
            saveState();
        };

        document.getElementById('btnLine').onclick = function() {
            const line = new fabric.Line([50, 100, 200, 100], {
                stroke: document.getElementById('colorPicker').value,
                strokeWidth: 5
            });
            canvas.add(line);
            canvas.setActiveObject(line);
            saveState();
        };

        // Rotate
        document.getElementById('btnRotateRight').onclick = function () {
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.rotate((obj.angle + 90) % 360);
                canvas.renderAll();
                saveState();
            }
        };

        document.getElementById('btnRotateLeft').onclick = function () {
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.rotate((obj.angle - 90) % 360);
                canvas.renderAll();
                saveState();
            }
        };

        // Flip
        document.getElementById('btnFlipH').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.set('flipX', !obj.flipX);
                canvas.renderAll();
                saveState();
            }
        };

        document.getElementById('btnFlipV').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.set('flipY', !obj.flipY);
                canvas.renderAll();
                saveState();
            }
        };

        // Filters
        function applyFilter(filterType) {
            const obj = canvas.getActiveObject();
            if (obj && obj.type === 'image') {
                let filter;
                switch(filterType) {
                    case 'grayscale':
                        filter = new fabric.Image.filters.Grayscale();
                        break;
                    case 'sepia':
                        filter = new fabric.Image.filters.Sepia();
                        break;
                    case 'invert':
                        filter = new fabric.Image.filters.Invert();
                        break;
                    case 'blur':
                        filter = new fabric.Image.filters.Blur({ blur: 0.5 });
                        break;
                    case 'pixelate':
                        filter = new fabric.Image.filters.Pixelate({ blocksize: 8 });
                        break;
                    case 'removeColor':
                        filter = new fabric.Image.filters.RemoveColor({
                            color: '#FFFFFF',
                            distance: 0.5
                        });
                        break;
                }
                obj.filters.push(filter);
                obj.applyFilters();
                canvas.renderAll();
                saveState();
            }
        }

        document.getElementById('btnGrayscale').onclick = () => applyFilter('grayscale');
        document.getElementById('btnSepia').onclick = () => applyFilter('sepia');
        document.getElementById('btnInvert').onclick = () => applyFilter('invert');
        document.getElementById('btnBlur').onclick = () => applyFilter('blur');
        document.getElementById('btnPixelate').onclick = () => applyFilter('pixelate');
        document.getElementById('btnRemoveColor').onclick = () => applyFilter('removeColor');

        // Brightness
        document.getElementById('brightness').oninput = function() {
            const value = parseFloat(this.value);
            document.getElementById('brightnessValue').textContent = value.toFixed(1);
            const obj = canvas.getActiveObject();
            if (obj && obj.type === 'image') {
                obj.filters = obj.filters.filter(f => !(f instanceof fabric.Image.filters.Brightness));
                obj.filters.push(new fabric.Image.filters.Brightness({ brightness: value }));
                obj.applyFilters();
                canvas.renderAll();
            }
        };

        // Contrast
        document.getElementById('contrast').oninput = function() {
            const value = parseFloat(this.value);
            document.getElementById('contrastValue').textContent = value.toFixed(1);
            const obj = canvas.getActiveObject();
            if (obj && obj.type === 'image') {
                obj.filters = obj.filters.filter(f => !(f instanceof fabric.Image.filters.Contrast));
                obj.filters.push(new fabric.Image.filters.Contrast({ contrast: value }));
                obj.applyFilters();
                canvas.renderAll();
            }
        };

        // Saturation
        document.getElementById('saturation').oninput = function() {
            const value = parseFloat(this.value);
            document.getElementById('saturationValue').textContent = value.toFixed(1);
            const obj = canvas.getActiveObject();
            if (obj && obj.type === 'image') {
                obj.filters = obj.filters.filter(f => !(f instanceof fabric.Image.filters.Saturation));
                obj.filters.push(new fabric.Image.filters.Saturation({ saturation: value }));
                obj.applyFilters();
                canvas.renderAll();
            }
        };

        // Opacity
        document.getElementById('opacity').oninput = function() {
            const value = parseFloat(this.value);
            document.getElementById('opacityValue').textContent = Math.round(value * 100) + '%';
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.set('opacity', value);
                canvas.renderAll();
            }
        };

        // Shadow
        document.getElementById('btnShadow').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.set('shadow', new fabric.Shadow({
                    color: 'rgba(0,0,0,0.5)',
                    blur: 10,
                    offsetX: 5,
                    offsetY: 5
                }));
                canvas.renderAll();
                saveState();
            }
        };

        // Layer order
        document.getElementById('btnBringFront').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                canvas.bringToFront(obj);
                canvas.renderAll();
                saveState();
            }
        };

        document.getElementById('btnSendBack').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                canvas.sendToBack(obj);
                canvas.renderAll();
                saveState();
            }
        };

        // Clone
        document.getElementById('btnClone').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.clone(function(cloned) {
                    cloned.set({
                        left: obj.left + 20,
                        top: obj.top + 20
                    });
                    canvas.add(cloned);
                    canvas.setActiveObject(cloned);
                    canvas.renderAll();
                    saveState();
                });
            }
        };

        // Lock/Unlock
        document.getElementById('btnLock').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.set({
                    lockMovementX: !obj.lockMovementX,
                    lockMovementY: !obj.lockMovementY,
                    lockScalingX: !obj.lockScalingX,
                    lockScalingY: !obj.lockScalingY,
                    lockRotation: !obj.lockRotation
                });
                canvas.renderAll();
            }
        };

        // Delete
        document.getElementById('btnDelete').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                canvas.remove(obj);
                canvas.renderAll();
                saveState();
            }
        };

        // Clear canvas
        document.getElementById('btnClear').onclick = function () {
            if (confirm('Bạn có chắc muốn xóa tất cả?')) {
                canvas.clear();
                canvas.backgroundColor = '#ffffff';
                currentImg = null;
                saveState();
            }
        };

        // Save image
        document.getElementById('save').onclick = async function () {
            const dataURL = canvas.toDataURL({
                format: 'png',
                quality: 1
            });
            
            // Convert dataURL to Blob
            const response = await fetch(dataURL);
            const blob = await response.blob();
            
            // Try using File System Access API (Chrome/Edge modern)
            if ('showSaveFilePicker' in window) {
                try {
                    const handle = await window.showSaveFilePicker({
                        suggestedName: 'edited-image.png',
                        types: [{
                            description: 'PNG Image',
                            accept: {'image/png': ['.png']},
                        }],
                    });
                    const writable = await handle.createWritable();
                    await writable.write(blob);
                    await writable.close();
                    alert('Ảnh đã được lưu!');
                } catch (err) {
                    // User cancelled or browser doesn't support
                    fallbackDownload(dataURL);
                }
            } else {
                // Fallback for older browsers
                fallbackDownload(dataURL);
            }
        };

        function fallbackDownload(dataURL) {
            const link = document.createElement('a');
            link.download = 'edited-image.png';
            link.href = dataURL;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Redo
        document.getElementById('btnRedo').onclick = function() {
            if (historyStep < history.length - 1) {
                historyStep++;
                canvas.loadFromJSON(history[historyStep], canvas.renderAll.bind(canvas));
            }
        };

        // Pencil mode
        document.getElementById('btnPencil').onclick = function() {
            canvas.isDrawingMode = true;
            canvas.freeDrawingBrush = new fabric.PencilBrush(canvas);
            canvas.freeDrawingBrush.color = document.getElementById('colorPicker').value;
            canvas.freeDrawingBrush.width = parseInt(document.getElementById('brushSize').value);
        };

        // Spray mode
        document.getElementById('btnSpray').onclick = function() {
            canvas.isDrawingMode = true;
            canvas.freeDrawingBrush = new fabric.SprayBrush(canvas);
            canvas.freeDrawingBrush.color = document.getElementById('colorPicker').value;
            canvas.freeDrawingBrush.width = parseInt(document.getElementById('brushSize').value);
        };

        // Stroke width
        document.getElementById('strokeWidth').oninput = function() {
            const width = parseInt(this.value);
            document.getElementById('strokeWidthValue').textContent = width + 'px';
            const obj = canvas.getActiveObject();
            if (obj) {
                obj.set('strokeWidth', width);
                canvas.renderAll();
            }
        };

        // Background color
        document.getElementById('bgColor').onchange = function() {
            canvas.backgroundColor = this.value;
            canvas.renderAll();
            saveState();
        };

        // Add polygon (hexagon)
        document.getElementById('btnPolygon').onclick = function() {
            const points = [
                {x: 50, y: 0},
                {x: 100, y: 0},
                {x: 125, y: 43},
                {x: 100, y: 86},
                {x: 50, y: 86},
                {x: 25, y: 43}
            ];
            const polygon = new fabric.Polygon(points, {
                left: 100,
                top: 100,
                fill: document.getElementById('colorPicker').value,
                stroke: '#000',
                strokeWidth: parseInt(document.getElementById('strokeWidth').value) || 2
            });
            canvas.add(polygon);
            canvas.setActiveObject(polygon);
            saveState();
        };

        // Add star
        document.getElementById('btnStar').onclick = function() {
            const points = [];
            const spikes = 5;
            const outerRadius = 50;
            const innerRadius = 25;
            
            for (let i = 0; i < spikes * 2; i++) {
                const radius = i % 2 === 0 ? outerRadius : innerRadius;
                const angle = (Math.PI / spikes) * i;
                points.push({
                    x: 150 + radius * Math.sin(angle),
                    y: 150 - radius * Math.cos(angle)
                });
            }
            
            const star = new fabric.Polygon(points, {
                fill: document.getElementById('colorPicker').value,
                stroke: '#000',
                strokeWidth: parseInt(document.getElementById('strokeWidth').value) || 2
            });
            canvas.add(star);
            canvas.setActiveObject(star);
            saveState();
        };

        // Add arrow
        document.getElementById('btnArrow').onclick = function() {
            const line = new fabric.Line([50, 100, 200, 100], {
                stroke: document.getElementById('colorPicker').value,
                strokeWidth: parseInt(document.getElementById('strokeWidth').value) || 3
            });
            
            const triangle = new fabric.Triangle({
                left: 195,
                top: 92,
                width: 20,
                height: 20,
                fill: document.getElementById('colorPicker').value,
                angle: 90
            });
            
            const arrow = new fabric.Group([line, triangle], {
                left: 100,
                top: 100
            });
            
            canvas.add(arrow);
            canvas.setActiveObject(arrow);
            saveState();
        };

        // Crop functionality
        document.getElementById('btnCrop').onclick = function() {
            if (!isCropping) {
                isCropping = true;
                cropRect = new fabric.Rect({
                    left: 100,
                    top: 100,
                    width: 300,
                    height: 200,
                    fill: 'rgba(0,0,0,0.3)',
                    stroke: '#fff',
                    strokeWidth: 2,
                    strokeDashArray: [5, 5],
                    cornerColor: 'white',
                    cornerSize: 12,
                    transparentCorners: false
                });
                canvas.add(cropRect);
                canvas.setActiveObject(cropRect);
                document.getElementById('btnApplyCrop').classList.remove('hidden');
                document.getElementById('btnCancelCrop').classList.remove('hidden');
            }
        };

        document.getElementById('btnApplyCrop').onclick = function() {
            if (cropRect) {
                const left = cropRect.left;
                const top = cropRect.top;
                const width = cropRect.width * cropRect.scaleX;
                const height = cropRect.height * cropRect.scaleY;
                
                canvas.remove(cropRect);
                
                const croppedCanvas = document.createElement('canvas');
                croppedCanvas.width = width;
                croppedCanvas.height = height;
                const ctx = croppedCanvas.getContext('2d');
                
                const dataURL = canvas.toDataURL();
                const img = new Image();
                img.onload = function() {
                    ctx.drawImage(img, left, top, width, height, 0, 0, width, height);
                    canvas.clear();
                    fabric.Image.fromURL(croppedCanvas.toDataURL(), function(image) {
                        canvas.setWidth(width);
                        canvas.setHeight(height);
                        image.set({left: 0, top: 0, selectable: false});
                        canvas.add(image);
                        canvas.sendToBack(image);
                        canvas.renderAll();
                        saveState();
                    });
                };
                img.src = dataURL;
                
                cropRect = null;
                isCropping = false;
                document.getElementById('btnApplyCrop').classList.add('hidden');
                document.getElementById('btnCancelCrop').classList.add('hidden');
            }
        };

        document.getElementById('btnCancelCrop').onclick = function() {
            if (cropRect) {
                canvas.remove(cropRect);
                cropRect = null;
                isCropping = false;
                document.getElementById('btnApplyCrop').classList.add('hidden');
                document.getElementById('btnCancelCrop').classList.add('hidden');
                canvas.renderAll();
            }
        };

        // Resize canvas
        document.getElementById('btnResize').onclick = function() {
            const newWidth = prompt('Nhập chiều rộng mới (px):', canvas.width);
            const newHeight = prompt('Nhập chiều cao mới (px):', canvas.height);
            
            if (newWidth && newHeight) {
                canvas.setWidth(parseInt(newWidth));
                canvas.setHeight(parseInt(newHeight));
                canvas.renderAll();
                saveState();
            }
        };

        // Gradient
        document.getElementById('btnGradient').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                const gradient = new fabric.Gradient({
                    type: 'linear',
                    coords: { x1: 0, y1: 0, x2: obj.width, y2: 0 },
                    colorStops: [
                        { offset: 0, color: '#ff0000' },
                        { offset: 0.5, color: '#ffff00' },
                        { offset: 1, color: '#0000ff' }
                    ]
                });
                obj.set('fill', gradient);
                canvas.renderAll();
                saveState();
            }
        };

        // Pattern
        document.getElementById('btnPattern').onclick = function() {
            const obj = canvas.getActiveObject();
            if (obj) {
                const patternCanvas = document.createElement('canvas');
                patternCanvas.width = 20;
                patternCanvas.height = 20;
                const pCtx = patternCanvas.getContext('2d');
                pCtx.fillStyle = document.getElementById('colorPicker').value;
                pCtx.beginPath();
                pCtx.arc(10, 10, 3, 0, Math.PI * 2);
                pCtx.fill();
                
                const pattern = new fabric.Pattern({
                    source: patternCanvas,
                    repeat: 'repeat'
                });
                obj.set('fill', pattern);
                canvas.renderAll();
                saveState();
            }
        };

        // Save initial state
        saveState();

        // Auto-save state after drawing
        canvas.on('path:created', function() {
            saveState();
        });

        canvas.on('object:modified', function() {
            saveState();
        });
    </script>
</x-app-dashboard>