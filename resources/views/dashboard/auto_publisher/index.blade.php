<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lên Lịch Đăng Bài Tự Động</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.css" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#E6F7EE',
                            100: '#C8EBD8',
                            200: '#A9DFC2',
                            300: '#8AD3AC',
                            400: '#6BC696',
                            500: '#4CBA80',
                            600: '#1E9C5A',
                            700: '#1A804B',
                            800: '#16643C',
                            900: '#12482D',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Lên Lịch Đăng Bài Tự Động</h1>
                    <p class="mt-1 text-sm text-gray-600">Quản lý và lên lịch đăng bài trên các nền tảng mạng xã hội</p>
                </div>
                <button type="button" class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 focus:outline-none">
                    <svg class="w-4 h-4 me-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tạo Bài Mới
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form tạo bài đăng -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center mb-6">
                        <svg class="w-5 h-5 text-primary-600 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <h2 class="text-lg font-medium text-gray-900">Tạo Bài Đăng Mới</h2>
                    </div>

                    <form class="space-y-6">
                        <!-- Chọn sản phẩm -->
                        <div>
                            <label for="product-select" class="block mb-2 text-sm font-medium text-gray-900">
                                <svg class="w-4 h-4 inline me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Chọn Sản Phẩm
                            </label>
                            <select id="product-select" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                                <option selected>Chọn sản phẩm để thêm vào bài đăng</option>
                                <option value="iphone15">iPhone 15 Pro Max - Điện thoại - 29,990,000đ</option>
                                <option value="macbook">MacBook Air M3 - Laptop - 28,990,000đ</option>
                                <option value="ipad">iPad Pro 12.9" - Tablet - 25,990,000đ</option>
                                <option value="watch">Apple Watch Ultra 2 - Đồng hồ - 19,990,000đ</option>
                                <option value="airpods">AirPods Pro 2 - Tai nghe - 6,490,000đ</option>
                                <option value="samsung">Samsung Galaxy S24 Ultra - Điện thoại - 31,990,000đ</option>
                            </select>
                            
                            <!-- Sản phẩm đã chọn -->
                            <div class="mt-3" id="selected-products">
                                <div class="flex flex-wrap gap-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                        iPhone 15 Pro Max
                                        <button type="button" class="ms-2 -me-1 text-primary-600 hover:text-primary-900">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Nội dung bài đăng -->
                        <div>
                            <label for="post-content" class="block mb-2 text-sm font-medium text-gray-900">
                                <svg class="w-4 h-4 inline me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                Nội Dung Bài Đăng
                            </label>
                            <textarea id="post-content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Viết nội dung bài đăng của bạn...">🔥 KHUYẾN MÃI CỰC HOT! 🔥

✨ iPhone 15 Pro Max chính hãng với mức giá không thể tin nổi!
💰 Giá: 29.990.000đ (Tiết kiệm 5.000.000đ)

🎁 Quà tặng kèm:
- Ốp lưng cao cấp
- Cường lực full màn hình
- Sạc không dây

📱 Liên hệ ngay: 1900.xxx.xxx</textarea>
                        </div>

                        <!-- Chọn nền tảng -->
                        <div>
                            <label class="block mb-3 text-sm font-medium text-gray-900">
                                <svg class="w-4 h-4 inline me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                                Chọn Nền Tảng Đăng
                            </label>
                            <div class="flex flex-wrap gap-3">
                                <div class="flex items-center">
                                    <input id="facebook-checkbox" type="checkbox" value="facebook" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 focus:ring-2" checked>
                                    <label for="facebook-checkbox" class="ms-2 text-sm font-medium text-gray-900">Facebook</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="instagram-checkbox" type="checkbox" value="instagram" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 focus:ring-2">
                                    <label for="instagram-checkbox" class="ms-2 text-sm font-medium text-gray-900">Instagram</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="twitter-checkbox" type="checkbox" value="twitter" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 focus:ring-2" checked>
                                    <label for="twitter-checkbox" class="ms-2 text-sm font-medium text-gray-900">Twitter</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="linkedin-checkbox" type="checkbox" value="linkedin" class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 focus:ring-2">
                                    <label for="linkedin-checkbox" class="ms-2 text-sm font-medium text-gray-900">LinkedIn</label>
                                </div>
                            </div>
                        </div>

                        <!-- Thời gian đăng -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="post-date" class="block mb-2 text-sm font-medium text-gray-900">
                                    <svg class="w-4 h-4 inline me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Ngày Đăng
                                </label>
                                <input type="date" id="post-date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" value="2024-08-15">
                            </div>
                            <div>
                                <label for="post-time" class="block mb-2 text-sm font-medium text-gray-900">
                                    <svg class="w-4 h-4 inline me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Giờ Đăng
                                </label>
                                <input type="time" id="post-time" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" value="10:00">
                            </div>
                        </div>

                        <!-- Hình ảnh -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900" for="post-image">
                                <svg class="w-4 h-4 inline me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tải Lên Hình Ảnh
                            </label>
                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" id="post-image" type="file" accept="image/*" multiple>
                            <p class="mt-1 text-sm text-gray-500">PNG, JPG hoặc GIF (TỐI ĐA 10MB mỗi file)</p>
                        </div>

                        <!-- Nút hành động -->
                        <div class="flex flex-col sm:flex-row gap-3 pt-4">
                            <button type="submit" class="flex-1 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                <svg class="w-4 h-4 me-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Lên Lịch Đăng Bài
                            </button>
                            <button type="button" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5">
                                <svg class="w-4 h-4 me-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Xem Trước
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danh sách bài đăng đã lên lịch -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-medium text-gray-900">
                            <svg class="w-5 h-5 inline me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Bài Đăng Đã Lên Lịch
                        </h3>
                        <span class="bg-primary-100 text-primary-800 text-xs font-medium px-2.5 py-0.5 rounded-full">3</span>
                    </div>

                    <div class="space-y-4">
                        <!-- Bài đăng 1 -->
                        <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900">iPhone 15 Pro Max</h4>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Đã lên lịch
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">Khám phá iPhone 15 Pro Max với camera tuyệt vời và hiệu năng mạnh mẽ...</p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>
                                    <svg class="w-3 h-3 inline me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    15/08/2024 10:00
                                </span>
                                <div class="flex gap-1">
                                    <button class="text-primary-600 hover:text-primary-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex gap-1 mt-2">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700">FB</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-pink-50 text-pink-700">IG</span>
                            </div>
                        </div>

                        <!-- Bài đăng 2 -->
                        <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900">MacBook Air M3</h4>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Đã lên lịch
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">MacBook Air M3 - Siêu mỏng, siêu nhẹ, hiệu năng vượt trội...</p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>
                                    <svg class="w-3 h-3 inline me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    16/08/2024 14:30
                                </span>
                                <div class="flex gap-1">
                                    <button class="text-primary-600 hover:text-primary-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <button class="text-red-600 hover:text-red-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex gap-1 mt-2">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700">FB</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-cyan-50 text-cyan-700">TW</span>
                            </div>
                        </div>

                        <!-- Bài đăng 3 -->
                        <div class="p-4 border border-gray-200 rounded-lg hover:shadow-md transition-shadow">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900">iPad Pro 12.9"</h4>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Đã đăng
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">Trải nghiệm màn hình Liquid Retina XDR tuyệt đỉnh cùng chip M2...</p>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span>
                                    <svg class="w-3 h-3 inline me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    14/08/2024 09:00
                                </span>
                                <div class="flex gap-1">
                                    <button class="text-primary-600 hover:text-primary-800">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex gap-1 mt-2">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700">FB</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-pink-50 text-pink-700">IG</span>
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-indigo-50 text-indigo-700">LI</span>
                            </div>
                        </div>
                    </div>

                    <!-- Xem tất cả -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <button type="button" class="w-full text-center text-sm text-primary-600 hover:text-primary-800 font-medium">
                            Xem tất cả bài đăng
                            <svg class="w-3 h-3 ms-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Xử lý chọn sản phẩm
        document.getElementById('product-select').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue && selectedValue !== '') {
                // Thêm logic xử lý thêm sản phẩm vào danh sách đã chọn
                console.log('Đã chọn sản phẩm:', selectedValue);
            }
        });

        // Xử lý form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Lấy dữ liệu form
            const formData = new FormData(this);
            const postContent = document.getElementById('post-content').value;
            const postDate = document.getElementById('post-date').value;
            const postTime = document.getElementById('post-time').value;
            
            // Kiểm tra các trường bắt buộc
            if (!postContent.trim()) {
                alert('Vui lòng nhập nội dung bài đăng!');
                return;
            }
            
            if (!postDate || !postTime) {
                alert('Vui lòng chọn ngày và giờ đăng!');
                return;
            }
            
            // Kiểm tra nền tảng được chọn
            const selectedPlatforms = [];
            document.querySelectorAll('input[type="checkbox"]:checked').forEach(checkbox => {
                selectedPlatforms.push(checkbox.value);
            });
            
            if (selectedPlatforms.length === 0) {
                alert('Vui lòng chọn ít nhất một nền tảng để đăng!');
                return;
            }
            
            // Hiển thị thông báo thành công
            alert('Đã lên lịch đăng bài thành công!\nNgày: ' + postDate + '\nGiờ: ' + postTime + '\nNền tảng: ' + selectedPlatforms.join(', '));
            
            // Reset form sau khi submit thành công
            this.reset();
            document.getElementById('selected-products').innerHTML = '<div class="flex flex-wrap gap-2"></div>';
        });

        // Xử lý xóa sản phẩm đã chọn
        document.addEventListener('click', function(e) {
            if (e.target.closest('button') && e.target.closest('.inline-flex')) {
                const productTag = e.target.closest('.inline-flex');
                if (productTag) {
                    productTag.remove();
                }
            }
        });

        // Xử lý preview bài đăng
        document.querySelector('button[type="button"]').addEventListener('click', function() {
            const content = document.getElementById('post-content').value;
            const date = document.getElementById('post-date').value;
            const time = document.getElementById('post-time').value;
            
            if (!content.trim()) {
                alert('Vui lòng nhập nội dung bài đăng để xem trước!');
                return;
            }
            
            // Tạo modal preview
            const previewModal = `
                <div id="preview-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
                        <div class="mt-3">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Xem Trước Bài Đăng</h3>
                                <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-primary-600 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                        ST
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Cửa Hàng Điện Thoại</p>
                                        <p class="text-xs text-gray-500">${date} lúc ${time}</p>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="text-sm text-gray-900 whitespace-pre-line">${content}</p>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-3">
                                <button onclick="closePreview()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                                    Đóng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.insertAdjacentHTML('beforeend', previewModal);
        });

        // Hàm đóng modal preview
        window.closePreview = function() {
            const modal = document.getElementById('preview-modal');
            if (modal) {
                modal.remove();
            }
        }

        // Xử lý thêm sản phẩm vào danh sách đã chọn
        function addProduct(productId, productName) {
            const selectedProductsContainer = document.querySelector('#selected-products .flex');
            
            // Kiểm tra sản phẩm đã được chọn chưa
            const existingProduct = document.querySelector(`[data-product-id="${productId}"]`);
            if (existingProduct) {
                return;
            }
            
            const productTag = `
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800" data-product-id="${productId}">
                    ${productName}
                    <button type="button" class="ms-2 -me-1 text-primary-600 hover:text-primary-900" onclick="removeProduct(this)">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </span>
            `;
            
            selectedProductsContainer.insertAdjacentHTML('beforeend', productTag);
        }

        // Hàm xóa sản phẩm
        window.removeProduct = function(button) {
            const productTag = button.closest('.inline-flex');
            if (productTag) {
                productTag.remove();
            }
        }

        // Cập nhật xử lý chọn sản phẩm
        document.getElementById('product-select').addEventListener('change', function() {
            const selectedValue = this.value;
            const selectedText = this.options[this.selectedIndex].text;
            
            if (selectedValue && selectedValue !== '') {
                // Lấy tên sản phẩm từ text của option
                const productName = selectedText.split(' - ')[0];
                addProduct(selectedValue, productName);
                
                // Reset select
                this.value = '';
            }
        });

        // Xử lý drag & drop cho file upload
        const fileInput = document.getElementById('post-image');
        const fileInputContainer = fileInput.parentElement;
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            fileInputContainer.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            fileInputContainer.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            fileInputContainer.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e) {
            fileInputContainer.classList.add('border-primary-500', 'bg-primary-50');
        }
        
        function unhighlight(e) {
            fileInputContainer.classList.remove('border-primary-500', 'bg-primary-50');
        }
        
        fileInputContainer.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            // Hiển thị thông báo số file đã chọn
            if (files.length > 0) {
                const fileCount = files.length;
                const fileText = fileCount === 1 ? 'file' : 'files';
                console.log(`Đã chọn ${fileCount} ${fileText}`);
            }
        }

        // Xử lý thay đổi file input
        fileInput.addEventListener('change', function(e) {
            const fileCount = e.target.files.length;
            if (fileCount > 0) {
                const fileText = fileCount === 1 ? 'file' : 'files';
                console.log(`Đã chọn ${fileCount} ${fileText}`);
            }
        });

        // Auto-resize textarea
        const textarea = document.getElementById('post-content');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });

        // Character counter cho textarea
        textarea.addEventListener('input', function() {
            const maxLength = 2000;
            const currentLength = this.value.length;
            
            let counter = document.querySelector('.character-counter');
            if (!counter) {
                counter = document.createElement('div');
                counter.className = 'character-counter text-xs text-gray-500 mt-1 text-right';
                this.parentNode.appendChild(counter);
            }
            
            counter.textContent = `${currentLength}/${maxLength}`;
            
            if (currentLength > maxLength * 0.9) {
                counter.classList.add('text-orange-500');
            } else {
                counter.classList.remove('text-orange-500');
            }
            
            if (currentLength > maxLength) {
                counter.classList.add('text-red-500');
                this.classList.add('border-red-300');
            } else {
                counter.classList.remove('text-red-500');
                this.classList.remove('border-red-300');
            }
        });

        // Trigger character counter on page load
        textarea.dispatchEvent(new Event('input'));
    </script>
</body>
</html>