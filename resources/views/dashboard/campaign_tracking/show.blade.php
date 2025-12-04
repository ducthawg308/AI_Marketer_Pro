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
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $campaign->name }}</h1>
                            <p class="text-base text-gray-600">{{ $campaign->description ?? 'Chiến dịch marketing Facebook' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('dashboard.campaign_tracking.index') }}"
                           class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Quay lại</span>
                        </a>

                        <button onclick="syncCampaignAnalytics({{ $campaign->id }}, '{{ addslashes($campaign->name) }}')"
                                class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0A8.003 8.003 0 0119.938 20M4.582 9H9"></path>
                            </svg>
                            <span>Sync Analytics</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Campaign Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Tổng bài đăng</p>
                        <p class="text-2xl font-bold text-gray-800">{{ number_format($totalStats['total_posts']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Lượt hiển thị</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($totalStats['impressions']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Tương tác</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($totalStats['total_engagement']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Tỷ lệ tương tác</p>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($totalStats['avg_engagement_rate'], 1) }}%</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Analytics Table -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Bài đăng và phân tích hiệu suất</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Bài đăng</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Facebook Page</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Reach</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Impressions</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Reaction</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Comments</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Shares</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Clicks</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Engage Rate</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Last Updated</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($schedules as $schedule)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        @if($schedule->ad)
                                            <div class="font-medium text-gray-800 text-sm" title="{{ $schedule->ad->ad_title }}">
                                                {{ Str::limit($schedule->ad->ad_title, 50) }}
                                            </div>
                                            @if($schedule->latest_analytics && $schedule->latest_analytics->post_message)
                                                <div class="text-xs text-gray-500 mt-1 line-clamp-2" title="{{ $schedule->latest_analytics->post_message }}">
                                                    {{ Str::limit($schedule->latest_analytics->post_message, 80) }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="text-gray-500">N/A</div>
                                        @endif

                                        <div class="text-xs text-gray-400 mt-1">
                                            ID: {{ $schedule->facebook_post_id ?? 'Chưa có' }}
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="text-sm font-medium text-gray-800">
                                            {{ $schedule->userPage->page_name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>

                                @if($schedule->latest_analytics)
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-blue-600">{{ number_format($schedule->latest_analytics->reach) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-blue-800">{{ number_format($schedule->latest_analytics->impressions) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-red-600">{{ number_format($schedule->latest_analytics->reactions_total) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-green-600">{{ number_format($schedule->latest_analytics->comments) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-purple-600">{{ number_format($schedule->latest_analytics->shares) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-orange-600">{{ number_format($schedule->latest_analytics->clicks) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-indigo-600">{{ number_format($schedule->latest_analytics->engagement_rate, 1) }}%</span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        <div class="text-xs">{{ $schedule->latest_analytics->fetched_at?->format('d/m/Y H:i') }}</div>
                                        <div class="text-xs text-gray-400">
                                            @if($schedule->latest_analytics->insights_date)
                                                {{ $schedule->latest_analytics->insights_date->format('d/m/Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </td>
                                @else
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 italic">
                                        Chưa có dữ liệu analytics
                                    </td>
                                    <td class="px-6 py-4 text-gray-600">
                                        <div class="text-xs text-gray-400">Never</div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        @if($schedules->isEmpty())
                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-gradient-to-r from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có bài đăng nào</h3>
                                    <p class="text-gray-500">Chiến dịch này chưa có bài đăng nào được publish thành công.</p>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Analytics Charts & Insights -->
        @if($schedules->count() > 0)
            @if($totalStats['impressions'] > 0)
                <div class="mt-8 space-y-8">
                    <h2 class="text-2xl font-bold text-gray-900">📊 Campaign Analytics & Insights</h2>

                    <!-- Performance Overview Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <!-- Impressions Trend -->
                        <div class="bg-white rounded-xl shadow-sm border p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Impressions Performance</p>
                                    <p class="text-3xl font-bold text-blue-600">{{ number_format($totalStats['impressions']) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Total Reach: {{ number_format($totalStats['reach'] ?? 0) }}</p>
                                </div>
                                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            @if($totalStats['reach'] > 0 && $totalStats['impressions'] > 0)
                                <div class="mt-4">
                                    <div class="flex justify-between text-sm">
                                        <span>Frequency</span>
                                        <span>{{ number_format($totalStats['impressions'] / $totalStats['reach'], 2) }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min(100, ($totalStats['reach'] / max($totalStats['impressions'], 1)) * 100) }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Engagement Insights -->
                        <div class="bg-white rounded-xl shadow-sm border p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Engagement Rate</p>
                                    <p class="text-3xl font-bold text-green-600">{{ number_format($totalStats['avg_engagement_rate'], 1) }}%</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ number_format($totalStats['total_engagement']) }} interactions</p>
                                </div>
                                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            @if($totalStats['total_engagement'] > 0)
                                <div class="mt-4">
                                    <div class="grid grid-cols-3 gap-2 text-xs">
                                        <div class="text-center">
                                            <span class="block font-semibold">👍</span>
                                            <span class="block text-gray-500">{{ $schedules->sum('analytics.0.reactions_total') ?? 0 }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="block font-semibold">💬</span>
                                            <span class="block text-gray-500">{{ $schedules->sum('analytics.0.comments') ?? 0 }}</span>
                                        </div>
                                        <div class="text-center">
                                            <span class="block font-semibold">📤</span>
                                            <span class="block text-gray-500">{{ $schedules->sum('analytics.0.shares') ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- CTR Performance -->
                        <div class="bg-white rounded-xl shadow-sm border p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600">Click Through Rate</p>
                                    <p class="text-3xl font-bold text-orange-600">{{ number_format($totalStats['avg_ctr'] ?? 0, 1) }}%</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $totalStats['clicks'] ?? 0 }} clicks total</p>
                                </div>
                                <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
                                    </svg>
                                </div>
                            </div>
                            @if($totalStats['clicks'] ?? 0 > 0)
                                <div class="mt-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-orange-500 h-2 rounded-full" style="width: {{ min(100, (($totalStats['clicks'] ?? 0) / max($totalStats['impressions'] ?? 1, 1)) * 100) }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">CTR: {{ number_format(($totalStats['clicks'] ?? 0) / max($totalStats['impressions'] ?? 1, 1) * 100, 1) }}%</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Performance Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Impressions vs Reach Chart -->
                        <div class="bg-white rounded-xl shadow-sm border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">📈 Reach vs Impressions</h3>
                            <div id="reach-chart" class="h-64"></div>
                            @if($totalStats['reach'] > 0)
                                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                    <div class="text-center">
                                        <p class="font-semibold text-blue-600">{{ number_format($totalStats['reach']) }}</p>
                                        <p class="text-gray-500">Unique Reach</p>
                                    </div>
                                    <div class="text-center">
                                        <p class="font-semibold text-blue-800">{{ number_format($totalStats['impressions']) }}</p>
                                        <p class="text-gray-500">Total Impressions</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Engagement Breakdown -->
                        <div class="bg-white rounded-xl shadow-sm border p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-6">⚡ Engagement Breakdown</h3>
                            <div id="engagement-chart" class="h-64"></div>
                            @if($totalStats['total_engagement'] > 0)
                                <div class="mt-4 grid grid-cols-3 gap-2 text-sm text-center">
                                    <div>
                                        <p class="font-semibold text-red-500">{{ $schedules->sum('analytics.0.reactions_total') ?? 0 }}</p>
                                        <p class="text-gray-500">Reactions</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-green-500">{{ $schedules->sum('analytics.0.comments') ?? 0 }}</p>
                                        <p class="text-gray-500">Comments</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-purple-500">{{ $schedules->sum('analytics.0.shares') ?? 0 }}</p>
                                        <p class="text-gray-500">Shares</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recent Posts Performance -->
                    <div class="bg-white rounded-xl shadow-sm border">
                        <div class="p-6 border-b">
                            <h3 class="text-lg font-semibold text-gray-900">📋 Recent Posts Performance</h3>
                            <p class="text-sm text-gray-600 mt-1">Top performing posts from the last 7 days</p>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @php
                                $recentBlogs = $schedules->take(5);
                            @endphp
                            @foreach($recentBlogs as $schedule)
                                @if($schedule->analytics && $schedule->analytics->isNotEmpty())
                                    @php $analytics = $schedule->analytics->first(); @endphp
                                    <div class="p-6 hover:bg-gray-50">
                                        <div class="flex items-start justify-between">
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.894A1 1 0 0018 16V3z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-sm font-medium text-gray-900 truncate">
                                                            {{ Str::limit($schedule->ad->ad_title ?? 'Untitled Post', 60) }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            Posted {{ $analytics->post_created_time?->diffForHumans() ?? 'Unknown' }}
                                                            • {{ $schedule->userPage->page_name ?? 'Unknown page' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @if($analytics->post_message)
                                                    <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                                                        {{ Str::limit($analytics->post_message, 120) }}
                                                    </p>
                                                @endif
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <div class="grid grid-cols-3 gap-4 text-center text-xs">
                                                    <div>
                                                        <p class="font-semibold text-blue-600">{{ number_format($analytics->impressions) }}</p>
                                                        <p class="text-gray-500">Views</p>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-green-600">{{ $analytics->reactions_total + $analytics->comments + $analytics->shares }}</p>
                                                        <p class="text-gray-500">Engage</p>
                                                    </div>
                                                    <div>
                                                        <p class="font-semibold text-purple-600">{{ number_format($analytics->engagement_rate, 1) }}%</p>
                                                        <p class="text-gray-500">Rate</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <!-- No Analytics Data Notice -->
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200 p-6">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-900 mb-2">Facebook Analytics Data</h3>
                            <p class="text-blue-800 mb-3">
                                Hiện tại chiến dịch chưa có dữ liệu analytics từ Facebook.
                                Sau khi sync analytics, sẽ hiển thị charts và insights ở đây.
                            </p>
                            <div class="text-sm text-blue-700">
                                <strong>💡 Tips:</strong>
                                Facebook thường mất 24-48h sau khi post mới có metrics insights.
                                Click nút "Sync Analytics" để cập nhật dữ liệu mới nhất.
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Initialize charts when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            @if($totalStats['reach'] > 0 && $totalStats['impressions'] > 0)
                initReachChart();
            @endif

            @if($totalStats['total_engagement'] > 0)
                initEngagementChart();
            @endif
        });

        function initReachChart() {
            const ctx = document.getElementById('reach-chart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Unique Reach', 'Total Impressions'],
                    datasets: [{
                        label: 'Performance Metrics',
                        data: [{{ $totalStats['reach'] }}, {{ $totalStats['impressions'] }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(30, 58, 138, 0.8)'
                        ],
                        borderColor: [
                            'rgb(59, 130, 246)',
                            'rgb(30, 58, 138)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        function initEngagementChart() {
            const ctx = document.getElementById('engagement-chart').getContext('2d');

            const reactions = {{ $schedules->sum('analytics.0.reactions_total') ?? 0 }};
            const comments = {{ $schedules->sum('analytics.0.comments') ?? 0 }};
            const shares = {{ $schedules->sum('analytics.0.shares') ?? 0 }};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Reactions', 'Comments', 'Shares'],
                    datasets: [{
                        data: [reactions, comments, shares],
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(34, 197, 94, 0.8)',
                            'rgba(147, 51, 234, 0.8)'
                        ],
                        borderColor: [
                            'rgb(239, 68, 68)',
                            'rgb(34, 197, 94)',
                            'rgb(147, 51, 234)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.parsed / total) * 100).toFixed(1);
                                    return context.label + ': ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                                }
                            }
                        }
                    }
                }
            });
        }

        function syncCampaignAnalytics(campaignId, campaignName) {
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;

            button.innerHTML = `
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>
                Syncing...
            `;
            button.disabled = true;

            fetch(`{{ url('dashboard/campaign_tracking') }}/${campaignId}/sync`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success toast
                    showToast(`✅ Đã sync analytics cho "${campaignName}": ${data.stats.posts_processed} posts`, 'success');

                    // Reload page after short delay to show updated data
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    showToast(`❌ Sync thất bại: ${data.message}`, 'error');
                    resetButton(button, originalContent);
                }
            })
            .catch(error => {
                showToast('❌ Lỗi kết nối server khi sync', 'error');
                resetButton(button, originalContent);
            });
        }

        function resetButton(button, content) {
            button.innerHTML = content;
            button.disabled = false;
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                'bg-blue-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 5000);
        }
    </script>
</x-app-dashboard>
