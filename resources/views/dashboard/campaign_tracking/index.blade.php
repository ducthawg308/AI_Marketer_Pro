<x-app-dashboard>
    <div class="container mx-auto px-8 py-8">
        <!-- Header -->
        <header class="mb-8 bg-gradient-to-r from-white via-gray-50 to-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-6">
                        <div class="relative">
                            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 bg-green-400 rounded-full border-3 border-white flex items-center justify-center">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Theo dõi chiến dịch</h1>
                            <p class="text-base text-gray-600">Xem báo cáo hiệu suất và phân tích các chiến dịch của bạn</p>
                        </div>
                    </div>


                </div>
            </div>
        </header>

        <!-- Search & Filter -->
        <div class="mb-6">
            <form method="GET" action="{{ route('dashboard.campaign_tracking.index') }}" class="flex items-center space-x-4 bg-white p-4 rounded-xl shadow-sm border">
                <div class="flex-1">
                    <label for="keyword" class="sr-only">Tìm kiếm chiến dịch</label>
                    <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tìm kiếm chiến dịch...">
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Tìm kiếm</span>
                </button>
            </form>
        </div>

        <!-- Campaigns Table -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Danh sách chiến dịch</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Chiến dịch</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Bài đăng</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Reactions</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Comments</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Shares</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Thời gian</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($campaigns as $campaign)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.894A1 1 0 0018 16V3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800" title="{{ $campaign->name }}">
                                                {{ Str::limit($campaign->name, 40) }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $campaign->status == 'running' ? 'Đang chạy' : 'Hoàn thành' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-gray-800">{{ $campaign->posted_posts_count }}</div>
                                        <div class="text-sm text-gray-500">đã đăng</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-red-600">{{ number_format($campaign->analytics_stats['total_reactions'] ?? 0) }}</div>
                                        <div class="text-sm text-gray-500">reactions</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ number_format($campaign->analytics_stats['total_comments'] ?? 0) }}</div>
                                        <div class="text-sm text-gray-500">comments</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ number_format($campaign->analytics_stats['total_shares'] ?? 0) }}</div>
                                        <div class="text-sm text-gray-500">shares</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    <div>{{ $campaign->start_date->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">
                                        @if($campaign->end_date)
                                            - {{ $campaign->end_date->format('d/m/Y') }}
                                        @else
                                            Không giới hạn
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('dashboard.campaign_tracking.show', $campaign) }}"
                                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                            </svg>
                                            <span>Xem báo cáo</span>
                                        </a>

                                        <form method="POST" action="{{ route('dashboard.campaign_tracking.sync', $campaign) }}"
                                              class="inline"
                                              x-data="{ loading: false }"
                                              @submit="loading = true">
                                            @csrf
                                            <button type="submit"
                                                    :disabled="loading"
                                                    class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors text-sm flex items-center space-x-1">
                                                <!-- Sync Icon - Hidden when loading -->
                                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0A8.003 8.003 0 0119.938 20M4.582 9H9"></path>
                                                </svg>

                                                <!-- Loading Spinner - Flowbite style -->
                                                <svg x-show="loading" x-cloak class="animate-spin w-4 h-4 text-white" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>

                                                <span x-text="loading ? 'Loading...' : 'Sync'"></span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($campaigns->isEmpty())
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-gradient-to-r from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có chiến dịch nào</h3>
                                    <p class="text-gray-500 mb-4">Tạo chiến dịch đầu tiên để bắt đầu theo dõi hiệu suất</p>
                                    <a href="{{ route('dashboard.auto_publisher.campaign.create') }}"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Tạo chiến dịch đầu tiên
                                    </a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            @if($campaigns->hasPages())
                <div class="mt-6 flex items-center justify-center border-t bg-gray-50 px-6 py-4">
                    {{ $campaigns->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>

</x-app-dashboard>
