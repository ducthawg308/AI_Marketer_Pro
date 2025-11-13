<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">
            Đăng nhập vào<br>
            <span class="text-primary-600">AI Marketer Pro</span>
        </h2>
        <p class="text-gray-600 text-base">
            Tạo nội dung AI đỉnh cao và quản lý đăng bài tự động
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input id="email" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-200 ease-in-out" 
                            type="email" 
                            name="email" 
                            :value="old('email')" 
                            required 
                            autofocus 
                            autocomplete="username" 
                            placeholder="Nhập email của bạn" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Mật khẩu')" class="block text-sm font-medium text-gray-700 mb-2" />
            <x-text-input id="password" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition duration-200 ease-in-out"
                            type="password"
                            name="password"
                            required 
                            autocomplete="current-password"
                            placeholder="Nhập mật khẩu của bạn" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center">
                <input id="remember_me" 
                        type="checkbox" 
                        class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" 
                        name="remember">
                <label for="remember_me" class="ml-2 text-gray-600">
                    {{ __('Ghi nhớ đăng nhập') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <div>
                    <a href="{{ route('password.request') }}" 
                        class="font-medium text-primary-600 hover:text-primary-700 transition-colors duration-200">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div>
            <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 ease-in-out">
                {{ __('Đăng nhập') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <span class="text-gray-600">Chưa có tài khoản? </span>
            <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-700 transition-colors duration-200">
                Đăng ký ngay
            </a>
        </div>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">hoặc</span>
            </div>
        </div>

        <div class="mt-4 space-y-2">
            <!-- Google Login Button -->
            <a href="{{ route('auth.google') }}" 
            class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 ease-in-out" 
            aria-label="Đăng nhập với Google">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Đăng nhập với Google
            </a>

            <!-- Facebook Login Button -->
            <a href="{{ route('auth.facebook') }}" 
            class="w-full inline-flex justify-center items-center py-3 px-4 border border-gray-300 rounded-md bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 ease-in-out" 
            aria-label="Đăng nhập với Facebook">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#1877F2" d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.99 3.66 9.13 8.44 9.88v-6.99h-2.54v-2.89h2.54V9.51c0-2.51 1.49-3.89 3.78-3.89 1.09 0 2.24.19 2.24.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.89h-2.33v6.99C18.34 21.13 22 16.99 22 12z"/>
                </svg>
                Đăng nhập với Facebook
            </a>
        </div>
    </form>
</x-guest-layout>