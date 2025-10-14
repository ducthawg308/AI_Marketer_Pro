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
            <x-auth-buttons />

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
        <x-auth-buttons responsive />
    </div>
</nav>