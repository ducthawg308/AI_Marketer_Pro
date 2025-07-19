<x-guest-layout>
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-2">
            Xác minh email<br>
            <span class="text-primary-600">AI Marketer Pro</span>
        </h2>
        <p class="text-gray-600 text-base">
            {{ __('Cảm ơn bạn đã đăng ký! Trước khi bắt đầu, bạn vui lòng xác minh địa chỉ email của mình bằng cách nhấp vào liên kết chúng tôi vừa gửi qua email. Nếu bạn không nhận được email, chúng tôi sẽ sẵn lòng gửi cho bạn một email khác.') }}
        </p>
    </div>

    <!-- Session Status -->
    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-primary-600">
            {{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email mà bạn đã cung cấp trong quá trình đăng ký.') }}
        </div>
    @endif

    <!-- Form -->
    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <div>
                <x-primary-button class="py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition duration-200 ease-in-out">
                    {{ __('Gửi lại email xác minh') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="font-medium text-sm text-primary-600 hover:text-primary-700 transition-colors duration-200">
                {{ __('Đăng xuất') }}
            </button>
        </form>
    </div>
</x-guest-layout>