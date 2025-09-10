<x-app-dashboard>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <!-- Replaced fa-chart-line with SVG -->
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        Nghiên cứu thị trường
                    </h1>
                    <p class="text-gray-600">Phân tích dữ liệu thị trường và đối thủ cạnh tranh một cách chi tiết</p>
                </div>
                <button class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center space-x-2 hover:shadow-xl transform hover:scale-105">
                    <!-- Replaced fa-download with SVG -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    <span>Xuất báo cáo</span>
                </button>
            </div>
        </div>

        <!-- Bộ lọc nghiên cứu -->
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-primary-50 to-blue-50 p-6 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900 flex items-center">
                    <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center mr-3">
                        <!-- Replaced fa-filter with SVG -->
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v3.586a1 1 0 01-.293.707l-2 2A1 1 0 0110 21v-5.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z"></path>
                        </svg>
                    </div>
                    Bộ lọc nghiên cứu
                </h2>
                <p class="text-gray-600 mt-1">Chọn thông số để thực hiện phân tích thị trường chi tiết</p>
            </div>

            <div class="p-6">
                <form method="POST" action="#" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Đối tượng mục tiêu -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center">
                                Đối tượng mục tiêu
                            </label>
                            <select id="audienceTarget" name="audience_target" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300">
                                <option value="">Chọn đối tượng</option>
                                <option value="1">Màn hình Gaming ASUS</option>
                                <option value="2">Laptop Gaming MSI</option>
                            </select>
                        </div>

                        <!-- Ngày bắt đầu -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center">
                                Ngày bắt đầu
                            </label>
                            <input type="date" name="start_date" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300">
                        </div>

                        <!-- Ngày kết thúc -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center">
                                Ngày kết thúc
                            </label>
                            <input type="date" name="end_date" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300">
                        </div>

                        <!-- Loại nghiên cứu -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700 flex items-center">
                                Loại nghiên cứu
                            </label>
                            <select id="researchType" name="research_type" 
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300" required>
                                <option value="consumer">
                                    <!-- Replaced fa-users with SVG -->
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    Phân tích người tiêu dùng
                                </option>
                                <option value="competitor">
                                    <!-- Replaced fa-chess with SVG -->
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                    Phân tích đối thủ
                                </option>
                                <option value="trend">
                                    <!-- Replaced fa-trending-up with SVG -->
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    Xu hướng thị trường
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Nút phân tích -->
                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" 
                            class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white px-8 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center space-x-2 hover:shadow-xl transform hover:scale-105 font-medium">
                            <!-- Replaced fa-chart-line with SVG -->
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                            <span>Phân tích thị trường</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Kết quả phân tích - chỉ hiển thị nếu có data từ controller -->
        @if (isset($type) && isset($data))
            <div id="analysisResult" class="animate-fade-in">
                <!-- Header kết quả -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200 mb-6 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-6">
                        <h3 class="text-2xl font-bold text-gray-900 flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <!-- Replaced fa-chart-bar with SVG -->
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                            Kết quả phân tích
                        </h3>
                        <p class="text-gray-600 mt-1">Dữ liệu được cập nhật theo thời gian thực</p>
                    </div>
                    
                    <!-- Tabs cho các loại phân tích -->
                    <div class="border-b border-gray-200">
                        <nav class="flex px-6">
                            <button class="py-4 px-6 border-b-2 border-primary-500 text-primary-600 font-medium text-sm flex items-center space-x-2">
                                <!-- Replaced fa-chart-pie with SVG -->
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                                <span>
                                    @if($type == 'consumer') Người tiêu dùng
                                    @elseif($type == 'competitor') Đối thủ cạnh tranh
                                    @else Xu hướng thị trường
                                    @endif
                                </span>
                            </button>
                        </nav>
                    </div>

                    <div class="p-6">
                        @include("market_analysis.research.{$type}-analysis", ['data' => $data])
                    </div>
                </div>
            </div>
        @else
            <!-- Trạng thái chờ phân tích -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-12 text-center">
                <div class="w-24 h-24 bg-gradient-to-r from-primary-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <!-- Replaced fa-chart-line with SVG -->
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
                            <!-- Replaced fa-users with SVG -->
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Phân tích người dùng</h4>
                        <p class="text-sm text-gray-600">Hiểu rõ hành vi và sở thích của khách hàng mục tiêu</p>
                    </div>
                    
                    <div class="bg-blue-50 p-6 rounded-lg">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <!-- Replaced fa-chess with SVG -->
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Nghiên cứu đối thủ</h4>
                        <p class="text-sm text-gray-600">Phân tích chiến lược và điểm mạnh của các đối thủ</p>
                    </div>
                    
                    <div class="bg-purple-50 p-6 rounded-lg">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <!-- Replaced fa-trending-up with SVG -->
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-900 mb-2">Xu hướng thị trường</h4>
                        <p class="text-sm text-gray-600">Nắm bắt các xu hướng và cơ hội mới nhất</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.5s ease-out;
        }
        
        /* Hover effects for form elements */
        select:hover, input[type="date"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        /* Custom scrollbar for better UX */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #1e9c5a;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #1a804b;
        }
    </style>
</x-app-dashboard>