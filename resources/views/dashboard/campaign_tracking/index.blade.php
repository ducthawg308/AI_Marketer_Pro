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

                    <div class="flex items-center space-x-4">
                        <!-- Test API Buttons -->
                        <button onclick="testFacebookApi()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Test API Access</span>
                        </button>

                        <button onclick="testMetricsApi()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span>Test Metrics API</span>
                        </button>
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
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Lượt hiển thị</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Tương tác</th>
                            <th class="px-6 py-4 text-left font-medium text-gray-700">Tỷ lệ tương tác</th>
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
                                        <div class="text-2xl font-bold text-blue-600">{{ number_format($campaign->analytics_stats['impressions'] ?? 0) }}</div>
                                        <div class="text-sm text-gray-500">hiển thị</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-green-600">{{ number_format($campaign->analytics_stats['total_engagement'] ?? 0) }}</div>
                                        <div class="text-sm text-gray-500">tương tác</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-purple-600">{{ number_format($campaign->analytics_stats['avg_engagement_rate'] ?? 0, 1) }}%</div>
                                        <div class="text-sm text-gray-500">tỷ lệ tương tác</div>
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

                                        <button onclick="syncAnalytics({{ $campaign->id }}, '{{ addslashes($campaign->name) }}')"
                                                class="px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0A8.003 8.003 0 0119.938 20M4.582 9H9"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if($campaigns->isEmpty())
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
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

    <!-- API Test Modal -->
    <div id="api-test-modal" tabindex="-1" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-6">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                <div class="border-b border-gray-200 p-6 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Test Facebook API</h3>
                            <p class="text-sm text-gray-600 mt-1">Kiểm tra kết nối với Facebook Graph API</p>
                        </div>
                    </div>
                </div>

                <div id="api-test-content" class="p-6">
                    <div class="flex items-center justify-center py-8">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <span class="ml-3 text-gray-600">Đang test...</span>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 p-6 border-t bg-gray-50">
                    <button type="button" onclick="closeApiTestModal()" class="px-6 py-3 text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors">
                        Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let syncButtons = {};

        function testFacebookApi() {
            const modal = document.getElementById('api-test-modal');
            const content = document.getElementById('api-test-content');

            modal.classList.remove('hidden');
            content.innerHTML = `
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                    <span class="ml-3 text-gray-600">Đang test Facebook API...</span>
                </div>
            `;

            fetch('{{ route("dashboard.campaign_tracking.test_api") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    content.innerHTML = `
                        <div class="text-center py-6">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-green-800 mb-2">Thành công!</h4>
                            <p class="text-gray-600 mb-4">${data.message}</p>
                            ${data.insights_note ? `<p class="text-sm text-blue-600">${data.insights_note}</p>` : ''}
                        </div>
                    `;
                } else {
                    content.innerHTML = `
                        <div class="text-center py-6">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-red-800 mb-2">Thất bại</h4>
                            <p class="text-gray-600">${data.message}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                content.innerHTML = `
                    <div class="text-center py-6">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-red-800 mb-2">Lỗi</h4>
                        <p class="text-gray-600">Không thể kết nối với server</p>
                    </div>
                `;
            });
        }

        function testMetricsApi() {
            const modal = document.getElementById('api-test-modal');
            const content = document.getElementById('api-test-content');

            modal.classList.remove('hidden');
            content.innerHTML = `
                <div class="flex items-center justify-center py-8">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-600"></div>
                    <span class="ml-3 text-gray-600">Đang test Facebook Metrics API...</span>
                    <div class="text-sm text-gray-500 mt-2">Đang tải danh sách posts có sẵn...</div>
                </div>
            `;

            fetch('{{ route("dashboard.campaign_tracking.test_metrics") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (data.available_posts && data.available_posts.length > 0) {
                        // Show available posts and test one
                        content.innerHTML = `
                            <div class="py-4">
                                <h4 class="font-semibold text-green-800 mb-2">✅ Tìm thấy ${data.available_posts.length} posts để test</h4>
                                <p class="text-sm text-gray-600 mb-4">Đang test metrics với post gần nhất...</p>

                                <div class="bg-gray-50 p-3 rounded-lg mb-4">
                                    <div class="text-sm">
                                        <strong>Post:</strong> ${data.available_posts[0].ad_title}<br>
                                        <strong>Page:</strong> ${data.available_posts[0].page_name}<br>
                                        <strong>Post ID:</strong> ${data.available_posts[0].post_id}
                                    </div>
                                </div>

                                <div class="flex items-center justify-center">
                                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600"></div>
                                    <span class="ml-2 text-sm text-gray-600">Đang fetch metrics...</span>
                                </div>
                            </div>
                        `;

                        // Test metrics for the first post
                        return fetch('{{ route("dashboard.campaign_tracking.test_metrics") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                post_id: data.available_posts[0].post_id
                            })
                        });
                    } else {
                        content.innerHTML = `
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-yellow-800 mb-2">Không có posts để test</h4>
                                <p class="text-gray-600 mb-4">${data.suggestion}</p>
                                <div class="text-sm text-gray-500">
                                    <strong>Next steps:</strong><br>
                                    ${data.next_steps.map(step => `• ${step}`).join('<br>')}
                                </div>
                            </div>
                        `;
                        return Promise.resolve(null);
                    }
                } else {
                    throw new Error(data.message);
                }
            })
            .then(response => response ? response.json() : null)
            .then(metricsData => {
                if (!metricsData) return;

                if (metricsData.success) {
                    content.innerHTML = `
                        <div class="py-4">
                            <div class="text-center mb-4">
                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-semibold text-green-800 mb-2">✅ Metrics API hoạt động!</h4>
                                <p class="text-sm text-green-600 mb-4">Lấy data metrics thành công (${metricsData.metrics_count} metrics)</p>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg text-sm">
                                <h5 class="font-semibold mb-2">📊 Processed Data:</h5>
                                <pre class="text-xs bg-white p-2 rounded border overflow-auto max-h-32">${JSON.stringify(metricsData.processed_data, null, 2)}</pre>
                            </div>

                            <div class="mt-4">
                                <h5 class="font-semibold mb-2">🔍 Raw Facebook Response (first 2 metrics):</h5>
                                <pre class="text-xs bg-white p-2 rounded border overflow-auto max-h-32">${JSON.stringify(metricsData.raw_response?.slice(0, 2), null, 2)}</pre>
                            </div>
                        </div>
                    `;
                } else {
                    content.innerHTML = `
                        <div class="text-center py-6">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-semibold text-red-800 mb-2">Metrics test thất bại</h4>
                            <p class="text-gray-600 mb-4">${metricsData.error || metricsData.message}</p>
                            ${metricsData.available_posts ? `<p class="text-sm text-blue-600">Có thể thử lại với posts khác</p>` : ''}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Metrics test error:', error);
                content.innerHTML = `
                    <div class="text-center py-6">
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-semibold text-red-800 mb-2">Lỗi test</h4>
                        <p class="text-gray-600">Không thể test metrics API</p>
                        <p class="text-sm text-gray-500 mt-2">${error.message || 'Unknown error'}</p>
                    </div>
                `;
            });
        }

        function closeApiTestModal() {
            document.getElementById('api-test-modal').classList.add('hidden');
        }

        function syncAnalytics(campaignId, campaignName) {
            const button = event.target.closest('button');
            const originalContent = button.innerHTML;
            const buttonKey = `campaign_${campaignId}`;

            // Prevent multiple clicks
            if (syncButtons[buttonKey]) return;
            syncButtons[buttonKey] = true;

            button.innerHTML = `
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
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
            // Simple toast implementation - you can enhance this
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
