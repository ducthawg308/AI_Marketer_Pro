<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Login Form -->
            <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white">
                <div class="mx-auto w-full max-w-sm lg:w-96">
                    <!-- Back to Home Button -->
                    <div class="mb-8">
                        <a href="{{ url('/') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-primary-600 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Trang chủ
                        </a>
                    </div>

                    <!-- Logo or Brand -->
                    <div class="mb-8">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7z"/>
                                </svg>
                            </div>
                            <h1 class="text-xl font-bold text-gray-900">AI Marketer Pro</h1>
                        </div>
                    </div>

                    {{ $slot }}
                    
                    </form>
                </div>
            </div>

            <!-- Right Side - Illustration -->
            <div class="hidden lg:block relative flex-1 bg-gradient-to-br from-primary-50 via-primary-100 to-primary-200">
                <!-- Stats Cards -->
                <div class="absolute top-8 right-8 space-y-4">
                    <!-- AI Content Generation Card -->
                    <div class="bg-white rounded-2xl p-4 shadow-lg max-w-xs transform rotate-3 hover:rotate-0 transition-transform duration-300">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-gray-900">AI Content</div>
                                <div class="text-sm text-gray-600">Tạo nội dung tự động, tối ưu hóa</div>
                            </div>
                        </div>
                    </div>

                    <!-- Auto-Posting Card -->
                    <div class="bg-white rounded-2xl p-4 shadow-lg max-w-xs transform -rotate-2 hover:rotate-0 transition-transform duration-300">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-gray-900">Auto Post</div>
                                <div class="text-sm text-gray-600">Lên lịch đăng bài thông minh</div>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics Card -->
                    <div class="bg-white rounded-2xl p-4 shadow-lg max-w-xs transform rotate-1 hover:rotate-0 transition-transform duration-300">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-lg font-bold text-gray-900">Analytics</div>
                                <div class="text-sm text-gray-600">Phân tích hiệu quả chiến dịch</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Illustration -->
                <div class="flex items-center justify-center h-full">
                    <div class="relative">
                        <!-- AI-themed Illustration -->
                        <div class="w-80 h-80 bg-gradient-to-br from-primary-300 to-primary-500 rounded-full flex items-center justify-center shadow-2xl">
                            <div class="w-64 h-64 bg-white rounded-full flex items-center justify-center">
                                <svg class="w-32 h-32 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3zm0 10c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Device Illustration -->
                        <div class="absolute -bottom-8 -right-8 w-24 h-16 bg-gray-800 rounded-lg shadow-lg transform rotate-12">
                            <div class="w-full h-10 bg-gray-700 rounded-t-lg"></div>
                            <div class="w-full h-6 bg-gray-900 rounded-b-lg flex items-center justify-center">
                                <div class="w-16 h-1 bg-gray-600 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Decorative Element -->
                <div class="absolute bottom-20 left-20">
                    <div class="w-16 h-16 bg-white rounded-full shadow-lg flex items-center justify-center">
                        <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>