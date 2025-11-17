{{-- resources/views/research/consumer-analysis.blade.php --}}
<div class="bg-white rounded-3xl shadow-xl overflow-hidden">
    <!-- Export Actions -->
    <div class="p-4 bg-gray-50 border-b flex flex-col sm:flex-row gap-3">
        <div class="flex gap-2">
            <a href="{{ route('dashboard.market_analysis.export', 'pdf') }}"
               class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414l-5-5H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"/>
                </svg>
                Xuất PDF
            </a>
            <a href="{{ route('dashboard.market_analysis.export', 'word') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"/>
                </svg>
                Xuất Word
            </a>
        </div>
        <p class="text-sm text-gray-600 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            Xuất báo cáo từ kết quả phân tích hiện tại
        </p>
    </div>

    <div class="bg-gradient-to-r from-emerald-600 to-teal-600 p-6">
        <h2 class="text-3xl font-bold text-white flex items-center">
            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            Phân tích Người tiêu dùng
        </h2>
        <p class="text-emerald-100 mt-2">Thông tin chi tiết về đối tượng khách hàng mục tiêu</p>
    </div>

    <div class="p-8 space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Thông tin cơ bản -->
            <div class="space-y-6">
                <div class="flex items-center mb-6">
                    <div class="w-2 h-8 bg-gradient-to-b from-emerald-500 to-teal-500 rounded-full mr-4"></div>
                    <h3 class="text-xl font-bold text-gray-800">Thông tin cơ bản</h3>
                </div>

                <div class="group bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border-2 border-blue-100 hover:shadow-lg hover:border-blue-200 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-blue-800 text-lg">Độ tuổi mục tiêu</h4>
                            <p class="text-blue-600 text-sm">Phân khúc khách hàng theo độ tuổi</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-60 rounded-xl p-4 border border-blue-100">
                        <p class="text-blue-800 font-semibold text-lg">{{ $data['data']['age_range'] ?? 'Chưa có dữ liệu' }}</p>
                    </div>
                </div>

                <div class="group bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-6 border-2 border-green-100 hover:shadow-lg hover:border-green-200 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-green-800 text-lg">Thu nhập</h4>
                            <p class="text-green-600 text-sm">Mức thu nhập trung bình</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-60 rounded-xl p-4 border border-green-100">
                        <p class="text-green-800 font-semibold text-lg">{{ $data['data']['income'] ?? 'Chưa có dữ liệu' }}</p>
                    </div>
                </div>

                <div class="group bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl p-6 border-2 border-purple-100 hover:shadow-lg hover:border-purple-200 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-purple-800 text-lg">Sở thích</h4>
                            <p class="text-purple-600 text-sm">Quan tâm và sở thích chính</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-60 rounded-xl p-4 border border-purple-100">
                        @if(!empty($data['data']['interests']) && is_array($data['data']['interests']))
                            <div class="flex flex-wrap gap-2">
                                @foreach($data['data']['interests'] as $interest)
                                    <span class="inline-flex items-center bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 text-sm font-medium px-4 py-2 rounded-full border border-purple-200 hover:shadow-md transition-all">
                                        <span class="w-2 h-2 bg-purple-500 rounded-full mr-2"></span>
                                        {{ $interest }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-purple-800 font-semibold">{{ is_string($data['data']['interests'] ?? null) ? $data['data']['interests'] : 'Chưa có dữ liệu' }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hành vi và vấn đề -->
            <div class="space-y-6">
                <div class="flex items-center mb-6">
                    <div class="w-2 h-8 bg-gradient-to-b from-orange-500 to-red-500 rounded-full mr-4"></div>
                    <h3 class="text-xl font-bold text-gray-800">Hành vi & Thách thức</h3>
                </div>

                <div class="group bg-gradient-to-br from-orange-50 to-amber-50 rounded-2xl p-6 border-2 border-orange-100 hover:shadow-lg hover:border-orange-200 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-orange-500 to-amber-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-orange-800 text-lg">Hành vi tiêu dùng</h4>
                            <p class="text-orange-600 text-sm">Thói quen và hành vi mua sắm</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-60 rounded-xl p-4 border border-orange-100">
                        @if(!empty($data['data']['behaviors']) && is_array($data['data']['behaviors']))
                            <ul class="space-y-3">
                                @foreach($data['data']['behaviors'] as $behavior)
                                    <li class="flex items-start text-orange-800">
                                        <div class="w-2 h-2 bg-orange-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                        <span class="leading-relaxed">{{ $behavior }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-orange-700 italic text-center py-4">Chưa có dữ liệu về hành vi tiêu dùng</p>
                        @endif
                    </div>
                </div>

                <div class="group bg-gradient-to-br from-red-50 to-pink-50 rounded-2xl p-6 border-2 border-red-100 hover:shadow-lg hover:border-red-200 transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-gradient-to-r from-red-500 to-pink-500 rounded-xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-red-800 text-lg">Vấn đề khách hàng gặp phải</h4>
                            <p class="text-red-600 text-sm">Pain Points cần giải quyết</p>
                        </div>
                    </div>
                    <div class="bg-white bg-opacity-60 rounded-xl p-4 border border-red-100">
                        @if(!empty($data['data']['pain_points']) && is_array($data['data']['pain_points']))
                            <ul class="space-y-3">
                                @foreach($data['data']['pain_points'] as $pain)
                                    <li class="flex items-start text-red-800">
                                        <div class="w-2 h-2 bg-red-500 rounded-full mt-2 mr-3 flex-shrink-0"></div>
                                        <span class="leading-relaxed">{{ $pain }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-red-700 italic text-center py-4">Chưa có dữ liệu về vấn đề khách hàng</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Gợi ý chiến lược Marketing -->
        @if(!empty($data['data']['recommendations']) && is_array($data['data']['recommendations']))
            <div class="border-t-2 border-gray-100 pt-8">
                <div class="flex items-center mb-8">
                    <div class="w-2 h-8 bg-gradient-to-b from-indigo-500 to-blue-500 rounded-full mr-4"></div>
                    <h3 class="text-2xl font-bold text-gray-800">Chiến lược Marketing đề xuất</h3>
                    <span class="ml-auto bg-indigo-100 text-indigo-800 px-4 py-2 rounded-full text-sm font-medium">
                        {{ count($data['data']['recommendations']) }} chiến lược
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($data['data']['recommendations'] as $index => $recommendation)
                        <div class="group relative bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-50 border-2 border-indigo-100 rounded-2xl p-6 hover:shadow-2xl hover:border-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
                            {{-- Strategy number badge --}}
                            <div class="absolute -top-3 -right-3 w-8 h-8 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-full flex items-center justify-center shadow-lg">
                                <span class="text-white text-sm font-bold">{{ $index + 1 }}</span>
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center mb-3">
                                    <svg class="w-6 h-6 text-indigo-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <h4 class="text-xl font-bold text-indigo-800 group-hover:text-indigo-900 transition-colors">
                                        {{ $recommendation['title'] ?? 'Chiến lược Marketing' }}
                                    </h4>
                                </div>
                            </div>

                            <div class="bg-white bg-opacity-70 rounded-xl p-4 border border-indigo-100">
                                <p class="text-indigo-800 leading-relaxed">
                                    {{ $recommendation['content'] ?? 'Mô tả chiến lược' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @elseif(!empty($data['data']['marketing_strategy']))
            <!-- Fallback cho format cũ -->
            <div class="border-t-2 border-gray-100 pt-8">
                <div class="flex items-center mb-6">
                    <div class="w-2 h-8 bg-gradient-to-b from-indigo-500 to-blue-500 rounded-full mr-4"></div>
                    <h3 class="text-2xl font-bold text-gray-800">Chiến lược Marketing đề xuất</h3>
                </div>
                
                <div class="bg-gradient-to-br from-indigo-50 via-blue-50 to-cyan-50 border-2 border-indigo-100 rounded-2xl p-8 hover:shadow-lg transition-all duration-300">
                    <div class="bg-white bg-opacity-70 rounded-xl p-6 border border-indigo-100">
                        <div class="prose prose-lg text-gray-700 max-w-none">
                            {!! nl2br(e($data['data']['marketing_strategy'])) !!}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="border-t-2 border-gray-100 pt-8">
                <div class="text-center py-16">
                    <div class="relative mb-6">
                        <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-full w-24 h-24 flex items-center justify-center mx-auto shadow-inner">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-3">Chưa có dữ liệu chiến lược marketing</h3>
                    <p class="text-gray-500">Các chiến lược marketing đề xuất sẽ được hiển thị tại đây khi có sẵn.</p>
                </div>
            </div>
        @endif
    </div>
</div>
