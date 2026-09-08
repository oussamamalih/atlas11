<nav x-data="{ open: false }" class="atlas-nav bg-[#0B1F33] border-b border-[#05111D] text-white shadow-md relative z-30">
    <!-- Primary Navigation Menu -->
    <div class="atlas-nav-inner max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Brand / Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center group">
                        <x-application-logo class="block h-9 w-auto text-white transition-transform group-hover:scale-105" />
                    </a>
                </div>

                <!-- Navigation Links (Role-Aware) -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if (Auth::user()->isPlayer())
                        <x-nav-link :href="route('player.profile.index')" :active="request()->routeIs('player.profile.*')">
                            {{ __('My Football Profile') }}
                        </x-nav-link>
                        <x-nav-link :href="route('scouting.interests.index')" :active="request()->routeIs('scouting.interests.*')">
                            {{ __('Interests') }}
                        </x-nav-link>
                    @elseif (Auth::user()->isScout())
                        <x-nav-link :href="route('scout.search')" :active="request()->routeIs('scout.search')">
                            {{ __('Search Players') }}
                        </x-nav-link>
                        <x-nav-link :href="route('scouting.interests.index')" :active="request()->routeIs('scouting.interests.*')">
                            {{ __('My Interests') }}
                        </x-nav-link>
                        <x-nav-link :href="route('scout.profile.index')" :active="request()->routeIs('scout.profile.*')">
                            {{ __('My Scout Profile') }}
                        </x-nav-link>
                    @elseif (Auth::user()->isAdmin())
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            {{ __('Admin Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                            {{ __('Manage Users') }}
                        </x-nav-link>
                    @endif

                    <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                        {{ __('Notifications') }}
                        @if (Auth::user()->unreadNotifications()->count() > 0)
                            <span class="ms-2 inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-[#0B1F33] bg-[#A3E635] rounded-full">
                                {{ Auth::user()->unreadNotifications()->count() }}
                            </span>
                        @endif
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings & Profile Area -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Notifications Quick Bell -->
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-300 hover:text-white hover:bg-[#102A43] rounded-lg transition focus:outline-none" title="{{ __('Notifications') }}">
                    <span class="sr-only">{{ __('View notifications') }}</span>
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    @if (Auth::user()->unreadNotifications()->count() > 0)
                        <span class="absolute top-1 end-1 inline-flex items-center justify-center min-w-[18px] h-[18px] px-1 text-[10px] font-extrabold leading-none text-[#0B1F33] transform translate-x-1/4 -translate-y-1/4 bg-[#A3E635] rounded-full">
                            {{ Auth::user()->unreadNotifications()->count() }}
                        </span>
                    @endif
                </a>

                <!-- User Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 border border-[#102A43] text-sm font-medium rounded-lg text-white bg-[#061320] hover:bg-[#102A43] focus:outline-none transition">
                            <span class="inline-block w-2 h-2 rounded-full bg-[#16A34A] me-2"></span>
                            <div class="font-medium text-xs">{{ Auth::user()->name }}</div>
                            <span class="ms-2 px-1.5 py-0.5 text-[10px] uppercase tracking-wider font-semibold rounded bg-[#102A43] text-slate-300">
                                {{ Auth::user()->role }}
                            </span>

                            <div class="ms-2">
                                <svg class="fill-current h-3.5 w-3.5 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-gray-100 text-xs">
                            <p class="font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-gray-500 truncate">{{ Auth::user()->email }}</p>
                        </div>

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Account Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="text-red-600 hover:text-red-700 hover:bg-red-50">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-lg text-slate-300 hover:text-white hover:bg-[#102A43] focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#061320] border-t border-[#102A43]">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user()->isPlayer())
                <x-responsive-nav-link :href="route('player.profile.index')" :active="request()->routeIs('player.profile.*')">
                    {{ __('My Football Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('scouting.interests.index')" :active="request()->routeIs('scouting.interests.*')">
                    {{ __('Interests') }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->isScout())
                <x-responsive-nav-link :href="route('scout.search')" :active="request()->routeIs('scout.search')">
                    {{ __('Search Players') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('scouting.interests.index')" :active="request()->routeIs('scouting.interests.*')">
                    {{ __('My Interests') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('scout.profile.index')" :active="request()->routeIs('scout.profile.*')">
                    {{ __('My Scout Profile') }}
                </x-responsive-nav-link>
            @elseif (Auth::user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    {{ __('Admin Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                    {{ __('Manage Users') }}
                </x-responsive-nav-link>
            @endif

            <x-responsive-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.*')">
                <div class="flex items-center justify-between">
                    <span>{{ __('Notifications') }}</span>
                    @if (Auth::user()->unreadNotifications()->count() > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-[#A3E635] text-[#0B1F33]">
                            {{ Auth::user()->unreadNotifications()->count() }} {{ __('new') }}
                        </span>
                    @endif
                </div>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-[#102A43] px-4">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-full bg-[#16A34A] text-white flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-semibold text-sm text-white">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-slate-400">{{ Auth::user()->email }} ({{ ucfirst(Auth::user()->role) }})</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Account Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="text-red-400 hover:text-red-300">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
