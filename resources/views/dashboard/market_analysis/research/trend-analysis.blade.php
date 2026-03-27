@php
    $analysis = $data['data'] ?? [];
    $chart = $analysis['chart_data'] ?? [];
@endphp

<div class="space-y-10 animate-fade-in">
    <!-- Hero Section: Market Pulse -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
            <svg class="absolute right-[-20px] bottom-[-20px] w-64 h-64 text-white/10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
            <p class="text-blue-100 font-bold uppercase tracking-wider text-xs mb-2">Market Size Estimate</p>
            <h3 class="text-4xl font-extrabold mb-4">{{ $analysis['market_size'] ?? 'N/A' }}</h3>
            <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-md px-3 py-1 rounded-full w-fit">
                <svg class="w-4 h-4 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span class="text-sm font-bold">{{ $analysis['growth_rate'] ?? '0%' }} Growth</span>
            </div>
        </div>
        
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-xl">
             <h4 class="text-gray-400 font-bold uppercase tracking-wider text-xs mb-4">Core Intelligence</h4>
             <p class="text-gray-700 leading-relaxed italic text-lg line-clamp-4">
                "{{ $analysis['analysis'] ?? 'Strategic analysis is being refined for your specific market conditions...' }}"
             </p>
        </div>
    </div>

    <!-- Interactive Trend Chart -->
    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-xl overflow-hidden">
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-xl font-bold text-gray-900">Interest & Growth Dynamics</h3>
            <div class="flex space-x-4">
                <div class="flex items-center"><span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span><span class="text-xs text-gray-500 font-medium">Growth Index</span></div>
                <div class="flex items-center"><span class="w-3 h-3 bg-indigo-300 rounded-full mr-2"></span><span class="text-xs text-gray-500 font-medium">Consumer Interest</span></div>
            </div>
        </div>
        
        <div class="h-[400px] w-full">
            <canvas id="marketTrendChart"></canvas>
        </div>
    </div>

    <!-- Emerging Trends Grid -->
    <div>
        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <span class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </span>
            Emerging Industry Trends
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($analysis['emerging_trends'] ?? [] as $trend)
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-md hover:shadow-lg transition-all border-t-4 border-green-500">
                    <div class="flex justify-between items-start mb-4">
                        <span @class([
                            'px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider',
                            'bg-red-100 text-red-600' => ($trend['impact_level'] ?? '') === 'Cao',
                            'bg-yellow-100 text-yellow-600' => ($trend['impact_level'] ?? '') === 'Trung bình',
                            'bg-green-100 text-green-600' => ($trend['impact_level'] ?? '') === 'Thấp',
                        ])>
                            {{ ($trend['impact_level'] ?? 'Normal') }} Impact
                        </span>
                        <span class="text-gray-400 text-[10px] font-bold uppercase">{{ $trend['timeline'] ?? '' }}</span>
                    </div>
                    <h4 class="font-bold text-gray-900 mb-2">{{ $trend['trend'] }}</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $trend['description'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- SWOT Matrix -->
    @if(isset($analysis['swot_analysis']))
    <div class="bg-gray-900 rounded-[2.5rem] p-10 text-white overflow-hidden relative">
        <h3 class="text-2xl font-bold mb-10 text-center">Industry SWOT Matrix</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
            <!-- Strengths -->
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-3xl border border-white/10">
                <h4 class="text-blue-400 font-bold uppercase tracking-widest text-xs mb-4">Strengths</h4>
                <ul class="space-y-3">
                    @foreach($analysis['swot_analysis']['strengths'] ?? [] as $s)
                        <li class="flex items-start text-sm"><svg class="w-5 h-5 text-blue-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>{{ $s }}</li>
                    @endforeach
                </ul>
            </div>
            <!-- Weaknesses -->
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-3xl border border-white/10">
                <h4 class="text-red-400 font-bold uppercase tracking-widest text-xs mb-4">Weaknesses</h4>
                <ul class="space-y-3">
                    @foreach($analysis['swot_analysis']['weaknesses'] ?? [] as $w)
                        <li class="flex items-start text-sm"><svg class="w-5 h-5 text-red-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>{{ $w }}</li>
                    @endforeach
                </ul>
            </div>
            <!-- Opportunities -->
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-3xl border border-white/10">
                <h4 class="text-green-400 font-bold uppercase tracking-widest text-xs mb-4">Opportunities</h4>
                <ul class="space-y-3">
                    @foreach($analysis['swot_analysis']['opportunities'] ?? [] as $o)
                        <li class="flex items-start text-sm"><svg class="w-5 h-5 text-green-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path></svg>{{ $o }}</li>
                    @endforeach
                </ul>
            </div>
            <!-- Threats -->
            <div class="bg-white/10 backdrop-blur-sm p-8 rounded-3xl border border-white/10">
                <h4 class="text-orange-400 font-bold uppercase tracking-widest text-xs mb-4">Threats</h4>
                <ul class="space-y-3">
                    @foreach($analysis['swot_analysis']['threats'] ?? [] as $t)
                        <li class="flex items-start text-sm"><svg class="w-5 h-5 text-orange-400 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>{{ $t }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
    (function() {
        const labels = {!! json_encode($chart['labels'] ?? []) !!};
        const growthData = {!! json_encode($chart['market_growth_index'] ?? []) !!};
        const interestData = {!! json_encode($chart['consumer_interest_index'] ?? []) !!};

        const ctx = document.getElementById('marketTrendChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Market Growth',
                        data: growthData,
                        borderColor: '#3b82f6',
                        backgroundColor: (context) => {
                            const chart = context.chart;
                            const {ctx, canvas} = chart;
                            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
                            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');
                            return gradient;
                        },
                        borderWidth: 4,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#3b82f6',
                        pointBorderWidth: 3
                    },
                    {
                        label: 'Consumer Interest',
                        data: interestData,
                        borderColor: '#a5b4fc',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        fill: false,
                        tension: 0.4,
                        pointRadius: 0
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#1f2937',
                        padding: 12,
                        titleFont: { size: 14, weight: 'bold' },
                        bodyFont: { size: 13 },
                        cornerRadius: 12
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: { display: true, color: 'rgba(0,0,0,0.05)', drawBorder: false },
                        ticks: { font: { size: 11, weight: 'bold' }, color: '#9ca3af' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 11, weight: 'bold' }, color: '#9ca3af' }
                    }
                }
            }
        });
    })();
</script>
