@php
    $analysis = $data['data'] ?? [];
    $persona = $analysis['persona'] ?? 'Standard Segment';
    $demographics = $analysis['demographics'] ?? [];
    $empathy = $analysis['empathy_map'] ?? [];
@endphp

<div class="space-y-12 animate-fade-in font-display">
    <!-- Section: Persona Spotlight -->
    <div class="bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-gray-100 flex flex-col md:flex-row shadow-blue-100/50">
        <div class="md:w-1/3 bg-gradient-to-br from-blue-600 to-indigo-800 p-12 text-white flex flex-col items-center justify-center text-center">
            <div class="w-32 h-32 bg-white/20 backdrop-blur-xl rounded-full flex items-center justify-center mb-6 border-4 border-white/30 shadow-2xl animate-pulse">
                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h3 class="text-3xl font-extrabold mb-2">{{ $persona }}</h3>
            <span class="px-4 py-1 bg-white/10 rounded-full text-xs font-bold uppercase tracking-widest border border-white/20">Primary Target</span>
            
            <div class="mt-10 w-full space-y-4">
                <div class="flex justify-between text-sm border-b border-white/10 pb-2">
                    <span class="text-blue-200">Age:</span>
                    <span class="font-bold">{{ $analysis['age_range'] ?? '25-45' }}</span>
                </div>
                <div class="flex justify-between text-sm border-b border-white/10 pb-2">
                    <span class="text-blue-200">Income:</span>
                    <span class="font-bold">{{ $analysis['income'] ?? 'Mid-High' }}</span>
                </div>
                <div class="flex justify-between text-sm border-b border-white/10 pb-2">
                    <span class="text-blue-200">Geo:</span>
                    <span class="font-bold">{{ $analysis['location'] ?? 'Global' }}</span>
                </div>
            </div>
        </div>
        
        <div class="md:w-2/3 p-12 bg-white">
            <h4 class="text-gray-400 font-bold uppercase tracking-widest text-xs mb-6">Strategic Persona Summary</h4>
            <p class="text-2xl text-gray-900 leading-snug font-bold mb-10">
                "{{ $analysis['summary'] ?? 'Searching for premium solutions that balance high performance with intuitive accessibility.' }}"
            </p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h5 class="text-sm font-extrabold text-blue-600 uppercase tracking-widest mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Core Pain Points
                    </h5>
                    <ul class="space-y-3">
                        @foreach($analysis['pain_points'] ?? [] as $p)
                            <li class="flex items-start text-gray-700 text-sm font-medium"><span class="w-1.5 h-1.5 bg-red-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>{{ $p }}</li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h5 class="text-sm font-extrabold text-green-600 uppercase tracking-widest mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Main Desires
                    </h5>
                    <ul class="space-y-3">
                        @foreach($analysis['desires'] ?? [] as $d)
                            <li class="flex items-start text-gray-700 text-sm font-medium"><span class="w-1.5 h-1.5 bg-green-400 rounded-full mt-2 mr-3 flex-shrink-0"></span>{{ $d }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Section: The Empathy Matrix -->
    @if(!empty($empathy))
    <div class="relative">
        <h3 class="text-3xl font-extrabold text-gray-900 mb-12 text-center">The Consumer Mindset Matrix</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-px bg-gray-100 rounded-[2.5rem] border border-gray-100 overflow-hidden shadow-2xl">
            <!-- Thinks -->
            <div class="bg-white p-12 hover:bg-blue-50/30 transition-colors">
                <div class="flex items-center mb-6">
                    <span class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mr-4 font-bold">1</span>
                    <h4 class="text-xl font-extrabold text-gray-900 italic">Thinks & Feels</h4>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $empathy['thinks_feels'] ?? '' }}</p>
            </div>
            <!-- Sees -->
            <div class="bg-white p-12 hover:bg-purple-50/30 transition-colors">
                <div class="flex items-center mb-6">
                    <span class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mr-4 font-bold">2</span>
                    <h4 class="text-xl font-extrabold text-gray-900 italic">Sees & Hears</h4>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $empathy['sees_hears'] ?? '' }}</p>
            </div>
            <!-- Says -->
            <div class="bg-white p-12 hover:bg-green-50/30 transition-colors">
                <div class="flex items-center mb-6">
                    <span class="w-10 h-10 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mr-4 font-bold">3</span>
                    <h4 class="text-xl font-extrabold text-gray-900 italic">Says & Does</h4>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $empathy['says_does'] ?? '' }}</p>
            </div>
            <!-- Gains -->
            <div class="bg-white p-12 hover:bg-orange-50/30 transition-colors">
                <div class="flex items-center mb-6">
                    <span class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center mr-4 font-bold">4</span>
                    <h4 class="text-xl font-extrabold text-gray-900 italic">Pain & Gain</h4>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $empathy['pains_gains'] ?? '' }}</p>
            </div>
        </div>
        
        <!-- Decoration Center -->
        <div class="hidden md:flex absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-20 h-20 bg-white border border-gray-100 rounded-full shadow-xl items-center justify-center z-10">
            <svg class="w-10 h-10 text-primary-600" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
        </div>
    </div>
    @endif

    <!-- Section: Behavioral Patterns -->
    <div>
        <h3 class="text-2xl font-bold text-gray-900 mb-8 flex items-center justify-center">
            <span class="w-8 h-1 bg-primary-600 mr-4 rounded-full"></span>
            Purchasing Behavior Patterns
            <span class="w-8 h-1 bg-primary-600 ml-4 rounded-full"></span>
        </h3>
        <div class="flex flex-wrap justify-center gap-6">
            @foreach($analysis['behavioral_patterns'] ?? [] as $pattern)
                <div class="bg-gray-50 px-8 py-6 rounded-[2rem] border border-gray-200 hover:border-primary-400 hover:bg-white transition-all cursor-default">
                    <p class="text-gray-900 font-bold text-lg text-center">{{ $pattern }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
