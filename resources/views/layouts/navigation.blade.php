<nav x-data="{ open: false }" class="bg-gradient-to-r from-primary to-primary-900 dark:from-gray-800 dark:to-gray-900 shadow-lg">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')"
                                class="text-white dark:text-gray-200 hover:text-primary-300 dark:hover:text-white font-medium transition">
                        Trang chủ
                    </x-nav-link>
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')"
                                class="text-white dark:text-gray-200 hover:text-primary-300 dark:hover:text-white font-medium transition">
                        Cộng đồng
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown / Auth Buttons -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    <!-- Nếu đã đăng nhập -->
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
                    <!-- Nếu chưa đăng nhập -->
                    <a href="{{ route('login') }}"
                    class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 me-2 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800 transition">
                        Bắt đầu ngay
                    </a>
                @endguest
            </div>
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white dark:text-gray-200 hover:text-primary-300 dark:hover:text-white hover:bg-primary-800 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-300 dark:focus:ring-gray-800 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-primary-800 dark:bg-gray-800">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')"
                                class="text-white dark:text-gray-200 hover:bg-primary-900 dark:hover:bg-gray-700">
                Trang chủ
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')"
                                class="text-white dark:text-gray-200 hover:bg-primary-900 dark:hover:bg-gray-700">
                Cộng đồng
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
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
    </div>
</nav>