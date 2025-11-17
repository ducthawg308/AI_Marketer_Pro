<x-app-dashboard>
    <div class="container mx-auto px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-primary-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white flex-shrink-0 group-hover:text-gray-900 transition duration-75"
                                fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                            </svg>
                        </div>
                        Nghiên cứu thị trường
                    </h1>
                    <p class="text-gray-600">Phân tích dữ liệu thị trường và đối thủ cạnh tranh một cách chi tiết</p>
                </div>
                <button class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-200 flex items-center space-x-2 hover:shadow-xl transform hover:scale-105">
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
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v3.586a1 1 0 01-.293.707l-2 2A1 1 0 0110 21v-5.586a1 1 0 00-.293-.707L3.293 8.293A1 1 0 013 7.586V4z"></path>
                        </svg>
                    </div>
                    Bộ lọc nghiên cứu
                </h2>
                <p class="text-gray-600 mt-1">Chọn thông số để thực hiện phân tích thị trường chi tiết</p>
            </div>

            <div class="p-8">
                <form id="marketAnalysisForm" class="space-y-8">
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
                                    class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300 hover:shadow-md">
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
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300 hover:shadow-md">
                                    </div>

                                    <!-- Ngày kết thúc -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Ngày kết thúc
                                        </label>
                                        <input type="date" name="end_date" 
                                            class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 shadow-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200 hover:border-primary-300 hover:shadow-md">
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Date Presets -->
                            <div class="grid grid-cols-2 gap-3">
                                <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 border border-gray-300 hover:shadow-md">
                                    7 ngày qua
                                </button>
                                <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 border border-gray-300 hover:shadow-md">
                                    30 ngày qua
                                </button>
                                <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 border border-gray-300 hover:shadow-md">
                                    3 tháng qua
                                </button>
                                <button type="button" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-gray-700 transition-all duration-200 border border-gray-300 hover:shadow-md">
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

        <!-- JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('marketAnalysisForm');
                const analyzeButton = document.getElementById('analyzeButton');
                const analyzeIcon = document.getElementById('analyzeIcon');
                const analyzeText = document.getElementById('analyzeText');
                const startDateInput = document.querySelector('input[name="start_date"]');
                const endDateInput = document.querySelector('input[name="end_date"]');
                const presetButtons = document.querySelectorAll('.grid button');
                
                // States
                const waitingState = document.getElementById('waitingState');
                const loadingState = document.getElementById('loadingState');
                const analysisResult = document.getElementById('analysisResult');
                const errorState = document.getElementById('errorState');

                // Date preset functionality
                function formatDate(date) {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                }

                function setDateRange(days) {
                    const endDate = new Date();
                    const startDate = new Date();
                    startDate.setDate(endDate.getDate() - days);

                    startDateInput.value = formatDate(startDate);
                    endDateInput.value = formatDate(endDate);
                }

                presetButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const presetText = this.textContent.trim();
                        let days;

                        switch(presetText) {
                            case '7 ngày qua':
                                days = 7;
                                break;
                            case '30 ngày qua':
                                days = 30;
                                break;
                            case '3 tháng qua':
                                days = 90;
                                break;
                            case '1 năm qua':
                                days = 365;
                                break;
                        }

                        setDateRange(days);

                        presetButtons.forEach(btn => btn.classList.remove('bg-primary-200', 'text-primary-800'));
                        this.classList.add('bg-primary-200', 'text-primary-800');
                    });
                });

                // Set default date range
                setDateRange(30);

                // Form submission with AJAX
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(form);
                    
                    // Show loading state
                    showLoading();
                    
                    // Make AJAX request
                    fetch('{{ route('dashboard.market_analysis.analyze') }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
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

                    // Re-initialize any charts after AJAX load
                    initializeCharts();
                }

                // Function to initialize charts after content is loaded
                function initializeCharts() {
                    // Wait for the DOM to be fully loaded after AJAX insertion
                    setTimeout(function() {
                        const charts = analysisResult.querySelectorAll('canvas[id*="Chart"]');
                        if (charts.length > 0) {
                            // Load Chart.js if not already loaded
                            if (typeof Chart === 'undefined') {
                                const script = document.createElement('script');
                                script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
                                script.onload = function() {
                                    console.log('Chart.js loaded for AJAX content');
                                    // Re-run chart initialization for the new content
                                    initializeChartForElement(analysisResult);
                                };
                                document.head.appendChild(script);
                            } else {
                                console.log('Chart.js already available, initializing chart');
                                initializeChartForElement(analysisResult);
                            }
                        }
                    }, 100); // Small delay to ensure DOM is ready
                }

                // Function to initialize charts within a specific container
                function initializeChartForElement(container) {
                    try {
                        const chartCanvas = container.querySelector('#marketTrendChart');
                        if (chartCanvas && typeof Chart !== 'undefined') {
                            // Extract chart data from the server-rendered JSON
                            const chartDataScript = container.querySelector('script[type="application/json"]') ||
                                                   container.textContent;

                            // Try to find chart data as JSON
                            let chartData = null;
                            const jsonScript = container.querySelector('#chartDataJson');
                            if (jsonScript) {
                                try {
                                    const jsonText = jsonScript.textContent.trim();
                                    if (jsonText) {
                                        chartData = JSON.parse(jsonText);
                                        console.log('Chart data parsed successfully from JSON script:', Object.keys(chartData || {}));
                                    }
                                } catch (e) {
                                    console.warn('Could not parse chart data from JSON script:', e.message);
                                }
                            }

                            // Fallback: try parsing from inline script (for backwards compatibility)
                            if (!chartData && chartDataScript) {
                                try {
                                    const scriptMatch = chartDataScript.textContent.match(/!!\s*json_encode\((.*?)\)\s*!!/);
                                    if (scriptMatch) {
                                        chartData = JSON.parse(scriptMatch[1]);
                                    }
                                } catch (e) {
                                    console.warn('Could not parse chart data from inline script');
                                }
                            }

                            if (!chartData) {
                                console.error('Chart data not found in AJAX response');
                                return;
                            }

                            const labels = chartData.labels || [];
                            const marketGrowth = chartData.market_growth_index || [];
                            const consumerInterest = chartData.consumer_interest_index || [];
                            const actualData = chartData.actual_data || [];
                            const forecastData = chartData.forecast_data || [];
                            const trendIndicators = chartData.trend_indicators || [];

                            console.log('Re-initializing chart with data:', {
                                labels: labels.length,
                                marketGrowth: marketGrowth.length,
                                consumerInterest: consumerInterest.length,
                                actual: actualData.length,
                                forecast: forecastData.length,
                                indicators: trendIndicators.length
                            });

                            if (labels.length === 0) {
                                console.error('No chart labels found in AJAX response');
                                return;
                            }

                            // Get 2D context (or clear existing chart)
                            let chartCtx = chartCanvas.getContext('2d');

                            // Destroy existing chart if it exists
                            if (chartCanvas.chart) {
                                chartCanvas.chart.destroy();
                            }

                            // Create gradients
                            const growthGradient = chartCtx.createLinearGradient(0, 0, 0, 400);
                            growthGradient.addColorStop(0, 'rgba(34, 197, 94, 0.3)');
                            growthGradient.addColorStop(1, 'rgba(34, 197, 94, 0.05)');

                            const interestGradient = chartCtx.createLinearGradient(0, 0, 0, 400);
                            interestGradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
                            interestGradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

                            // Prepare combined dataset with actual/forecast logic
                            const marketGrowthDataset = [];
                            const consumerInterestDataset = [];

                            // Combine actual and forecast data for each index
                            labels.forEach((label, index) => {
                                // For market growth - use actual data if available, forecast if not
                                const growthValue = actualData[index] !== undefined && actualData[index] !== null
                                    ? actualData[index]
                                    : (forecastData[index] !== undefined ? forecastData[index] : marketGrowth[index]);

                                marketGrowthDataset.push({
                                    x: index,
                                    y: growthValue,
                                    label: label,
                                    isForecast: forecastData[index] !== undefined && forecastData[index] !== null,
                                    indicator: trendIndicators[index] || ''
                                });

                                // Consumer interest data
                                consumerInterestDataset.push({
                                    x: index,
                                    y: consumerInterest[index],
                                    label: label,
                                    isForecast: false,
                                    indicator: trendIndicators[index] || ''
                                });
                            });

                            // Create chart
                            chartCanvas.chart = new Chart(chartCtx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [
                                        {
                                            label: 'Chỉ số tăng trưởng thị trường',
                                            data: marketGrowthDataset,
                                            yAxisID: 'y',
                                            borderColor: 'rgba(34, 197, 94, 1)',
                                            backgroundColor: growthGradient,
                                            borderWidth: 3,
                                            fill: true,
                                            tension: 0.4,
                                            pointBackgroundColor: function(context) {
                                                const point = context.parsed;
                                                if (point && marketGrowthDataset[context.dataIndex]?.isForecast) {
                                                    return 'rgba(239, 68, 68, 1)'; // Red for forecast
                                                }
                                                return 'rgba(34, 197, 94, 1)'; // Green for actual
                                            },
                                            pointBorderColor: '#ffffff',
                                            pointBorderWidth: 3,
                                            pointRadius: 6,
                                            pointHoverRadius: 8,
                                            pointHoverBorderColor: '#ffffff',
                                            pointHoverBorderWidth: 3,
                                            spanGaps: true
                                        },
                                        {
                                            label: 'Mức độ quan tâm người tiêu dùng',
                                            data: consumerInterestDataset,
                                            yAxisID: 'y',
                                            borderColor: 'rgba(59, 130, 246, 1)',
                                            backgroundColor: interestGradient,
                                            borderWidth: 2,
                                            borderDash: [5, 5],
                                            fill: true,
                                            tension: 0.4,
                                            pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                                            pointBorderColor: '#ffffff',
                                            pointBorderWidth: 2,
                                            pointRadius: 5,
                                            pointHoverRadius: 7,
                                            pointHoverBorderColor: '#ffffff',
                                            pointHoverBorderWidth: 2,
                                            spanGaps: true
                                        }
                                    ]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    interaction: {
                                        mode: 'index',
                                        intersect: false
                                    },
                                    plugins: {
                                        title: {
                                            display: false
                                        },
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            enabled: true,
                                            mode: 'index',
                                            intersect: false,
                                            backgroundColor: 'rgba(0, 0, 0, 0.9)',
                                            titleColor: '#ffffff',
                                            bodyColor: '#ffffff',
                                            borderColor: 'rgba(255, 255, 255, 0.1)',
                                            borderWidth: 1,
                                            cornerRadius: 12,
                                            displayColors: true,
                                            titleFont: {
                                                size: 14,
                                                weight: 'bold'
                                            },
                                            bodyFont: {
                                                size: 13
                                            },
                                            padding: 12,
                                            caretPadding: 8,
                                            callbacks: {
                                                title: function(context) {
                                                    return 'Thời điểm: ' + context[0].label;
                                                },
                                                label: function(context) {
                                                    let label = context.dataset.label || '';
                                                    if (label) {
                                                        label += ': ';
                                                    }
                                                    if (context.parsed.y !== null) {
                                                        label += new Intl.NumberFormat('vi-VN', {
                                                            style: 'decimal',
                                                            minimumFractionDigits: 0,
                                                            maximumFractionDigits: 2
                                                        }).format(context.parsed.y);
                                                    }
                                                    return label;
                                                },
                                                afterBody: function(context) {
                                                    if (context.length > 0) {
                                                        const dataIndex = context[0].dataIndex;
                                                        const forecastValues = chartData.forecast_data || [];
                                                        if (forecastValues[dataIndex] !== null) {
                                                            return ['', '⚠️ Dữ liệu dự báo - có thể thay đổi'];
                                                        }
                                                    }
                                                    return [];
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Thời gian',
                                                font: {
                                                    size: 14,
                                                    weight: 'bold'
                                                },
                                                color: '#374151'
                                            },
                                            grid: {
                                                display: true,
                                                color: 'rgba(0, 0, 0, 0.05)',
                                                drawBorder: false
                                            },
                                            ticks: {
                                                maxRotation: 45,
                                                minRotation: 0,
                                                font: {
                                                    size: 12
                                                },
                                                color: '#6B7280',
                                                padding: 8
                                            },
                                            border: {
                                                display: false
                                            }
                                        },
                                        y: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Giá trị chỉ số',
                                                font: {
                                                    size: 14,
                                                    weight: 'bold'
                                                },
                                                color: '#374151'
                                            },
                                            grid: {
                                                display: true,
                                                color: 'rgba(0, 0, 0, 0.05)',
                                                drawBorder: false
                                            },
                                            ticks: {
                                                callback: function(value, index, values) {
                                                    return new Intl.NumberFormat('vi-VN', {
                                                        notation: 'compact',
                                                        compactDisplay: 'short'
                                                    }).format(value);
                                                },
                                                font: {
                                                    size: 12
                                                },
                                                color: '#6B7280',
                                                padding: 8
                                            },
                                            border: {
                                                display: false
                                            },
                                            beginAtZero: false
                                        }
                                    },
                                    elements: {
                                        point: {
                                            hoverBackgroundColor: 'rgba(255, 255, 255, 1)'
                                        },
                                        line: {
                                            borderJoinStyle: 'round',
                                            borderCapStyle: 'round'
                                        }
                                    },
                                    animation: {
                                        duration: 2000,
                                        easing: 'easeInOutQuart',
                                        onProgress: function(animation) {
                                            if (animation.currentStep === 0) {
                                                console.log('Chart animation started (AJAX)');
                                            }
                                        },
                                        onComplete: function() {
                                            console.log('Chart loaded successfully (AJAX)');
                                        }
                                    },
                                    onHover: (event, activeElements) => {
                                        event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                                    }
                                }
                            });

                            console.log('Chart re-initialization completed successfully');

                        } else {
                            console.warn('Chart canvas not found or Chart.js not available');
                        }
                    } catch (error) {
                        console.error('Error re-initializing chart from AJAX:', error);
                        // Fallback: show error message in chart container
                        const chartContainer = container.querySelector('.relative');
                        if (chartContainer) {
                            chartContainer.innerHTML = '<div class="text-center py-8"><div class="bg-red-50 rounded-lg p-4 border border-red-200"><p class="text-red-700 font-medium">Không thể tải biểu đồ</p><p class="text-red-500 text-sm mt-1">Vui lòng thử lại sau hoặc kiểm tra console để biết chi tiết lỗi</p></div></div>';
                        }
                    }
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
        </script>
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
        
        /* Loading spinner animation */
        .animate-spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
    </style>
</x-app-dashboard>
