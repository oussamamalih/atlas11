<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @if ($user->isPlayer())
                    {{ __('Player Dashboard') }}
                @elseif ($user->isScout())
                    {{ __('Scout Dashboard') }}
                @else
                    {{ __('Administrator Overview') }}
                @endif
            </h2>

            <div>
                @if ($user->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-semibold uppercase tracking-wider rounded-md transition shadow-sm">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ __('Full Admin Dashboard') }}
                    </a>
                @elseif ($user->isScout())
                    <a href="{{ route('scout.search') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold uppercase tracking-wider rounded-md transition shadow-sm">
                        <svg class="w-4 h-4 me-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        {{ __('Search Players') }}
                    </a>
                @else
                    @if ($playerProfile)
                        <a href="{{ route('player.profile.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold uppercase tracking-wider rounded-md transition shadow-sm">
                            {{ __('My Football Profile') }}
                        </a>
                    @else
                        <a href="{{ route('player.profile.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold uppercase tracking-wider rounded-md transition shadow-sm">
                            {{ __('Create Profile') }}
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="font-medium text-sm text-green-700 bg-green-50 p-4 rounded-md border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Welcome Header Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">
                            {{ __('Welcome back,') }} {{ $user->name }}!
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            @if ($user->isPlayer())
                                {{ __('Track scout inquiries, manage your football profile, and monitor club interest in your talent.') }}
                            @elseif ($user->isScout())
                                {{ __('Discover Moroccan football talent, connect with promising players, and manage your scouting shortlist.') }}
                            @else
                                {{ __('Atlas11 Administrator Portal: Overview of users, scouting activity, and platform metrics.') }}
                            @endif
                        </p>
                    </div>
                    <div>
                        @if ($user->isPlayer())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                {{ __('Player Account') }}
                            </span>
                        @elseif ($user->isScout())
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                {{ __('Verified Scout') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                {{ __('Administrator') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- PLAYER DASHBOARD CONTENT -->
            @if ($user->isPlayer())
                @if (!$playerProfile)
                    <!-- Incomplete Profile Banner -->
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-r-lg shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h4 class="text-base font-bold text-amber-800">{{ __('Complete Your Football Profile') }}</h4>
                                <p class="text-sm text-amber-700 mt-1">
                                    {{ __('Your football profile is currently empty. Add your position, birth date, club, and experience so scouts can discover your talent.') }}
                                </p>
                            </div>
                            <a href="{{ route('player.profile.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs uppercase tracking-wider rounded-md transition whitespace-nowrap">
                                {{ __('Create Football Profile') }} &rarr;
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Player Metrics Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Total Scouting Interests') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalInterestsCount }}</p>
                            <a href="{{ route('scouting.interests.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium mt-2 inline-block">
                                {{ __('View inquiries &rarr;') }}
                            </a>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Pending Inquiries') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $pendingInterestsCount }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ __('Awaiting scout review / trials') }}</p>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-600">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Unread Notifications') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $unreadNotificationsCount }}</p>
                            <a href="{{ route('notifications.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium mt-2 inline-block">
                                {{ __('Check notifications &rarr;') }}
                            </a>
                        </div>
                    </div>

                    <!-- Player Profile Snapshot Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                            <h3 class="text-base font-bold text-gray-900">{{ __('My Football Profile Overview') }}</h3>
                            <div class="space-x-2">
                                <a href="{{ route('player.profile.edit') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    {{ __('Edit Profile') }}
                                </a>
                                <span class="text-gray-300">&bull;</span>
                                <a href="{{ route('player.profile.index') }}" class="text-xs font-semibold text-gray-600 hover:text-gray-800">
                                    {{ __('Full View &rarr;') }}
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Position') }}</span>
                                <p class="font-bold text-indigo-600 mt-0.5">{{ $playerProfile->position }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Location') }}</span>
                                <p class="font-semibold text-gray-900 mt-0.5">{{ $playerProfile->location }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Age') }}</span>
                                <p class="font-semibold text-gray-900 mt-0.5">{{ $playerProfile->age }} {{ __('years old') }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Current Club') }}</span>
                                <p class="font-semibold text-gray-900 mt-0.5">{{ $playerProfile->current_club ?? __('Free Agent') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Scouting Interests for Player -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                            <h3 class="text-base font-bold text-gray-900">{{ __('Recent Scouting Interest Received') }}</h3>
                            <a href="{{ route('scouting.interests.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                {{ __('All Inquiries &rarr;') }}
                            </a>
                        </div>

                        @if ($recentInterests->isEmpty())
                            <div class="py-8 text-center">
                                <p class="text-sm text-gray-500">{{ __('No scouting inquiries received yet.') }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ __('Make sure your profile details are accurate to maximize your discovery chances.') }}</p>
                            </div>
                        @else
                            <div class="divide-y divide-gray-100">
                                @foreach ($recentInterests as $interest)
                                    <div class="py-3 flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $interest->scout->name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $interest->scout->scoutProfile?->organization ?? __('Independent Scout') }} &bull; {{ $interest->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider
                                                @if ($interest->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif ($interest->status === 'viewed') bg-blue-100 text-blue-800
                                                @elseif ($interest->status === 'contacted') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $interest->status }}
                                            </span>
                                            <a href="{{ route('scouting.interests.show', $interest) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                                {{ __('Details') }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

            <!-- SCOUT DASHBOARD CONTENT -->
            @elseif ($user->isScout())
                @if (!$scoutProfile)
                    <!-- Incomplete Scout Profile Banner -->
                    <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded-r-lg shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h4 class="text-base font-bold text-amber-800">{{ __('Complete Your Scout Profile') }}</h4>
                                <p class="text-sm text-amber-700 mt-1">
                                    {{ __('Add your club, academy, or agency affiliation to build trust with players and access talent scout tools.') }}
                                </p>
                            </div>
                            <a href="{{ route('scout.profile.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs uppercase tracking-wider rounded-md transition whitespace-nowrap">
                                {{ __('Create Scout Profile') }} &rarr;
                            </a>
                        </div>
                    </div>
                @else
                    <!-- Scout Metrics Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Talents Tracked') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $totalInterestsCount }}</p>
                            <a href="{{ route('scouting.interests.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium mt-2 inline-block">
                                {{ __('View tracked players &rarr;') }}
                            </a>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Pending Contacts') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $pendingInterestsCount }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ __('Awaiting player confirmation') }}</p>
                        </div>

                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-600">
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Contacted Talents') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $contactedInterestsCount }}</p>
                            <p class="text-xs text-gray-400 mt-2">{{ __('Official trials / discussions') }}</p>
                        </div>
                    </div>

                    <!-- Scout Profile Snapshot Card -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                            <h3 class="text-base font-bold text-gray-900">{{ __('My Scout Affiliation') }}</h3>
                            <div class="space-x-2">
                                <a href="{{ route('scout.profile.edit') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                    {{ __('Edit Profile') }}
                                </a>
                                <span class="text-gray-300">&bull;</span>
                                <a href="{{ route('scout.profile.index') }}" class="text-xs font-semibold text-gray-600 hover:text-gray-800">
                                    {{ __('Full View &rarr;') }}
                                </a>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Organization') }}</span>
                                <p class="font-bold text-indigo-600 mt-0.5">{{ $scoutProfile->organization }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Role Title') }}</span>
                                <p class="font-semibold text-gray-900 mt-0.5">{{ $scoutProfile->role_title ?? __('Scout') }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Base Location') }}</span>
                                <p class="font-semibold text-gray-900 mt-0.5">{{ $scoutProfile->location }}</p>
                            </div>
                            <div>
                                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Experience') }}</span>
                                <p class="font-semibold text-gray-900 mt-0.5">{{ $scoutProfile->experience_years ? $scoutProfile->experience_years . ' yrs' : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Search Callout Banner -->
                    <div class="bg-gradient-to-r from-indigo-700 to-blue-600 rounded-lg p-6 text-white shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div>
                            <h4 class="text-lg font-bold">{{ __('Discover Football Talents Across Morocco') }}</h4>
                            <p class="text-xs text-indigo-100 mt-1">
                                {{ __('Filter by position, city, age, and preferred foot to find your next academy star or first-team recruit.') }}
                            </p>
                        </div>
                        <a href="{{ route('scout.search') }}" class="inline-flex items-center px-4 py-2.5 bg-white text-indigo-700 font-bold text-xs uppercase tracking-wider rounded-md shadow hover:bg-indigo-50 transition whitespace-nowrap">
                            {{ __('Search Players Now') }} &rarr;
                        </a>
                    </div>

                    <!-- Recent Scouting Activities for Scout -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                            <h3 class="text-base font-bold text-gray-900">{{ __('Recent Talents Expressed Interest In') }}</h3>
                            <a href="{{ route('scouting.interests.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                {{ __('All Tracked Talents &rarr;') }}
                            </a>
                        </div>

                        @if ($recentInterests->isEmpty())
                            <div class="py-8 text-center">
                                <p class="text-sm text-gray-500">{{ __('You have not expressed interest in any players yet.') }}</p>
                                <div class="mt-3">
                                    <a href="{{ route('scout.search') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                        {{ __('Browse player profiles to get started &rarr;') }}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="divide-y divide-gray-100">
                                @foreach ($recentInterests as $interest)
                                    <div class="py-3 flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $interest->playerProfile->user->name }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $interest->playerProfile->position }} &bull; {{ $interest->playerProfile->location }} &bull; {{ $interest->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-3">
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider
                                                @if ($interest->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif ($interest->status === 'viewed') bg-blue-100 text-blue-800
                                                @elseif ($interest->status === 'contacted') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ $interest->status }}
                                            </span>
                                            <a href="{{ route('scouting.interests.show', $interest) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                                {{ __('Details') }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

            <!-- ADMIN DASHBOARD CONTENT -->
            @elseif ($user->isAdmin())
                <!-- Admin Quick Access Card -->
                <div class="bg-gradient-to-r from-purple-700 to-indigo-800 text-white rounded-lg p-6 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h4 class="text-lg font-bold">{{ __('Administrator Control Center') }}</h4>
                        <p class="text-xs text-purple-100 mt-1">
                            {{ __('Manage platform users, monitor registrations, oversee scouting inquiries, and configure system rules.') }}
                        </p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white text-purple-800 font-bold text-xs uppercase tracking-wider rounded-md shadow hover:bg-purple-50 transition">
                            {{ __('Admin Dashboard') }}
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-900/60 border border-purple-300 text-white font-bold text-xs uppercase tracking-wider rounded-md hover:bg-purple-900 transition">
                            {{ __('Manage Users') }}
                        </a>
                    </div>
                </div>

                <!-- Admin Platform Metrics -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Total Registered Users') }}</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $adminStats['total_users'] }}</p>
                        <a href="{{ route('admin.users.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium mt-2 inline-block">
                            {{ __('View all users &rarr;') }}
                        </a>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-600">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Total Players') }}</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $adminStats['total_players'] }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $adminStats['total_player_profiles'] }} {{ __('profiles active') }}</p>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-amber-500">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Total Scouts') }}</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $adminStats['total_scouts'] }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $adminStats['total_scout_profiles'] }} {{ __('verified scouts') }}</p>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-600">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Scouting Interests') }}</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $adminStats['total_scouting_interests'] }}</p>
                        <a href="{{ route('scouting.interests.index') }}" class="text-xs text-blue-600 hover:text-blue-800 font-medium mt-2 inline-block">
                            {{ __('View activity log &rarr;') }}
                        </a>
                    </div>
                </div>

                <!-- Recent Platform Interests for Admin -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                        <h3 class="text-base font-bold text-gray-900">{{ __('Latest Platform Scouting Inquiries') }}</h3>
                        <a href="{{ route('admin.dashboard') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            {{ __('Full Admin Dashboard &rarr;') }}
                        </a>
                    </div>

                    @if ($recentInterests->isEmpty())
                        <p class="text-sm text-gray-500 py-4">{{ __('No scouting interests logged yet.') }}</p>
                    @else
                        <div class="divide-y divide-gray-100">
                            @foreach ($recentInterests as $interest)
                                <div class="py-3 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            <span class="text-indigo-600">{{ $interest->scout->name }}</span>
                                            <span class="text-gray-400">&rarr;</span>
                                            <span>{{ $interest->playerProfile->user->name }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ $interest->scout->scoutProfile?->organization ?? __('Independent Scout') }} &bull; {{ $interest->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider
                                            @if ($interest->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif ($interest->status === 'viewed') bg-blue-100 text-blue-800
                                            @elseif ($interest->status === 'contacted') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $interest->status }}
                                        </span>
                                        <a href="{{ route('scouting.interests.show', $interest) }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-800">
                                            {{ __('Details') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
