{{-- resources/views/market_analysis/research/competitor-analysis.blade.php --}}
<div class="p-6 bg-white rounded-2xl shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Phân tích Đối thủ Cạnh tranh</h2>

    {{-- Kiểm tra nếu có dữ liệu competitors --}}
    @if(!empty($data['data']['competitors']))
        <div class="mb-8">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Đối thủ cạnh tranh</h3>
            <div class="space-y-6">
                @foreach($data['data']['competitors'] as $competitor)
                    <div class="border rounded-xl p-5 hover:shadow-md transition">
                        {{-- Tên và link của đối thủ --}}
                        <h4 class="text-lg font-bold text-primary-600 mb-3">
                            <a href="{{ $competitor['url'] }}" target="_blank" class="hover:underline">
                                {{ $competitor['name'] }}
                            </a>
                        </h4>

                        {{-- Strengths --}}
                        @if(!empty($competitor['strengths']))
                            <div class="mb-3">
                                <h5 class="font-semibold text-green-600 mb-2">Điểm mạnh:</h5>
                                <ul class="list-disc pl-6 space-y-1 text-gray-700">
                                    @foreach($competitor['strengths'] as $strength)
                                        <li>{{ $strength }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Weaknesses --}}
                        @if(!empty($competitor['weaknesses']))
                            <div>
                                <h5 class="font-semibold text-red-600 mb-2">Điểm yếu:</h5>
                                <ul class="list-disc pl-6 space-y-1 text-gray-700">
                                    @foreach($competitor['weaknesses'] as $weakness)
                                        <li>{{ $weakness }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-500 italic">Không có dữ liệu đối thủ cạnh tranh.</p>
    @endif

    {{-- Phần chiến lược đề xuất --}}
    @if(!empty($data['data']['strategy']))
        <div>
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Chiến lược đề xuất</h3>
            <div class="space-y-5">
                @foreach($data['data']['strategy'] as $item)
                    <div class="p-5 border rounded-lg bg-gray-50 hover:bg-gray-100 transition">
                        <h4 class="font-bold text-gray-800 mb-2">{{ $item['title'] }}</h4>
                        <p class="text-gray-700">{{ $item['content'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-gray-500 italic">Không có dữ liệu chiến lược đề xuất.</p>
    @endif
</div>
