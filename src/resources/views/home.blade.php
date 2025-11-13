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
                                    <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">
                                        Tạo Nội Dung & Đăng Bài Tự Động với AI Marketer Pro
                                    </h1>
                                    <p class="text-lg md:text-xl text-primary-200 dark:text-gray-300 mb-6 max-w-xl mx-auto lg:mx-0">
                                        Tăng tốc chiến dịch marketing của bạn với công cụ AI mạnh mẽ, tích hợp đăng bài tự động và giao diện thân thiện, giúp bạn tiết kiệm thời gian và tối ưu hiệu quả.
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                                        <a href="{{ route('dashboard.index') }}"
                                        class="inline-flex items-center px-6 py-3 text-base font-medium text-white bg-primary rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 dark:focus:ring-gray-800 transition">
                                            Bắt Đầu Ngay
                                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                        <a href="#"
                                        class="inline-flex items-center px-6 py-3 text-base font-medium text-primary bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 transition">
                                            Xem Demo
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
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                                    Tại sao chọn AI Marketer Pro?
                                </h2>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                                    Tăng hiệu quả marketing với các tính năng AI tiên tiến và tích hợp tự động hóa.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <!-- Feature 1 -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <div class="flex items-center justify-center w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full mb-4">
                                        <svg class="w-6 h-6 text-primary dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        Tạo Nội Dung Tự Động
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Tạo bài viết, hình ảnh, và video chất lượng cao chỉ trong vài giây với công nghệ AI tiên tiến.
                                    </p>
                                </div>
                                <!-- Feature 2 -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <div class="flex items-center justify-center w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full mb-4">
                                        <svg class="w-6 h-6 text-primary dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        Đăng Bài Tự Động
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Lên lịch và đăng bài tự động trên các nền tảng mạng xã hội, tiết kiệm thời gian và công sức.
                                    </p>
                                </div>
                                <!-- Feature 3 -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <div class="flex items-center justify-center w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full mb-4">
                                        <svg class="w-6 h-6 text-primary dark:text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                        Giao Diện Thân Thiện
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-300">
                                        Giao diện trực quan được xây dựng trên Laravel và Flowbite, dễ sử dụng cho mọi người.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Testimonials Section -->
                    <section class="bg-gray-50 dark:bg-gray-900 py-16">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="text-center mb-12">
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                                    Khách Hàng Nói Gì Về AI Marketer Pro?
                                </h2>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                                    Nghe từ những người đã sử dụng công cụ của chúng tôi để nâng tầm chiến dịch marketing.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Testimonial 1 -->
                                <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <p class="text-gray-600 dark:text-gray-300 italic mb-4">
                                        "AI Marketer Pro đã giúp tôi tiết kiệm hàng giờ mỗi tuần với tính năng đăng bài tự động. Nội dung được tạo ra rất chất lượng!"
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
                                        "Giao diện thân thiện và dễ sử dụng. Tôi có thể tạo nội dung chuyên nghiệp mà không cần kỹ năng thiết kế!"
                                    </p>
                                    <div class="flex items-center">
                                        <div class="w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center text-primary dark:text-primary-300 font-semibold">
                                            HL
                                        </div>
                                        <div class="ml-4">
                                            <p class="font-semibold text-gray-900 dark:text-white">Hà Linh</p>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Chủ Doanh Nghiệp</p>
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
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                                    Chọn Gói Phù Hợp Với Bạn
                                </h2>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                                    Các gói dịch vụ linh hoạt, phù hợp với mọi nhu cầu marketing của bạn.
                                </p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <!-- Basic Plan -->
                                <div class="p-6 bg-gray-50 dark:bg-gray-900 rounded-lg shadow-md hover:shadow-lg transition">
                                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Cơ Bản</h3>
                                    <p class="text-3xl font-bold text-primary dark:text-primary-300 mb-4">Miễn Phí</p>
                                    <ul class="text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tạo 10 bài viết/tháng
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Đăng bài tự động 1 nền tảng
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Hỗ trợ cơ bản
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
                                    <p class="text-3xl font-bold text-primary dark:text-primary-300 mb-4">Liên Hệ</p>
                                    <ul class="text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tạo nội dung không giới hạn
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Đăng bài tự động nhiều nền tảng
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Hỗ trợ ưu tiên 24/7
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
                                    <p class="text-3xl font-bold text-primary dark:text-primary-300 mb-4">Tùy Chỉnh</p>
                                    <ul class="text-gray-600 dark:text-gray-300 mb-6 space-y-2">
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tích hợp API tùy chỉnh
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Quản lý đội nhóm
                                        </li>
                                        <li class="flex items-center">
                                            <svg class="w-5 h-5 text-primary dark:text-primary-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Hỗ trợ chuyên biệt
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
                                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
                                    Câu Hỏi Thường Gặp
                                </h2>
                                <p class="text-lg text-gray-600 dark:text-gray-300 mt-4 max-w-2xl mx-auto">
                                    Tìm hiểu thêm về cách AI Marketer Pro có thể giúp bạn.
                                </p>
                            </div>
                            <div class="space-y-4">
                                <!-- FAQ Item 1 -->
                                <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <button @click="open = !open"
                                            class="w-full text-left px-6 py-4 flex justify-between items-center text-gray-900 dark:text-white font-semibold">
                                        AI Marketer Pro hỗ trợ những nền tảng nào?
                                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary dark:text-primary-300 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="px-6 pb-4 text-gray-600 dark:text-gray-300">
                                        AI Marketer Pro hỗ trợ đăng bài tự động trên các nền tảng như Facebook, Instagram, Twitter, LinkedIn, và nhiều nền tảng khác. Liên hệ để biết thêm chi tiết.
                                    </div>
                                </div>
                                <!-- FAQ Item 2 -->
                                <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <button @click="open = !open"
                                            class="w-full text-left px-6 py-4 flex justify-between items-center text-gray-900 dark:text-white font-semibold">
                                        Tôi có cần kỹ năng lập trình để sử dụng?
                                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary dark:text-primary-300 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="px-6 pb-4 text-gray-600 dark:text-gray-300">
                                        Không cần! AI Marketer Pro được thiết kế với giao diện thân thiện, dễ sử dụng cho cả người không có kinh nghiệm lập trình.
                                    </div>
                                </div>
                                <!-- FAQ Item 3 -->
                                <div x-data="{ open: false }" class="bg-white dark:bg-gray-800 rounded-lg shadow-md">
                                    <button @click="open = !open"
                                            class="w-full text-left px-6 py-4 flex justify-between items-center text-gray-900 dark:text-white font-semibold">
                                        Hỗ trợ khách hàng như thế nào?
                                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-primary dark:text-primary-300 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="open" x-transition class="px-6 pb-4 text-gray-600 dark:text-gray-300">
                                        Chúng tôi cung cấp hỗ trợ qua email và chat 24/7 cho gói Pro và Doanh Nghiệp, cùng với tài liệu hướng dẫn chi tiết.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- CTA Section -->
                    <section class="bg-primary dark:bg-primary-900 py-16">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                                Sẵn Sàng Đưa Marketing Lên Tầm Cao Mới?
                            </h2>
                            <p class="text-lg text-primary-200 mb-8 max-w-2xl mx-auto">
                                Tham gia ngay với AI Marketer Pro để trải nghiệm công cụ marketing tối ưu.
                            </p>
                            <a href="#"
                                class="inline-flex items-center px-6 py-3 text-base font-medium text-primary bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 transition">
                                Đăng Ký Miễn Phí
                            </a>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>