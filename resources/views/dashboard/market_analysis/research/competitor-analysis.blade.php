@php
    $analysis = $data['data'] ?? [];
    $competitors = $analysis['competitors'] ?? [];
    $strategies = $analysis['strategy'] ?? [];
@endphp

<div class="space-y-12 animate-fade-in">
    <!-- Section: Competitor Landscape -->
    <div>
        <div class="flex items-center justify-between mb-8">
            <h3 class="text-2xl font-bold text-gray-900">Competitive Landscape</h3>
            <span class="px-4 py-1 bg-red-50 text-red-600 rounded-full text-xs font-bold uppercase tracking-widest border border-red-100">
                {{ count($competitors) }} Key Players Identified
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($competitors as $index => $competitor)
                <div class="group bg-white rounded-3xl p-8 border border-gray-100 shadow-lg hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-red-50 rounded-bl-full flex items-center justify-center -mr-4 -mt-4 transition-transform group-hover:scale-110">
                        <span class="text-red-300 font-extrabold text-2xl mb-4 ml-4">#{{ $index + 1 }}</span>
                    </div>
                    
                    <div class="flex items-center mb-6">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-red-200">
                            {{ substr($competitor['name'] ?? 'C', 0, 1) }}
                        </div>
                        <div class="ml-4">
                            <h4 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition-colors">{{ $competitor['name'] ?? 'Unknown' }}</h4>
                            <a href="{{ $competitor['url'] ?? '#' }}" target="_blank" class="text-xs text-blue-500 font-bold hover:underline flex items-center mt-1">
                                {{ parse_url($competitor['url'] ?? '', PHP_URL_HOST) ?: 'Visit Website' }}
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Strengths & Weaknesses -->
                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-bold text-green-600 uppercase tracking-widest mb-3">Core Strengths</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($competitor['strengths'] ?? [] as $s)
                                    <span class="px-3 py-1 bg-green-50 text-green-700 rounded-lg text-xs font-semibold border border-green-100">{{ $s }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold text-red-600 uppercase tracking-widest mb-3">Vulnerabilities</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($competitor['weaknesses'] ?? [] as $w)
                                    <span class="px-3 py-1 bg-red-50 text-red-700 rounded-lg text-xs font-semibold border border-red-100">{{ $w }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section: Strategic Recommendations -->
    <div class="bg-gradient-to-br from-gray-900 to-black rounded-[3rem] p-12 text-white shadow-2xl relative overflow-hidden">
        <svg class="absolute right-[-50px] top-[-50px] w-96 h-96 text-white/5" fill="currentColor" viewBox="0 0 20 20"><path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM5.884 4.47a1 1 0 10-1.415 1.414l.707.707a1 1 0 001.415-1.414l-.707-.707zM3 8a1 1 0 011-1h1a1 1 0 110 2H4a1 1 0 01-1-1zM12.854 4.47a1 1 0 011.415 1.414l-.707.707a1 1 0 01-1.415-1.414l.707-.707zM10.812 9l-.511 5.115a.434.434 0 01-.86 0L8.93 9h1.882zm4.188-1a1 1 0 110 2h-1a1 1 0 110-2h1zM8.89 15l-.272 2.72a.79.79 0 001.584 0l-.272-2.72H8.89zM15.53 14.116a1 1 0 011.415 1.415l-.707.707a1 1 0 01-1.414-1.414l.706-.708zM4.47 14.116a1 1 0 00-1.415 1.415l.707.707a1 1 0 001.414-1.414l-.706-.708z"/></svg>
        
        <div class="relative z-10">
            <h3 class="text-3xl font-extrabold mb-4 flex items-center">
                <span class="w-12 h-12 bg-primary-600 rounded-2xl flex items-center justify-center mr-4 shadow-lg shadow-primary-900/50">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </span>
                AI-Driven Conquest Strategy
            </h3>
            <p class="text-gray-400 mb-12 max-w-2xl text-lg">Targeted intelligence to bypass competition and capture dominant market share.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($strategies as $strategy)
                    <div class="group bg-white/10 backdrop-blur-md p-8 rounded-3xl border border-white/10 hover:bg-white/15 transition-all">
                        <div class="flex items-start mb-4">
                            <span class="w-8 h-8 bg-primary-600/30 rounded-full flex items-center justify-center mr-3 text-primary-400 font-bold border border-primary-500/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <h4 class="text-xl font-bold text-white group-hover:text-primary-400 transition-colors">{{ $strategy['title'] }}</h4>
                        </div>
                        <p class="text-gray-400 leading-relaxed text-sm ml-11">{{ $strategy['content'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
