<x-app-dashboard>
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Chào mừng, Admin! 👋
            </h1>
            <p class="text-gray-600 dark:text-gray-400">
                Đây là trang quản trị của bạn. Dưới đây là tổng quan về hệ thống.
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card 1: Quyền truy cập -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-primary-100 dark:bg-primary-900 rounded-lg">
                        <svg class="w-7 h-7 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Quyền truy cập</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Quản lý quyền hạn và phân quyền cho người dùng</p>
                <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center text-sm font-medium text-primary-600 dark:text-primary-400 hover:underline">
                    Xem chi tiết
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Card 2: Vai trò -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Vai trò</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Thiết lập và quản lý các vai trò trong hệ thống</p>
                <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                    Xem chi tiết
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>

            <!-- Card 3: Người dùng -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 hover:shadow-lg transition-shadow">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center w-14 h-14 bg-purple-100 dark:bg-purple-900 rounded-lg">
                        <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Người dùng</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Quản lý tài khoản và thông tin người dùng</p>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline">
                    Xem chi tiết
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Thông tin hệ thống</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 bg-primary-100 dark:bg-primary-900 rounded-lg">
                                <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Tổng người dùng</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">74</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Vai trò hoạt động</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">2</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Quyền hệ thống</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">24</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Hoạt động hôm nay</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">5</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-dashboard>