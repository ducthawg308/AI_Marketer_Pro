<x-app-dashboard>
    <div class="container mx-auto px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2 flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r
                            @if($analysis->research_type === 'consumer') from-blue-500 to-blue-600
                            @elseif($analysis->research_type === 'competitor') from-red-500 to-red-600
                            @else from-green-500 to-green-600
                            @endif rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($analysis->research_type === 'consumer')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                @elseif($analysis->research_type === 'competitor')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                @endif
                            </svg>
                        </div>
                        {{ $analysis->title }}
                    </h1>
                    <p class="text-gray-600">
                        Phân tích của <span class="font-semibold">{{ $analysis->product->name }}</span> •
                        {{ \Carbon\Carbon::parse($analysis->created_at)->format('d/m/Y \l\ú\c H:i') }}
                    </p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('dashboard.market_analysis.index') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl transition-all duration-300 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span>Quay lại</span>
                    </a>

                    <div class="relative">
                        <button type="button" onclick="toggleExportMenu()"
                                class="bg-gradient-to-r from-primary-600 to-primary-700 hover:from-primary-700 hover:to-primary-800 text-white px-6 py-3 rounded-xl shadow-lg transition-all duration-300 flex items-center space-x-2 hover:shadow-xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Xuất báo cáo</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <!-- Export Dropdown -->
                        <div id="export-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                            <div class="py-1">
                                <a href="{{ route('dashboard.market_analysis.export_individual', [$analysis->id, 'pdf']) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414l-5-5H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd"></path>
                                    </svg>
                                    Xuất PDF
                                </a>
                                <a href="{{ route('dashboard.market_analysis.export_individual', [$analysis->id, 'word']) }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <svg class="w-4 h-4 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 0v12h8V4H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Xuất Word
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analysis Content -->
        @include("dashboard.market_analysis.research.{$analysis->research_type}-analysis", ['data' => $analysisData])

        <!-- JavaScript for export menu -->
        <script>
            function toggleExportMenu() {
                const menu = document.getElementById('export-menu');
                menu.classList.toggle('hidden');
            }

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                const menu = document.getElementById('export-menu');
                const button = event.target.closest('[onclick*="toggleExportMenu"]');

                if (!button && !menu.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });
        </script>
    </div>
</x-app-dashboard>
