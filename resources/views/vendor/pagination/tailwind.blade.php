@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <!-- Mobile Pagination -->
        <div class="flex justify-between flex-1 sm:hidden gap-3">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-xl dark:text-gray-500 dark:bg-gray-800/50 dark:border-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-primary-50 hover:border-primary-300 hover:text-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500/20 active:scale-95 transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-primary-900/20 dark:hover:border-primary-700 dark:hover:text-primary-400">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-primary-50 hover:border-primary-300 hover:text-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500/20 active:scale-95 transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-primary-900/20 dark:hover:border-primary-700 dark:hover:text-primary-400">
                    {!! __('pagination.next') !!}
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2.5 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-xl dark:text-gray-500 dark:bg-gray-800/50 dark:border-gray-700">
                    {!! __('pagination.next') !!}
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </div>

        <!-- Desktop Pagination -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <!-- <div>
                <p class="text-sm text-gray-600 leading-5 dark:text-gray-400">
                    {!! __('Hiển thị') !!}
                    @if ($paginator->firstItem())
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->firstItem() }}</span>
                        {!! __('đến') !!}
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->lastItem() }}</span>
                    @else
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->count() }}</span>
                    @endif
                    {!! __('của') !!}
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $paginator->total() }}</span>
                    {!! __('kết quả') !!}
                </p>
            </div> -->

            <div>
                <span class="relative z-0 inline-flex gap-1">
                    <!-- Previous Page Link -->
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-lg dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-primary-50 hover:border-primary-300 hover:text-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500/20 active:scale-95 transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-primary-900/20 dark:hover:border-primary-700 dark:hover:text-primary-400" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </a>
                    @endif

                    <!-- Pagination Elements -->
                    @foreach ($elements as $element)
                        <!-- "Three Dots" Separator -->
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-400 bg-white border border-gray-200 cursor-default rounded-lg dark:bg-gray-800 dark:border-gray-700 dark:text-gray-500">{{ $element }}</span>
                            </span>
                        @endif

                        <!-- Array Of Links -->
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-white bg-gradient-to-br from-primary-600 to-primary-700 border border-primary-600 cursor-default rounded-lg shadow-sm shadow-primary-500/30 dark:from-primary-600 dark:to-primary-700 dark:border-primary-600">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-primary-50 hover:border-primary-300 hover:text-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500/20 active:scale-95 transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-primary-900/20 dark:hover:border-primary-700 dark:hover:text-primary-400" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-primary-50 hover:border-primary-300 hover:text-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500/20 active:scale-95 transition-all duration-200 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-300 dark:hover:bg-primary-900/20 dark:hover:border-primary-700 dark:hover:text-primary-400" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-400 bg-gray-50 border border-gray-200 cursor-not-allowed rounded-lg dark:bg-gray-800/50 dark:border-gray-700 dark:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif