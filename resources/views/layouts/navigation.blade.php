<nav x-data="{ open: false }" class="h-screen bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 fixed top-0 left-0 w-64 z-40 flex flex-col">
    <div class="flex flex-col h-full">
        
        <!-- Logo -->
        <div class="shrink-0 flex items-center justify-center h-24 px-4 border-b border-gray-200 dark:border-gray-700 mt-4">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('logo/Logo-93df826a-e0df-42cb-a1db-7088bae4938e.png') }}" alt="Logo" class="block h-13 w-auto">
            </a>
        </div>

        <!-- ALL Navigation Links in ONE container -->
        <div class="flex flex-col py-4 px-2 space-y-5">

            <!-- Home -->
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                </svg>
                <span class="text-xl">{{ __('Home') }}</span>
            </x-nav-link>

            <!-- Rooms -->
            <x-nav-link :href="route('rooms')" :active="request()->routeIs('rooms')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
                <span class="text-xl">{{ __('Rooms') }}</span>
            </x-nav-link>

            <!-- Payment -->
            <x-nav-link :href="route('payment')" :active="request()->routeIs('payment')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
                </svg>
                <span class="text-xl">{{ __('Payment') }}</span>
            </x-nav-link>

            <!-- Concerns -->
            <x-nav-link :href="route('concerns')" :active="request()->routeIs('concerns')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
                <span class="text-xl">{{ __('Concerns') }}</span>
            </x-nav-link>

            <!-- Notifications -->
            <x-nav-link :href="route('notifications')" :active="request()->routeIs('notifications')">
                <div class="relative mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                    @if(($unreadCount ?? 0) > 0)
                        <span class="absolute -top-1 -right-1 flex items-center justify-center w-4 h-4 bg-red-500 text-white text-xs font-bold rounded-full">
                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                        </span>
                    @endif
                </div>
                <span class="text-xl">{{ __('Notifications') }}</span>
            </x-nav-link>

        </div>

        <!-- Spacer to push settings to bottom -->
        <div class="flex-1"></div>

        <!-- Settings Dropdown (pinned to bottom) -->
        <div class="px-4 pb-4">
            <x-dropdown align="top" width="48">
                <x-slot name="trigger">
                    <button class="w-full flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                        <div>
                            <span class="text-lg">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="ms-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.partials.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Hamburger for mobile -->
        <div class="sm:hidden px-4 pb-4">
            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden fixed inset-0 z-50 bg-black bg-opacity-50">
        <div class="w-64 bg-white dark:bg-gray-800 h-full flex flex-col">
            <div class="pt-2 pb-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Home') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rooms')" :active="request()->routeIs('rooms')">
                    {{ __('Rooms') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('payment')" :active="request()->routeIs('payment')">
                    {{ __('Payment') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('concerns')" :active="request()->routeIs('concerns')">
                    {{ __('Concerns') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('notifications')" :active="request()->routeIs('notifications')">
                    {{ __('Notifications') }}
                    @if(($unreadCount ?? 0) > 0)
                        <span class="ml-2 px-1.5 py-0.5 text-xs bg-red-500 text-white rounded-full">{{ $unreadCount }}</span>
                    @endif
                </x-responsive-nav-link>
            </div>
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600 px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.partials.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>