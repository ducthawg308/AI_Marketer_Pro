<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-gray-900 dark:text-gray-100">
                    <!-- Hero Section -->
                    <section class="relative bg-gradient-to-r from-primary to-primary-900 dark:from-gray-800 dark:to-gray-900 text-white py-24 overflow-hidden sm:rounded-lg">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                            <div class="text-center lg:text-left lg:flex lg:items-center lg:justify-between">
                                <!-- Text Content -->
                                <div class="lg:w-1/2">
                                    <h1 class="text-4xl md:text-5xl font-semibold mb-4 leading-tight">
                                        Nghiên Cứu, Sáng Tạo & Tự Động Hóa cùng AI Marketer Pro
                                    </h1>
                                    <p class="text-lg md:text-xl text-primary-200 dark:text-gray-300 mb-6 max-w-xl mx-auto lg:mx-0">
                                        Nền tảng marketing toàn diện: dự đoán xu hướng thị trường với Prophet, sáng tạo nội dung đa phương tiện bằng Gemini AI, và tự động hóa toàn bộ quy trình lên lịch đăng bài Facebook.
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                        <a href="{{ route('dashboard.index') }}"
                                        class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-primary rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 dark:focus:ring-gray-800 transition">
                                            Đi Đến Bảng Điều Khiển
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('dashboard.market_research.index') }}"
                                        class="inline-flex items-center px-6 py-3 text-base font-medium text-primary bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition">
                                            Phân Tích Xu Hướng Ngay
                                        </a>
                                    </div>
                                </div>
                                <!-- Image or Illustration (Placeholder) -->
                                <div class="hidden lg:block lg:w-1/2 mt-10 lg:mt-0">
                                    <img src="{{ asset('images/hero.png') }}" alt="AI Marketer Pro Illustration" class="mx-auto w-full max-w-md object-cover rounded-lg">
                                </div>
                            </div>
                        </div>
                        <!-- Overlay for Gradient Effect -->
                        <div class="absolute inset-0 bg-black opacity-20"></div>
                    </section>

                    <!-- Features Section -->
                    <section class="bg-white dark:bg-gray-800 py-16">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-12">
                                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white">
                                    Giải Pháp Marketing Xuyên Suốt Bằng AI
                                </h2>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                                    Từ ý tưởng đến xuất bản – Hệ thống DSS và AI tích hợp giúp tối ưu hóa từng bước trong chiến dịch.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <!-- Feature 1 -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <div class="flex items-center justify-center w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full mb-4">
                                        <svg class="w-6 h-6 text-primary dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        Nghiên Cứu Thị Trường
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Ứng dụng dữ liệu Google Trends và thuật toán Prophet để dự báo sự tăng trưởng, giúp bạn nắm bắt xu hướng chính xác.
                                    </p>
                                </div>
                                <!-- Feature 2 -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <div class="flex items-center justify-center w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full mb-4">
                                        <svg class="w-6 h-6 text-primary dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        Sáng Tạo Nội Dung
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Khởi tạo bài viết, tách nền AI, chỉnh sửa hình ảnh & video mạnh mẽ chỉ với vài thao tác thông qua Gemini AI.
                                    </p>
                                </div>
                                <!-- Feature 3 -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <div class="flex items-center justify-center w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full mb-4">
                                        <svg class="w-6 h-6 text-primary dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        Quản Lý Chiến Dịch
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Lên lịch đăng tự động lên các Fanpage Facebook, theo dõi tương tác và nhận đề xuất nhờ Hệ thống Hỗ trợ Quyết định (DSS).
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Testimonials Section -->
                    <section class="bg-gray-50 dark:bg-gray-900 py-16">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-12">
                                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white">
                                    Khách Hàng Nói Gì Về AI Marketer Pro?
                                </h2>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                                    Trải nghiệm thay đổi cách vận hành marketing của các doanh nghiệp.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Testimonial 1 -->
                                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <p class="text-gray-600 dark:text-gray-300 italic mb-4">
                                        "Biểu đồ dự báo xu hướng từ Prophet giúp tôi tiết kiệm hàng đống thời gian research. Giờ đây việc định hướng nội dung cực kỳ chính xác!"
                                    </p>
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center text-primary dark:text-primary-300 font-semibold">
                                            NT
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-900 dark:text-white">Nguyễn Trần</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Digital Marketer</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Testimonial 2 -->
                                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <p class="text-gray-600 dark:text-gray-300 italic mb-4">
                                        "Công cụ chỉnh sửa video, tạo nội dung hàng loạt bằng Gemini và lên lịch qua Graph API thực sự là một cỗ máy thay thế hoàn toàn một team social."
                                    </p>
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center text-primary dark:text-primary-300 font-semibold">
                                            HL
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-900 dark:text-white">Hà Linh</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Content Manager</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Pricing Section -->
                    <section class="bg-white dark:bg-gray-800 py-16">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-12">
                                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white">
                                    Chọn Gói Phù Hợp Với Bạn
                                </h2>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                                    Các gói dịch vụ linh hoạt, mở khóa các công cụ AI phân tích mạnh mẽ.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <!-- Basic Plan -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Cơ Bản</h3>
                                    <p class="text-3xl font-semibold text-primary dark:text-primary-300 mb-4">Miễn Phí</p>
                                    <ul class="text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Phân tích xu hướng giới hạn
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tạo 10 bài viết bằng AI/tháng
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Đăng bài lên 1 Fanpage
                                        </li>
                                    </ul>
                                    <a href="#"
                                        class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-primary rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-gray-800 transition">
                                        Chọn Gói
                                    </a>
                                </div>
                                <!-- Pro Plan -->
                                <div class="p-6 bg-primary-50 dark:bg-primary-900 rounded-lg shadow-md hover:shadow-lg transition border-2 border-primary dark:border-primary-300">
                                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Pro</h3>
                                    <p class="text-3xl font-semibold text-primary dark:text-primary-300 mb-4">Liên Hệ</p>
                                    <ul class="text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Truy cập đầy đủ module Prophet & Trends
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Không giới hạn tạo nội dung Gemini
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Báo cáo phân tích DSS chuyên sâu
                                        </li>
                                    </ul>
                                    <a href="#"
                                        class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-primary rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-gray-800 transition">
                                        Liên Hệ
                                    </a>
                                </div>
                                <!-- Enterprise Plan -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Doanh Nghiệp</h3>
                                    <p class="text-3xl font-semibold text-primary dark:text-primary-300 mb-4">Tùy Chỉnh</p>
                                    <ul class="text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tích hợp microservice riêng biệt
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Quản lý phân quyền nội bộ (Admin/User)
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Hỗ trợ hệ thống chuyên biệt 24/7
                                        </li>
                                    </ul>
                                    <a href="#"
                                        class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-primary rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:focus:ring-gray-800 transition">
                                        Liên Hệ
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- FAQ Section -->
                    <section class="bg-gray-50 dark:bg-gray-900 py-16">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-12">
                                <h2 class="text-3xl md:text-4xl font-semibold text-gray-900 dark:text-white">
                                    Câu Hỏi Thường Gặp
                                </h2>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                                    Tìm hiểu thêm về cách hệ thống AI Marketer Pro hoạt động.
                                </p>
                            </div>
                            <div class="space-y-4">
                                <!-- FAQ Item 1 -->
                                <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <button @click="open = !open"
                                            class="w-full text-left px-6 py-4 flex justify-between items-center text-gray-900 dark:text-white font-semibold">
                                        Hệ thống dự báo xu hướng hoạt động như thế nào?
                                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary dark:text-primary-300 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="px-6 pb-4 text-gray-600 dark:text-gray-300">
                                        Chúng tôi sử dụng thuật toán Prophet của Facebook kết hợp với dữ liệu thu thập từ Google Trends thông qua Python microservice để đưa ra dự báo chính xác về mức độ quan tâm của thị trường.
                                    </div>
                                </div>
                                <!-- FAQ Item 2 -->
                                <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <button @click="open = !open"
                                            class="w-full text-left px-6 py-4 flex justify-between items-center text-gray-900 dark:text-white font-semibold">
                                        Tôi có thể tự động đăng video kèm thumbnail không?
                                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary dark:text-primary-300 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="px-6 pb-4 text-gray-600 dark:text-gray-300">
                                        Hoàn toàn có thể. Module Sáng Tạo Nội Dung hỗ trợ chỉnh sửa video, trích xuất thumbnail. Sau đó bạn có thể lên lịch đăng toàn bộ nội dung này qua module Auto Publisher.
                                    </div>
                                </div>
                                <!-- FAQ Item 3 -->
                                <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <button @click="open = !open"
                                            class="w-full text-left px-6 py-4 flex justify-between items-center text-gray-900 dark:text-white font-semibold">
                                        Dữ liệu Fanpage của tôi có được bảo mật không?
                                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary dark:text-primary-300 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="px-6 pb-4 text-gray-600 dark:text-gray-300">
                                        Có. Mọi kết nối với Fanpage đều sử dụng Graph API chính thức của Facebook và tuân thủ các tiêu chuẩn bảo mật nghiêm ngặt.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- CTA Section -->
                    <section class="bg-primary dark:bg-primary-900 py-16">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                            <h2 class="text-3xl md:text-4xl font-semibold text-white mb-4">
                                Bạn Đã Sẵn Sàng Vận Hành Chiến Dịch AI?
                            </h2>
                            <p class="text-lg text-primary-200 mb-8 max-w-2xl mx-auto">
                                Tham gia ngay và trải nghiệm sức mạnh từ dữ liệu dự báo kết hợp AI tạo sinh.
                            </p>
                            <a href="{{ route('dashboard.index') }}"
                                class="inline-flex items-center px-6 py-3 text-base font-medium text-primary bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 transition">
                                Trải Nghiệm Bảng Điều Khiển
                            </a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>