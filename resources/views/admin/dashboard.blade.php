<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                    {{ __('Manage Users') }}
                </a>
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

            @if (session('error'))
                <div class="font-medium text-sm text-red-700 bg-red-50 p-4 rounded-md border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Platform Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Total Users') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['total_users'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $stats['total_admins'] }} {{ __('administrators') }}</p>
                        </div>
                        <div class="p-3 bg-indigo-50 text-indigo-600 rounded-full">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Players -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Players') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['total_players'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $stats['total_player_profiles'] }} {{ __('profiles created') }}</p>
                        </div>
                        <div class="p-3 bg-green-50 text-green-600 rounded-full">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Scouts -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-amber-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Scouts') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['total_scouts'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $stats['total_scout_profiles'] }} {{ __('scout profiles') }}</p>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-full">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Scouting Interests -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-600">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ __('Scouting Interests') }}</p>
                            <p class="text-3xl font-extrabold text-gray-900 mt-2">{{ $stats['total_scouting_interests'] }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $stats['pending_interests'] }} {{ __('pending') }} &bull; {{ $stats['contacted_interests'] }} {{ __('contacted') }}</p>
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-600 rounded-full">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two-Column Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                        <h3 class="text-base font-bold text-gray-900">{{ __('Recently Registered Users') }}</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            {{ __('View All &rarr;') }}
                        </a>
                    </div>

                    @if ($recentUsers->isEmpty())
                        <p class="text-sm text-gray-500 py-4">{{ __('No users found.') }}</p>
                    @else
                        <div class="divide-y divide-gray-100">
                            @foreach ($recentUsers as $user)
                                <div class="py-3 flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }} &bull; {{ $user->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if ($user->isAdmin())
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-purple-100 text-purple-800">Admin</span>
                                        @elseif ($user->isScout())
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-amber-100 text-amber-800">Scout</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-green-100 text-green-800">Player</span>
                                        @endif
                                        <a href="{{ route('admin.users.show', $user) }}" class="text-xs text-gray-500 hover:text-indigo-600 font-medium">
                                            {{ __('Details') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Recent Scouting Activities -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                        <h3 class="text-base font-bold text-gray-900">{{ __('Recent Scouting Interests') }}</h3>
                        <a href="{{ route('scouting.interests.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                            {{ __('View Platform Feed &rarr;') }}
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
                                            {{ $interest->scout->scoutProfile?->organization ?? 'Independent Scout' }} &bull; {{ $interest->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    <div>
                                        <span class="px-2 py-0.5 rounded text-xs font-semibold uppercase tracking-wider
                                            @if ($interest->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif ($interest->status === 'viewed') bg-blue-100 text-blue-800
                                            @elseif ($interest->status === 'contacted') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $interest->status }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
