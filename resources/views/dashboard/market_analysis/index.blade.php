<x-app-dashboard>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.3);
            border-radius: 2px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.5);
        }
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: rgba(156, 163, 175, 0.3) transparent;
        }
    </style>
    <!-- Main Container with Sidebar -->
    <div class="flex h-screen bg-gray-50">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <div class="flex-1 overflow-y-auto custom-scrollbar">
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
                                    Nghiên cứu thị trường
                                </h1>
                                <p class="text-gray-600">Phân tích dữ liệu thị trường và đối thủ cạnh tranh một cách chi tiết</p>
                            </div>
                        </div>
                    </div>

                    <!-- Bộ lọc nghiên cứu -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8 overflow-hidden">
                        <div class="bg-gradient-to-r from-primary-50 to-blue-50 p-6 border-b border-gray-200">
                            <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v3.586a1 1 0 01-.293.707l-2 2A1 1 0 0110 21v-5.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z"></path>
                                    </svg>
                                </div>
                                Bộ lọc nghiên cứu
                            </h2>
                            <p class="text-gray-600 mt-1">Chọn thông số để thực hiện phân tích thị trường chi tiết</p>
                        </div>

                        <div class="p-8">
                            <form id="marketAnalysisForm" class="space-y-8" action="{{ route('dashboard.market_analysis.analyze') }}" method="POST">
                                @csrf

                                <!-- Main Filter Section -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Left Column -->
                                    <div class="space-y-6">
                                        <!-- Đối tượng mục tiêu -->
                                        <div class="group">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                </div>
                                                Đối tượng mục tiêu
                                            </label>
                                            <select id="audienceTarget" name="product_id"
                                                class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300 hover:shadow-md" required>
                                                <option value="">-- Chọn sản phẩm --</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                        {{ $product->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Loại nghiên cứu -->
                                        <div class="group">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                                    </svg>
                                                </div>
                                                Loại nghiên cứu
                                            </label>
                                            <div class="space-y-3">
                                                <div class="relative">
                                                    <input type="radio" id="consumer" name="research_type" value="consumer" class="peer sr-only" required>
                                                    <label for="consumer" class="flex items-center p-4 bg-gray-50 border-2 border-gray-200 rounded-lg cursor-pointer transition-all duration-200 hover:bg-gray-100 peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:shadow-md">
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                                            </svg>
                                                            <div>
                                                                <div class="font-medium text-gray-900">Phân tích người tiêu dùng</div>
                                                                <div class="text-sm text-gray-500">Nghiên cứu hành vi và sở thích khách hàng</div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="relative">
                                                    <input type="radio" id="competitor" name="research_type" value="competitor" class="peer sr-only">
                                                    <label for="competitor" class="flex items-center p-4 bg-gray-50 border-2 border-gray-200 rounded-lg cursor-pointer transition-all duration-200 hover:bg-gray-100 peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:shadow-md">
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                            <div>
                                                                <div class="font-medium text-gray-900">Phân tích đối thủ</div>
                                                                <div class="text-sm text-gray-500">Theo dõi chiến lược cạnh tranh</div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <div class="relative">
                                                    <input type="radio" id="trend" name="research_type" value="trend" class="peer sr-only">
                                                    <label for="trend" class="flex items-center p-4 bg-gray-50 border-2 border-gray-200 rounded-lg cursor-pointer transition-all duration-200 hover:bg-gray-100 peer-checked:bg-green-50 peer-checked:border-green-500 peer-checked:shadow-md">
                                                        <div class="flex items-center">
                                                            <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                                            </svg>
                                                            <div>
                                                                <div class="font-medium text-gray-900">Xu hướng thị trường</div>
                                                                <div class="text-sm text-gray-500">Phát hiện xu hướng mới nổi</div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="space-y-6">
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

                                            <div class="space-y-4">
                                                <!-- Ngày bắt đầu -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        Ngày bắt đầu
                                                    </label>
                                                    <input type="date" name="start_date"
                                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300 hover:shadow-md" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                                </div>

                                                <!-- Ngày kết thúc -->
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        Ngày kết thúc
                                                    </label>
                                                    <input type="date" name="end_date"
                                                        class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300 hover:shadow-md" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Quick Date Presets -->
                                        <div class="grid grid-cols-2 gap-3">
                                            <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 border border-gray-300 hover:shadow-md" onclick="setDateRange(7)">
                                                7 ngày qua
                                            </button>
                                            <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 border border-gray-300 hover:shadow-md" onclick="setDateRange(30)">
                                                30 ngày qua
                                            </button>
                                            <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 border border-gray-300 hover:shadow-md" onclick="setDateRange(90)">
                                                3 tháng qua
                                            </button>
                                            <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 border border-gray-300 hover:shadow-md" onclick="setDateRange(365)">
                                                1 năm qua
                                            </button>
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

                    <!-- Loading State -->
                    <div id="loadingState" class="hidden bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-primary-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-primary-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Đang phân tích dữ liệu...</h3>
                        <p class="text-gray-600 max-w-md mx-auto">
                            Vui lòng chờ trong giây lát, chúng tôi đang xử lý và phân tích dữ liệu thị trường cho bạn.
                        </p>
                    </div>

                    <!-- Kết quả phân tích -->
                    <div id="analysisResult" class="hidden animate-fade-in">
                        <!-- Nội dung sẽ được load từ AJAX -->
                    </div>

                    <!-- Trạng thái chờ phân tích -->
                    <div id="waitingState" class="bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
                        <div class="w-24 h-24 bg-gradient-to-r from-primary-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Sẵn sàng phân tích</h3>
                        <p class="text-gray-600 max-w-md mx-auto">
                            Chọn các thông số ở trên và nhấn "Phân tích thị trường" để bắt đầu nghiên cứu dữ liệu chi tiết.
                        </p>

                        <!-- Các tính năng nổi bật -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8 max-w-4xl mx-auto">
                            <div class="bg-primary-50 p-6 rounded-lg">
                                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-2">Phân tích người dùng</h4>
                                <p class="text-sm text-gray-600">Hiểu rõ hành vi và sở thích của khách hàng mục tiêu</p>
                            </div>

                            <div class="bg-blue-50 p-6 rounded-lg">
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-2">Nghiên cứu đối thủ</h4>
                                <p class="text-sm text-gray-600">Phân tích chiến lược và điểm mạnh của các đối thủ</p>
                            </div>

                            <div class="bg-purple-50 p-6 rounded-lg">
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold text-gray-900 mb-2">Xu hướng thị trường</h4>
                                <p class="text-sm text-gray-600">Nắm bắt các xu hướng và cơ hội mới nhất</p>
                            </div>
                        </div>
                    </div>

                    <!-- Error State -->
                    <div id="errorState" class="hidden bg-white rounded-xl shadow-lg border border-red-200 p-12 text-center">
                        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-red-900 mb-2">Có lỗi xảy ra</h3>
                        <p class="text-red-600 max-w-md mx-auto mb-4" id="errorMessage">
                            Không thể thực hiện phân tích. Vui lòng thử lại sau.
                        </p>
                        <button onclick="hideError()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
                            Thử lại
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar History -->
        <div id="sidebar-history" class="w-96 bg-white shadow-lg border-l border-gray-200 flex flex-col transition-all duration-300">
            <!-- Sidebar Header -->
            <div class="p-4 bg-gradient-to-r from-primary-50 to-blue-50 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        Lịch sử phân tích
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Các bản phân tích gần đây</p>
                </div>
                <button id="toggle-sidebar" class="p-1 text-gray-400 hover:text-primary-600 hover:bg-primary-100 rounded-lg transition-colors duration-200" title="Thu nhỏ sidebar">
                    <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
            </div>

            <!-- History Content -->
            <div class="flex-1 overflow-y-auto custom-scrollbar p-4">
                @if($analyses->count() > 0)
                    <div class="space-y-4">
                        @foreach($analyses as $analysis)
                        @php
                            $typeLabels = [
                                'consumer' => 'Người tiêu dùng',
                                'competitor' => 'Đối thủ cạnh tranh',
                                'trend' => 'Xu hướng thị trường'
                            ];
                            $typeColors = [
                                'consumer' => 'bg-blue-100 text-blue-800 border-blue-200',
                                'competitor' => 'bg-red-100 text-red-800 border-red-200',
                                'trend' => 'bg-green-100 text-green-800 border-green-200'
                            ];
                            $typeName = $typeLabels[$analysis->research_type] ?? 'Phân tích';
                            $typeColor = $typeColors[$analysis->research_type] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                        @endphp

                        <div class="bg-white border rounded-lg p-4 hover:shadow-md transition-shadow duration-200 cursor-pointer" onclick="viewAnalysis({{ $analysis->id }})">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-gray-900 truncate">{{ $analysis->title }}</h4>
                                    <div class="flex items-center space-x-2 mt-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $typeColor }}">
                                            {{ $typeName }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($analysis->created_at)->format('d/m') }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($analysis->created_at)->format('H:i') }}</p>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="flex items-center text-xs text-gray-600 mb-3">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $analysis->product->name ?? 'Không xác định' }}
                            </div>

                            <!-- Summary -->
                            <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($analysis->summary, 80) }}</p>

                            <!-- Actions -->
                            <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-100">
                                <a href="{{ route('dashboard.market_analysis.show', $analysis->id) }}"
                                   class="text-xs text-primary-600 hover:text-primary-800 font-medium">
                                    Xem chi tiết →
                                </a>

                                <div class="flex space-x-1">
                                    <button onclick="event.stopPropagation(); showDeleteModal({{ $analysis->id }}, '{{ addslashes($analysis->title) }}')"
                                            class="text-xs text-red-500 hover:text-red-700 px-2 py-1 rounded hover:bg-red-50 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                    <button onclick="event.stopPropagation(); toggleExportMenuSidebar({{ $analysis->id }})"
                                            class="text-xs text-gray-500 hover:text-gray-700 px-2 py-1 rounded hover:bg-gray-50 transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Export Menu -->
                            <div id="sidebar-export-menu-{{ $analysis->id }}" class="hidden absolute bg-white border border-gray-200 rounded-lg shadow-lg p-2 z-10">
                                <a href="{{ route('dashboard.market_analysis.export_individual', [$analysis->id, 'pdf']) }}"
                                   class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded">
                                    <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414l-5-5H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path>
                                    </svg>
                                    Xuất PDF
                                </a>
                                <a href="{{ route('dashboard.market_analysis.export_individual', [$analysis->id, 'word']) }}"
                                   class="flex items-center px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded">
                                    <svg class="w-3 h-3 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Xuất Word
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <!-- Empty History State in Sidebar -->
                    <div class="text-center py-12">
                        <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">Chưa có phân tích nào</p>
                        <p class="text-xs text-gray-400 mt-1">Các bản phân tích sẽ xuất hiện ở đây</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Date range functionality
        function setDateRange(days) {
            const endDate = new Date();
            const startDate = new Date();
            startDate.setDate(endDate.getDate() - days);

            const startInput = document.querySelector('input[name="start_date"]');
            const endInput = document.querySelector('input[name="end_date"]');

            startInput.value = formatDate(startDate);
            endInput.value = formatDate(endDate);
        }

        function formatDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        // Form submission with AJAX
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('marketAnalysisForm');
            const analyzeButton = document.getElementById('analyzeButton');
            const analyzeIcon = document.getElementById('analyzeIcon');
            const analyzeText = document.getElementById('analyzeText');
            const waitingState = document.getElementById('waitingState');
            const loadingState = document.getElementById('loadingState');
            const analysisResult = document.getElementById('analysisResult');
            const errorState = document.getElementById('errorState');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                // Show loading state
                showLoading();

                // Make AJAX request
                fetch('{{ route('dashboard.market_analysis.analyze') }}', {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showResults(data.html);
                    } else {
                        showError(data.message || 'Có lỗi xảy ra trong quá trình phân tích');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Không thể kết nối đến server. Vui lòng thử lại sau.');
                })
                .finally(() => {
                    resetButton();
                });
            });

            function showLoading() {
                // Update button state
                analyzeButton.disabled = true;
                analyzeIcon.innerHTML = `
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                `;
                analyzeIcon.classList.add('animate-spin');
                analyzeText.textContent = 'Đang phân tích...';

                // Hide other states and show loading
                waitingState.classList.add('hidden');
                analysisResult.classList.add('hidden');
                errorState.classList.add('hidden');
                loadingState.classList.remove('hidden');
            }

            function showResults(html) {
                loadingState.classList.add('hidden');
                analysisResult.innerHTML = html;
                analysisResult.classList.remove('hidden');
            }

            function showError(message) {
                loadingState.classList.add('hidden');
                document.getElementById('errorMessage').textContent = message;
                errorState.classList.remove('hidden');
            }

            function resetButton() {
                analyzeButton.disabled = false;
                analyzeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                `;
                analyzeIcon.classList.remove('animate-spin');
                analyzeText.textContent = 'Bắt đầu phân tích thị trường';
            }

            // Global function to hide error
            window.hideError = function() {
                errorState.classList.add('hidden');
                waitingState.classList.remove('hidden');
            }
        });

        // Sidebar functions
        function viewAnalysis(analysisId) {
            window.location.href = '{{ url('dashboard/market_analysis') }}/' + analysisId;
        }

        // Modal management functions
        function showDeleteModal(analysisId, title) {
            // Update modal title
            document.getElementById('delete-analysis-title').textContent = title;

            // Update form action dynamically
            const deleteForm = document.getElementById('delete-form');
            deleteForm.action = `/dashboard/market_analysis/${analysisId}`;

            // Show modal using Flowbite
            const modal = new Modal(document.getElementById('confirm-delete-analysis'));
            modal.show();
        }

        function deleteAnalysis(analysisId, title) {
            analysisToDelete = analysisId;
            analysisTitle = title;

            // Set the title in the modal
            document.getElementById('delete-analysis-title').textContent = title;

            // Open the modal using Flowbite
            const modal = new Modal(document.getElementById('confirm-delete-analysis'));
            modal.show();
        }

        // Handle delete confirmation
        document.addEventListener('DOMContentLoaded', function() {
            const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
            const modal = new Modal(document.getElementById('confirm-delete-analysis'));

            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', function() {
                    if (analysisToDelete) {
                        // Close the modal
                        modal.hide();

                        // Disable button while processing
                        confirmDeleteBtn.disabled = true;
                        confirmDeleteBtn.textContent = 'Đang xóa...';

                        // Send DELETE request to the correct route: dashboard/market_analysis/{id}
                        const deleteUrl = `/dashboard/market_analysis/${analysisToDelete}`;
                        console.log('Delete URL:', deleteUrl, 'Analysis ID:', analysisToDelete); // Debug info

                        fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                if (typeof window.showToast === 'function') {
                                    window.showToast(data.message || 'Xóa bản phân tích thành công!', 'success');
                                } else {
                                    alert(data.message || 'Xóa bản phân tích thành công!');
                                }

                                // Remove the item from the UI
                                const item = document.querySelector(`button[onclick*="deleteAnalysis(${analysisToDelete}"]`).closest('.bg-white.border');
                                if (item) {
                                    item.remove();
                                }

                                // Check if there are any items left and refresh if empty
                                const remainingItems = document.querySelectorAll('.space-y-4 > .bg-white.border');
                                if (remainingItems.length === 0) {
                                    location.reload();
                                }
                            } else {
                                // Show error message
                                if (typeof window.showToast === 'function') {
                                    window.showToast(data.message || 'Có lỗi xảy ra khi xóa bản phân tích', 'error');
                                } else {
                                    alert(data.message || 'Có lỗi xảy ra khi xóa bản phân tích');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Delete error:', error);
                            alert(error.message || 'Có lỗi xảy ra khi xóa bản phân tích. Vui lòng thử lại.');
                        })
                        .finally(() => {
                            // Reset button
                            confirmDeleteBtn.disabled = false;
                            confirmDeleteBtn.textContent = 'Đúng, xóa nó!';

                            // Reset global variables
                            analysisToDelete = null;
                            analysisTitle = '';
                        });
                    }
                });
            }
        });

        function toggleExportMenuSidebar(analysisId) {
            const menu = document.getElementById(`sidebar-export-menu-${analysisId}`);

            // Close other menus
            document.querySelectorAll('[id^="sidebar-export-menu-"]').forEach(m => {
                if (m.id !== `sidebar-export-menu-${analysisId}`) {
                    m.classList.add('hidden');
                }
            });

            // Toggle current menu and position it
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                // Position menu to the left of the button
                const button = event.target.closest('button');
                const rect = button.getBoundingClientRect();
                menu.style.left = (rect.left - menu.offsetWidth - 10) + 'px';
                menu.style.top = rect.top + 'px';
            } else {
                menu.classList.add('hidden');
            }
        }

        // Close menus when clicking outside
        document.addEventListener('click', function(event) {
            // Close main export menus
            if (!event.target.closest('[onclick*="toggleExportMenu"]') && !event.target.closest('[id^="export-menu-"]')) {
                document.querySelectorAll('[id^="export-menu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }

            // Close sidebar export menus
            if (!event.target.closest('[onclick*="toggleExportMenuSidebar"]') && !event.target.closest('[id^="sidebar-export-menu-"]')) {
                document.querySelectorAll('[id^="sidebar-export-menu-"]').forEach(menu => {
                    menu.classList.add('hidden');
                });
            }
        });

        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar-history');
            const toggleBtn = document.getElementById('toggle-sidebar');
            const toggleIcon = toggleBtn.querySelector('svg');
            let isCollapsed = false;

            function toggleSidebar() {
                isCollapsed = !isCollapsed;

                if (isCollapsed) {
                    // Collapse sidebar
                    sidebar.classList.add('w-12');
                    sidebar.classList.remove('w-96');
                    toggleBtn.setAttribute('title', 'Mở rộng sidebar');

                    // Rotate icon
                    toggleIcon.classList.remove('rotate-180');
                    toggleIcon.classList.add('rotate-0');

                    // Hide content
                    sidebar.querySelector('.flex-1.overflow-y-auto.p-4').classList.add('hidden');
                    sidebar.querySelector('.p-4.bg-gradient-to-r.from-primary-50.to-blue-50').classList.add('p-2');
                    sidebar.querySelector('h3').classList.add('hidden');
                    sidebar.querySelector('p').classList.add('hidden');

                    // Show only icon
                    const iconContainer = document.createElement('div');
                    iconContainer.className = 'flex items-center justify-center h-full cursor-pointer';
                    iconContainer.innerHTML = `
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    `;
                    iconContainer.addEventListener('click', toggleSidebar);
                    sidebar.appendChild(iconContainer);
                } else {
                    // Expand sidebar
                    sidebar.classList.add('w-96');
                    sidebar.classList.remove('w-12');
                    toggleBtn.setAttribute('title', 'Thu nhỏ sidebar');

                    // Reset icon rotation
                    toggleIcon.classList.remove('rotate-0');
                    toggleIcon.classList.add('rotate-180');

                    // Show content
                    sidebar.querySelector('.p-4.bg-gradient-to-r.from-primary-50.to-blue-50').classList.remove('p-2');
                    sidebar.querySelector('h3').classList.remove('hidden');
                    sidebar.querySelector('p').classList.remove('hidden');
                    sidebar.querySelector('.flex-1.overflow-y-auto.p-4').classList.remove('hidden');

                    // Remove icon container
                    const iconContainer = sidebar.querySelector('.flex.items-center.justify-center.h-full');
                    if (iconContainer) {
                        iconContainer.remove();
                    }
                }
            }

            toggleBtn.addEventListener('click', toggleSidebar);
        });
    </script>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }

        .animate-fade-in:nth-child(1) { animation-delay: 0.1s; }
        .animate-fade-in:nth-child(2) { animation-delay: 0.2s; }
        .animate-fade-in:nth-child(3) { animation-delay: 0.3s; }
        .animate-fade-in:nth-child(4) { animation-delay: 0.4s; }
        .animate-fade-in:nth-child(5) { animation-delay: 0.5s; }
        .animate-fade-in:nth-child(6) { animation-delay: 0.6s; }
        .animate-fade-in:nth-child(7) { animation-delay: 0.7s; }
        .animate-fade-in:nth-child(8) { animation-delay: 0.8s; }
        .animate-fade-in:nth-child(9) { animation-delay: 0.9s; }
        .animate-fade-in:nth-child(10) { animation-delay: 1.0s; }
    </style>

    <!-- Delete Confirmation Modal -->
    <div id="confirm-delete-analysis" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white absolute top-2 right-2" data-modal-hide="confirm-delete-analysis">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Bạn có chắc muốn xóa bản phân tích "<span id="delete-analysis-title" class="font-semibold text-gray-900"></span>"?</h3>
                    <form action="#" method="POST" id="delete-form" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirm-delete-btn" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Đúng, xóa nó!
                        </button>
                    </form>
                    <button data-modal-hide="confirm-delete-analysis" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Hủy</button>
                </div>
            </div>
        </div>
    </div>
</x-app-dashboard>
