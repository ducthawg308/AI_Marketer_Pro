{{-- resources/views/components/auth-buttons.blade.php --}}
@props(['responsive' => false])

@if($responsive)
    {{-- Responsive Version (Mobile) --}}
    <div class="pt-4 pb-1 border-t border-primary-600 dark:border-gray-600 bg-primary-800 dark:bg-gray-800">
        @auth
            <div class="px-4">
                <div class="font-medium text-base text-white dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-primary-200 dark:text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')"
                                        class="text-white dark:text-gray-200 hover:bg-primary-900 dark:hover:bg-gray-700">
                    Hồ sơ
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="text-white dark:text-gray-200 hover:bg-primary-900 dark:hover:bg-gray-700">
                        Đăng xuất
                    </x-responsive-nav-link>
                </form>
            </div>
        @endauth

        @guest
            <div class="px-4">
                <a href="{{ route('login') }}"
                   class="block w-full text-center text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 mb-2 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800 transition">
                    Bắt đầu ngay
                </a>
            </div>
        @endguest
    </div>
@else
    {{-- Desktop Version --}}
    <div class="hidden sm:flex sm:items-center sm:ms-6">
        @auth
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-primary-800 rounded-lg hover:bg-primary-900 focus:ring-4 focus:ring-primary-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600 dark:focus:ring-gray-800 transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ms-2">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')"
                                    class="text-gray-700 dark:text-gray-200 hover:bg-primary-100 dark:hover:bg-gray-700">
                        Hồ sơ
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="text-gray-700 dark:text-gray-200 hover:bg-primary-100 dark:hover:bg-gray-700">
                            Đăng xuất
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        @endauth

        @guest
            <a href="{{ route('login') }}"
               class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 me-2 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800 transition">
                Bắt đầu ngay
            </a>
        @endguest
    </div>
@endif