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
                        <p class="text-sm text-gray-600">Tổng Reactions</p>
                        <p class="text-2xl font-bold text-red-600">{{ number_format($totalStats['total_reactions']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Tổng Comments</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($totalStats['total_comments']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Tổng Shares</p>
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($totalStats['total_shares']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
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
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Reactions</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Comments</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Shares</th>
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
                                        <span class="text-sm font-semibold text-red-600">{{ number_format($schedule->latest_analytics->reactions_total) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-green-600">{{ number_format($schedule->latest_analytics->comments) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="text-sm font-semibold text-purple-600">{{ number_format($schedule->latest_analytics->shares) }}</span>
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
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">
                                        Chưa có dữ liệu analytics
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        @if($schedules->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
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

        <!-- Engagement Breakdown -->
        @if($schedules->count() > 0 && ($totalStats['total_reactions'] + $totalStats['total_comments'] + $totalStats['total_shares']) > 0)
            <div class="mt-8 bg-white rounded-xl shadow-sm border overflow-hidden">
                <div class="p-6 border-b">
                    <h2 class="text-xl font-semibold text-gray-800">⚡ Engagement Breakdown</h2>
                    <p class="text-sm text-gray-600 mt-1">Tổng quan tương tác của chiến dịch</p>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-red-600">{{ number_format($totalStats['total_reactions']) }}</p>
                            <p class="text-sm text-gray-600">Reactions</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($totalStats['total_comments']) }}</p>
                            <p class="text-sm text-gray-600">Comments</p>
                        </div>

                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-purple-600">{{ number_format($totalStats['total_shares']) }}</p>
                            <p class="text-sm text-gray-600">Shares</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
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
