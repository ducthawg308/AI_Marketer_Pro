{{-- resources/views/market_analysis/research/competitor-analysis.blade.php --}}
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

    <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6">
        <h2 class="text-3xl font-bold text-white flex items-center">
            <svg class="w-8 h-8 mr-3" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L13.09 8.26L22 9L13.09 9.74L12 16L10.91 9.74L2 9L10.91 8.26L12 2Z" fill="currentColor" opacity="0.8"/>
                <path d="M19 15L20.09 18.26L24 19L20.09 19.74L19 23L17.91 19.74L14 19L17.91 18.26L19 15Z" fill="currentColor" opacity="0.6"/>
                <path d="M7 15L8.09 18.26L12 19L8.09 19.74L7 23L5.91 19.74L2 19L5.91 18.26L7 15Z" fill="currentColor" opacity="0.6"/>
            </svg>
            Phân tích Đối thủ Cạnh tranh
        </h2>
        <p class="text-blue-100 mt-2">Phân tích chi tiết về đối thủ cạnh tranh và chiến lược đề xuất</p>
    </div>

    <div class="p-8">
        {{-- Kiểm tra nếu có dữ liệu competitors --}}
        @if(!empty($data['data']['competitors']) && is_array($data['data']['competitors']))
            <div class="mb-12">
                <div class="flex items-center mb-6">
                    <div class="w-2 h-8 bg-gradient-to-b from-blue-500 to-purple-500 rounded-full mr-4"></div>
                    <h3 class="text-2xl font-bold text-gray-800">Đối thủ cạnh tranh</h3>
                    <span class="ml-auto bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                        {{ count($data['data']['competitors']) }} đối thủ
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($data['data']['competitors'] as $index => $competitor)
                        <div class="group relative bg-gradient-to-br from-gray-50 to-white border-2 border-gray-100 rounded-2xl p-6 hover:shadow-2xl hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                            {{-- Competitor number badge --}}
                            <div class="absolute -top-3 -right-3 w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">{{ $index + 1 }}</span>
                            </div>

                            {{-- Tên và link của đối thủ --}}
                            <div class="mb-6">
                                <h4 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-600 transition-colors">
                                    @if(!empty($competitor['url']))
                                        <a href="{{ $competitor['url'] }}" target="_blank" class="flex items-center hover:underline">
                                            {{ $competitor['name'] ?? 'Tên đối thủ' }}
                                            <svg class="w-4 h-4 ml-2 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    @else
                                        {{ $competitor['name'] ?? 'Tên đối thủ' }}
                                    @endif
                                </h4>
                            </div>

                            {{-- Strengths --}}
                            @if(!empty($competitor['strengths']) && is_array($competitor['strengths']))
                                <div class="mb-6">
                                    <div class="flex items-center mb-3">
                                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                                        <h5 class="font-bold text-green-700 text-lg">Điểm mạnh</h5>
                                    </div>
                                    <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                                        <ul class="space-y-2">
                                            @foreach($competitor['strengths'] as $strength)
                                                <li class="flex items-start text-green-800">
                                                    <svg class="w-4 h-4 mt-1 mr-2 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span class="leading-relaxed">{{ $strength }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            {{-- Weaknesses --}}
                            @if(!empty($competitor['weaknesses']) && is_array($competitor['weaknesses']))
                                <div>
                                    <div class="flex items-center mb-3">
                                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                        <h5 class="font-bold text-red-700 text-lg">Điểm yếu</h5>
                                    </div>
                                    <div class="bg-red-50 rounded-xl p-4 border border-red-100">
                                        <ul class="space-y-2">
                                            @foreach($competitor['weaknesses'] as $weakness)
                                                <li class="flex items-start text-red-800">
                                                    <svg class="w-4 h-4 mt-1 mr-2 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span class="leading-relaxed">{{ $weakness }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Không có dữ liệu đối thủ --}}
            <div class="text-center py-16 mb-12">
                <div class="relative mb-6">
                    <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-full w-24 h-24 flex items-center justify-center mx-auto shadow-inner">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold text-gray-600 mb-3">Chưa có dữ liệu đối thủ cạnh tranh</h3>
                <p class="text-gray-500">Dữ liệu đối thủ cạnh tranh sẽ được hiển thị tại đây khi có sẵn.</p>
            </div>
        @endif

        {{-- Phần chiến lược đề xuất --}}
        @if(!empty($data['data']['strategy']) && is_array($data['data']['strategy']))
            <div class="border-t border-gray-200 pt-8">
                <div class="flex items-center mb-6">
                    <div class="w-2 h-8 bg-gradient-to-b from-purple-500 to-pink-500 rounded-full mr-4"></div>
                    <h3 class="text-2xl font-bold text-gray-800">Chiến lược đề xuất</h3>
                    <span class="ml-auto bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">
                        {{ count($data['data']['strategy']) }} chiến lược
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($data['data']['strategy'] as $index => $item)
                        <div class="group relative bg-gradient-to-br from-purple-50 via-pink-50 to-indigo-50 border-2 border-purple-100 rounded-2xl p-6 hover:shadow-2xl hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
                            {{-- Strategy number badge --}}
                            <div class="absolute -top-3 -right-3 w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">{{ $index + 1 }}</span>
                            </div>

                            <div class="mb-4">
                                <div class="flex items-center mb-3">
                                    <svg class="w-6 h-6 text-purple-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    <h4 class="text-xl font-bold text-purple-800 group-hover:text-purple-900 transition-colors">
                                        {{ $item['title'] ?? 'Chiến lược' }}
                                    </h4>
                                </div>
                            </div>

                            <div class="bg-white bg-opacity-60 rounded-xl p-4 border border-purple-100">
                                <p class="text-gray-700 leading-relaxed">{{ $item['content'] ?? 'Mô tả chiến lược' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Không có dữ liệu chiến lược --}}
            <div class="border-t border-gray-200 pt-8">
                <div class="text-center py-12">
                    <div class="relative mb-6">
                        <div class="bg-gradient-to-r from-gray-100 to-gray-200 rounded-full w-20 h-20 flex items-center justify-center mx-auto shadow-inner">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-600 mb-3">Chưa có dữ liệu chiến lược</h3>
                    <p class="text-gray-500">Các chiến lược đề xuất sẽ được hiển thị tại đây khi có sẵn.</p>
                </div>
            </div>
        @endif
    </div>
</div>
