<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">
            Xác nhận mật khẩu<br>
            <span class="text-primary-600">AI Marketer Pro</span>
        </h2>
        <p class="text-gray-600 text-base">
            {{ __('Đây là khu vực bảo mật của ứng dụng. Vui lòng xác nhận mật khẩu của bạn trước khi tiếp tục.') }}
        </p>
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

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

        <!-- Submit Button -->
        <div class="flex justify-end">
            <x-primary-button class="py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 ease-in-out">
                {{ __('Xác nhận') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>