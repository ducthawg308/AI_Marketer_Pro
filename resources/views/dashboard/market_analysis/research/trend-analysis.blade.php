{{-- resources/views/research/market-trend.blade.php --}}
<div class="p-6 bg-white rounded-2xl shadow">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Xu hướng thị trường</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Biểu đồ xu hướng -->
        <div class="bg-white rounded-lg shadow p-4">
            <canvas id="marketTrendChart"></canvas>
        </div>

        <!-- Thông tin phân tích -->
        <div class="space-y-4">
            <p class="font-semibold text-gray-700">Nhận định thị trường:</p>
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-gray-700">
                {!! nl2br(e($data['analysis'] ?? 'Chưa có dữ liệu')) !!}
            </div>

            <p class="font-semibold text-gray-700">Dự đoán xu hướng:</p>
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-gray-700">
                {!! nl2br(e($data['forecast'] ?? 'Chưa có dữ liệu')) !!}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('marketTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($data['labels'] ?? []) !!},
            datasets: [{
                label: 'Xu hướng thị trường',
                data: {!! json_encode($data['values'] ?? []) !!},
                borderWidth: 2,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.4,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.1)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
