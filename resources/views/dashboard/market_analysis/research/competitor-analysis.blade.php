{{-- resources/views/research/competitor-analysis.blade.php --}}
<div class="p-6 bg-white rounded-2xl shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Phân tích đối thủ</h2>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-gray-600 border border-gray-200 rounded-lg">
            <thead class="bg-gray-100 text-gray-800">
                <tr>
                    <th class="px-4 py-3">Tên đối thủ</th>
                    <th class="px-4 py-3">URL</th>
                    <th class="px-4 py-3">Điểm mạnh</th>
                    <th class="px-4 py-3">Điểm yếu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($data['competitors'] ?? [] as $competitor)
                    <tr>
                        <td class="px-4 py-3 font-semibold text-gray-900">
                            {{ $competitor['name'] }}
                        </td>
                        <td class="px-4 py-3 text-blue-600">
                            <a href="{{ $competitor['url'] }}" target="_blank" class="hover:underline">
                                {{ $competitor['url'] }}
                            </a>
                        </td>
                        <td class="px-4 py-3">
                            <ul class="list-disc list-inside">
                                @foreach($competitor['strengths'] as $strength)
                                    <li>{{ $strength }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="px-4 py-3">
                            <ul class="list-disc list-inside">
                                @foreach($competitor['weaknesses'] as $weakness)
                                    <li>{{ $weakness }}</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-4">
                            Không có dữ liệu đối thủ
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <p class="font-semibold text-gray-700">Đề xuất cải thiện:</p>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-2 text-gray-700">
            {!! nl2br(e($data['recommendations'] ?? 'Chưa có dữ liệu')) !!}
        </div>
    </div>
</div>
