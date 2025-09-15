{{-- resources/views/research/consumer-analysis.blade.php --}}
<div class="p-6 bg-white rounded-2xl shadow space-y-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Phân tích người tiêu dùng</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Thông tin cơ bản -->
        <div class="space-y-4">
            <div>
                <p class="font-semibold text-gray-700">Độ tuổi</p>
                <p class="text-gray-600">{{ $data['data']['age_range'] ?? 'Chưa có dữ liệu' }}</p>
            </div>

            <div>
                <p class="font-semibold text-gray-700">Thu nhập</p>
                <p class="text-gray-600">{{ $data['data']['income'] ?? 'Chưa có dữ liệu' }}</p>
            </div>

            <div>
                <p class="font-semibold text-gray-700">Sở thích</p>
                <p class="text-gray-600">{{ $data['data']['interests'] ?? 'Chưa có dữ liệu' }}</p>
            </div>
        </div>

        <!-- Hành vi tiêu dùng -->
        <div class="space-y-4">
            <div>
                <p class="font-semibold text-gray-700">Hành vi tiêu dùng</p>
                <ul class="list-disc list-inside text-gray-600">
                    @forelse($data['data']['behaviors'] ?? [] as $behavior)
                        <li>{{ $behavior }}</li>
                    @empty
                        <li>Chưa có dữ liệu</li>
                    @endforelse
                </ul>
            </div>

            <div>
                <p class="font-semibold text-gray-700">Vấn đề khách hàng gặp phải (Pain Points)</p>
                <ul class="list-disc list-inside text-gray-600">
                    @forelse($data['data']['pain_points'] ?? [] as $pain)
                        <li>{{ $pain }}</li>
                    @empty
                        <li>Chưa có dữ liệu</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Gợi ý chiến lược -->
    <div class="mt-6">
        <p class="font-semibold text-gray-700">Chiến lược Marketing đề xuất:</p>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-2 text-gray-700">
            {!! nl2br(e($data['marketing_strategy'] ?? 'Chưa có dữ liệu')) !!}
        </div>
    </div>
</div>
