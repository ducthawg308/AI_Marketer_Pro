<x-app-dashboard>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs & Actions -->
            <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <div class="flex flex-col">
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-2">
                            <li>
                                <a href="{{ route('dashboard.market_analysis.index') }}" class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-primary-600 transition-colors">Intelligence Hub</a>
                            </li>
                            <li>
                                <svg class="h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </li>
                            <li>
                                <span class="text-xs font-bold text-primary-600 uppercase tracking-widest">Report View</span>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight flex items-center">
                        <span @class([
                            'w-2 h-8 rounded-full mr-4',
                            'bg-blue-600' => $analysis->research_type === 'consumer',
                            'bg-red-600' => $analysis->research_type === 'competitor',
                            'bg-green-600' => $analysis->research_type === 'trend',
                        ])></span>
                        {{ $analysis->title }}
                    </h1>
                    <p class="mt-2 text-gray-500 font-medium">
                        Generated for <span class="text-gray-900 font-bold border-b-2 border-primary-200">{{ $analysis->product->name }}</span> 
                        • {{ $analysis->created_at->format('M d, Y - H:i') }}
                    </p>
                </div>

                <div class="flex items-center space-x-3" x-data="{ open: false }">
                    <a href="{{ route('dashboard.market_analysis.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all">
                       <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                       Hub
                    </a>
                    
                    <div class="relative">
                        <button @click="open = !open" class="inline-flex items-center px-6 py-2.5 border border-transparent text-sm font-bold rounded-xl shadow-lg text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-all hover:scale-105">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Export Intel
                        </button>
                        
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" class="origin-top-right absolute right-0 mt-2 w-48 rounded-2xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 z-20 overflow-hidden py-1">
                            <a href="{{ route('dashboard.market_analysis.export_individual', [$analysis->id, 'pdf']) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                <svg class="mr-3 h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414l-5-5H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path></svg>
                                Adobe PDF Report
                            </a>
                            <a href="{{ route('dashboard.market_analysis.export_individual', [$analysis->id, 'word']) }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                <svg class="mr-3 h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path></svg>
                                MS Word Document
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Details Container -->
            <div class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 overflow-hidden transition-all hover:shadow-primary-100/30">
                <div class="p-8 md:p-12">
                   @include("dashboard.market_analysis.research.{$analysis->research_type}-analysis", ['data' => ['data' => $analysisData]])
                </div>
            </div>
        </div>
    </div>
</x-app-dashboard>
