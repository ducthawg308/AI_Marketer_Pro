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
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Báo cáo chiến dịch</h1>
                            <p class="text-base text-gray-600">{{ $campaign->name }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-3">
                            <form method="GET" action="{{ route('dashboard.campaign_tracking.show', $campaign) }}" class="flex items-center space-x-2">
                                <input type="date" name="start_date" value="{{ $startDate }}" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <span class="text-gray-500">-</span>
                                <input type="date" name="end_date" value="{{ $endDate }}" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Lọc</button>
                            </form>
                        </div>
                        <button onclick="syncAnalytics({{ $campaign->id }}, '{{ addslashes($campaign->name) }}')" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0A8.003 8.003 0 0119.938 20M4.582 9H9"></path>
                            </svg>
                            <span>Sync Data</span>
                        </button>
                        <a href="{{ route('dashboard.campaign_tracking.export', [$campaign, 'csv']) }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Export CSV</span>
                        </a>
                        <a href="{{ route('dashboard.campaign_tracking.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                            ← Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Analytics Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Tổng hiển thị</p>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($analyticsData['total_stats']['impressions']) }}</p>
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
                        <p class="text-2xl font-bold text-green-600">{{ number_format($analyticsData['total_stats']['total_engagement']) }}</p>
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
                        <p class="text-2xl font-bold text-purple-600">{{ number_format($analyticsData['total_stats']['avg_engagement_rate'], 1) }}%</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">CTR</p>
                        <p class="text-2xl font-bold text-orange-600">{{ number_format($analyticsData['total_stats']['avg_ctr'], 1) }}%</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Performance Table -->
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <div class="flex items-center justify-between p-6 border-b">
                <h2 class="text-xl font-semibold text-gray-800">Hiệu suất bài đăng</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Bài đăng</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Trang</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Thời gian đăng</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Lượt hiển thị</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Tương tác</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Tỷ lệ tương tác</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">CTR</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($postsAnalytics as $post)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.894A1 1 0 0018 16V3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-800" title="{{ $post['ad_title'] }}">{{ Str::limit($post['ad_title'], 40) }}</div>
                                            <div class="text-sm text-gray-500">Post ID: {{ $post['facebook_post_id'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-800">{{ $post['page_name'] }}</span>
                                </td>
                                <td class="px-6 py-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($post['scheduled_time'])->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-blue-600">{{ number_format($post['total_impressions']) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-green-600">{{ number_format($post['total_reactions'] + $post['total_comments'] + $post['total_shares']) }}</span>
                                    <div class="text-sm text-gray-500">
                                        👍 {{ $post['total_reactions'] }} | 💬 {{ $post['total_comments'] }} | 🔗 {{ $post['total_shares'] }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-purple-600">{{ number_format($post['engagement_rate'], 1) }}%</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-medium text-orange-600">{{ number_format($post['click_through_rate'], 1) }}%</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="w-16 h-16 bg-gradient-to-r from-gray-400 to-gray-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có dữ liệu analytics</h3>
                                    <p class="text-gray-500 mb-4">Hãy đồng bộ dữ liệu từ Facebook để xem báo cáo chi tiết</p>
                                    <button onclick="syncAnalytics({{ $campaign->id }}, '{{ addslashes($campaign->name) }}')" class="inline-flex items-center px-6 py-3 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-105">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0A8.003 8.003 0 0119.938 20M4.582 9H9"></path>
                                        </svg>
                                        Đồng bộ dữ liệu
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        let syncButtons = {};

        function syncAnalytics(campaignId, campaignName) {
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;
            const buttonKey = `campaign_${campaignId}`;

            // Prevent multiple clicks
            if (syncButtons[buttonKey]) return;
            syncButtons[buttonKey] = true;

            button.innerHTML = `
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                <span class="ml-2">Đang sync...</span>
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
                    resetButton(button, originalContent, campaignId);
                }
            })
            .catch(error => {
                showToast('❌ Lỗi kết nối server', 'error');
                resetButton(button, originalContent, campaignId);
            });
        }

        function resetButton(button, content, campaignId) {
            button.innerHTML = content;
            button.disabled = false;
            delete syncButtons[`campaign_${campaignId}`];
        }

        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white z-50 ${
                type === 'success' ? 'bg-green-500' :
                type e = =e= 'er r or'-re ? 'bg-red-500' :
                'bg-bl-e-b00lue-500'
            }`;
             oa t te t ont  t   messa etoast.textContent = message;
            documeetnbot.baodyn.applentodst)Child(toast);

             et ime  t  )       setTimeout(() => {
                t as  r    e )  toast.remove();
                         }, 5000);
                }
    <    i<t/script>
</x-app-dashboard>
