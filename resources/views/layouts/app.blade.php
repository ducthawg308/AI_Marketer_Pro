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
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <!-- @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset -->

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
            
            <!-- Footer -->
            <footer class="bg-gradient-to-r from-primary to-primary-900 dark:from-gray-800 dark:to-gray-900 text-white py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Brand Section -->
                        <div class="mb-6 md:mb-0">
                            <a href="#" class="flex items-center">
                                <x-application-logo class="h-8 w-auto fill-current text-white" />
                                <span class="ml-2 text-xl font-semibold">AI Marketer Pro</span>
                            </a>
                            <p class="mt-4 text-sm text-primary-200 dark:text-gray-400 max-w-xs">
                                Công cụ AI mạnh mẽ giúp bạn tạo nội dung và đăng bài tự động, tối ưu chiến dịch marketing.
                            </p>
                        </div>
                        <!-- Links Section -->
                        <div class="mb-6 md:mb-0">
                            <h3 class="text-lg font-semibold mb-4 text-white">Liên Kết Nhanh</h3>
                            <ul class="space-y-2">
                                <li><a href="#" class="text-primary-200 hover:text-white transition">Về Chúng Tôi</a></li>
                                <li><a href="#" class="text-primary-200 hover:text-white transition">Liên Hệ</a></li>
                                <li><a href="#" class="text-primary-200 hover:text-white transition">Chính Sách</a></li>
                                <li><a href="#" class="text-primary-200 hover:text-white transition">Hỗ Trợ</a></li>
                            </ul>
                        </div>
                        <!-- Social & Contact Section -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4 text-white">Kết Nối Với Chúng Tôi</h3>
                            <div class="flex gap-4 mb-4">
                                <a href="#" class="text-primary-200 hover:text-white transition">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-2.717 0-4.92 2.203-4.92 4.917 0 .385.045.761.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.733-.666 1.585-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.061c0 2.385 1.693 4.374 3.946 4.827-.413.111-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.396 0-.788-.023-1.175-.068 2.187 1.402 4.782 2.223 7.565 2.223 9.076 0 14.036-7.515 14.036-14.036 0-.683-.019-1.365-.056-2.043 1.026-.741 1.92-1.664 2.626-2.716z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-primary-200 hover:text-white transition">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.611 4.86 4.858.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.089 3.247-1.608 4.71-4.86 4.858-1.266.057-1.645.07-4.85.07-3.204 0-3.584-.012-4.85-.069-3.252-.149-4.771-1.611-4.86-4.858-.058-1.265-.069-1.645-.069-4.849 0-3.204.012-3.584.069-4.849.149-3.252 1.608-4.771 4.86-4.858 1.266-.057 1.645-.069 4.85-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                    </svg>
                                </a>
                                <a href="#" class="text-primary-200 hover:text-white transition">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                </a>
                            </div>
                            <p class="text-sm text-primary-200 dark:text-gray-400">
                                Email: support@aimarketerpro.com | Hotline: +84 123 456 789
                            </p>
                        </div>
                    </div>
                    <div class="mt-8 pt-4 border-t border-primary-700 dark:border-gray-700 text-center">
                        <p class="text-sm text-primary-200 dark:text-gray-400">
                            © {{ date('Y') }} AI Marketer Pro. All rights reserved.
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
