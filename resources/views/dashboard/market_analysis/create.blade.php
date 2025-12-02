<x-app-dashboard>
    <div class="container mx-auto px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                        Phân tích thị trường mới
                    </h1>
                    <p class="text-gray-600">Chọn sản phẩm và loại phân tích để bắt đầu nghiên cứu thị trường</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('dashboard.market_analysis.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl transition-all duration-300 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Quay lại</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Create Analysis Form -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-primary-50 to-blue-50 p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                        <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        Thiết lập phân tích
                    </h2>
                    <p class="text-gray-600 mt-1">Chọn thông số để thực hiện phân tích thị trường chi tiết</p>
                </div>

                <div class="p-8">
                    <form id="marketAnalysisForm" action="{{ route('dashboard.market_analysis.analyze') }}" method="POST" class="space-y-8">
                        @csrf

                        <!-- Product Selection -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                Chọn sản phẩm cần phân tích
                            </label>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @if($products = \App\Models\Dashboard\AudienceConfig\Product::where('user_id', auth()->id())->get())
                                    @foreach($products as $product)
                                    <div class="relative">
                                        <input type="radio" id="product-{{ $product->id }}" name="product_id" value="{{ $product->id }}" class="peer sr-only" required>
                                        <label for="product-{{ $product->id }}" class="block p-4 bg-white border-2 border-gray-200 rounded-xl cursor-pointer transition-all duration-200 hover:border-primary-300 hover:shadow-md peer-checked:border-primary-500 peer-checked:bg-primary-50 peer-checked:shadow-lg">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-3 h-3 bg-gray-300 rounded-full peer-checked:bg-primary-500 transition-colors duration-200"></div>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="font-semibold text-gray-900 mb-2">{{ $product->name }}</h4>
                                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $product->description }}</p>
                                                    <div class="flex items-center text-xs text-gray-500">
                                                        <span class="px-2 py-1 bg-gray-100 rounded">{{ $product->industry }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                @else
                                    <div class="col-span-full text-center py-8">
                                        <div class="bg-gray-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-5v2m0 0v2m0-2h2m-2 0h-2"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 mb-4">Bạn chưa có sản phẩm nào để phân tích</p>
                                        <a href="{{ route('dashboard.audience_config.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Tạo sản phẩm đầu tiên
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Analysis Type Selection -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-gray-700 mb-4 flex items-center">
                                <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                </div>
                                Loại phân tích
                            </label>
                            <div class="space-y-4">
                                <div class="relative">
                                    <input type="radio" id="consumer" name="research_type" value="consumer" class="peer sr-only" required>
                                    <label for="consumer" class="flex items-center p-4 bg-gray-50 border-2 border-gray-200 rounded-lg cursor-pointer transition-all duration-200 hover:bg-gray-100 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:shadow-md">
                                        <div class="flex items-center flex-1">
                                            <svg class="w-8 h-8 text-blue-600 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                            <div class="flex-1">
                                                <div class="font-semibold text-gray-900 text-lg">Phân tích người tiêu dùng</div>
                                                <div class="text-gray-600 text-sm">Nghiên cứu hành vi và sở thích khách hàng mục tiêu</div>
                                            </div>
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-blue-600 peer-checked:border-blue-600 transition-colors duration-200 flex-shrink-0">
                                                <div class="w-full h-full rounded-full bg-white peer-checked:bg-white transition-colors duration-200"></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="competitor" name="research_type" value="competitor" class="peer sr-only">
                                    <label for="competitor" class="flex items-center p-4 bg-gray-50 border-2 border-gray-200 rounded-lg cursor-pointer transition-all duration-200 hover:bg-gray-100 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:shadow-md">
                                        <div class="flex items-center flex-1">
                                            <svg class="w-8 h-8 text-red-600 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                            <div class="flex-1">
                                                <div class="font-semibold text-gray-900 text-lg">Phân tích đối thủ</div>
                                                <div class="text-gray-600 text-sm">Theo dõi chiến lược cạnh tranh</div>
                                            </div>
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-red-600 peer-checked:border-red-600 transition-colors duration-200 flex-shrink-0">
                                                <div class="w-full h-full rounded-full bg-white peer-checked:bg-white transition-colors duration-200"></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input type="radio" id="trend" name="research_type" value="trend" class="peer sr-only">
                                    <label for="trend" class="flex items-center p-4 bg-gray-50 border-2 border-gray-200 rounded-lg cursor-pointer transition-all duration-200 hover:bg-gray-100 peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:shadow-md">
                                        <div class="flex items-center flex-1">
                                            <svg class="w-8 h-8 text-green-600 mr-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                            <div class="flex-1">
                                                <div class="font-semibold text-gray-900 text-lg">Xu hướng thị trường</div>
                                                <div class="text-gray-600 text-sm">Phát hiện xu hướng mới nổi</div>
                                            </div>
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:bg-green-600 peer-checked:border-green-600 transition-colors duration-200 flex-shrink-0">
                                                <div class="w-full h-full rounded-full bg-white peer-checked:bg-white transition-colors duration-200"></div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Date Range Section -->
                        <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                Khoảng thời gian phân tích
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Ngày bắt đầu -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Ngày bắt đầu
                                    </label>
                                    <input type="date" name="start_date"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300"
                                        value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                </div>

                                <!-- Ngày kết thúc -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Ngày kết thúc
                                    </label>
                                    <input type="date" name="end_date"
                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Action Section -->
                        <div class="flex justify-center pt-6 border-t border-gray-200">
                            <button type="submit" id="analyzeButton"
                                class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white px-12 py-4 rounded-xl shadow-lg transition-all duration-300 flex items-center space-x-3 hover:shadow-xl transform hover:scale-105 font-semibold text-lg">
                                <svg id="analyzeIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                                <span id="analyzeText">Bắt đầu phân tích thị trường</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-2xl p-8 text-center max-w-sm mx-4">
                <div class="w-16 h-16 bg-gradient-to-r from-primary-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary-600 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Đang phân tích dữ liệu...</h3>
                <p class="text-gray-600 text-sm max-w-xs">
                    Vui lòng chờ trong giây lát, chúng tôi đang xử lý và phân tích dữ liệu thị trường cho bạn.
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('marketAnalysisForm');
            const loadingState = document.getElementById('loadingState');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading state
                loadingState.classList.remove('hidden');

                // Submit the form
                form.submit();
            });
        });
    </script>

    <style>
        /* Custom checkbox styling */
        input[type="radio"]:checked + label > div:last-child {
            background-color: currentColor;
        }

        input[type="radio"]:checked + label > div:last-child > div {
            background-color: inherit;
        }

        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Animation for submit button */
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }
    </style>
</x-app-dashboard>
