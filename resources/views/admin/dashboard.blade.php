<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-2xl text-[#0B1F33] tracking-tight">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="text-xs text-[#64748B] mt-0.5">
                    {{ __('Atlas11 Executive Overview & Platform Operations') }}
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-[#16A34A] hover:bg-[#15803D] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
                    {{ __('Manage Users') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="font-medium text-sm text-[#15803D] bg-emerald-50 p-4 rounded-xl border border-emerald-200 flex items-center">
                    <svg class="w-5 h-5 me-2 text-[#16A34A] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="font-medium text-sm text-red-700 bg-red-50 p-4 rounded-xl border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Platform Stats Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div class="bg-white rounded-xl p-6 border border-gray-200/80 shadow-sm border-t-4 border-t-[#0B1F33]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Total Users') }}</p>
                            <p class="text-3xl font-extrabold text-[#0B1F33] mt-2">{{ $stats['total_users'] }}</p>
                            <p class="text-xs text-[#64748B] mt-1">{{ $stats['total_admins'] }} {{ __('administrators') }}</p>
                        </div>
                        <div class="p-3 bg-slate-100 text-[#0B1F33] rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Players -->
                <div class="bg-white rounded-xl p-6 border border-gray-200/80 shadow-sm border-t-4 border-t-[#16A34A]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Players') }}</p>
                            <p class="text-3xl font-extrabold text-[#16A34A] mt-2">{{ $stats['total_players'] }}</p>
                            <p class="text-xs text-[#64748B] mt-1">{{ $stats['total_player_profiles'] }} {{ __('profiles created') }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 text-[#16A34A] rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Scouts -->
                <div class="bg-white rounded-xl p-6 border border-gray-200/80 shadow-sm border-t-4 border-t-amber-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Scouts') }}</p>
                            <p class="text-3xl font-extrabold text-amber-600 mt-2">{{ $stats['total_scouts'] }}</p>
                            <p class="text-xs text-[#64748B] mt-1">{{ $stats['total_scout_profiles'] }} {{ __('scout profiles') }}</p>
                        </div>
                        <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Scouting Interests -->
                <div class="bg-white rounded-xl p-6 border border-gray-200/80 shadow-sm border-t-4 border-t-[#0B1F33]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Scouting Interests') }}</p>
                            <p class="text-3xl font-extrabold text-[#0B1F33] mt-2">{{ $stats['total_scouting_interests'] }}</p>
                            <p class="text-xs text-[#64748B] mt-1">{{ $stats['pending_interests'] }} {{ __('pending') }} &bull; {{ $stats['contacted_interests'] }} {{ __('contacted') }}</p>
                        </div>
                        <div class="p-3 bg-slate-100 text-[#0B1F33] rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Two-Column Tables Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Users -->
                <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                        <h3 class="text-base font-bold text-[#0B1F33]">{{ __('Recently Registered Users') }}</h3>
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-[#16A34A] hover:text-[#15803D]">
                            {{ __('All Users &rarr;') }}
                        </a>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse ($recentUsers as $user)
                            <div class="py-3 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-[#0B1F33] text-white flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-[#0B1F33]">{{ $user->name }}</p>
                                        <p class="text-xs text-[#64748B]">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        @if ($user->role === 'admin') bg-purple-50 text-purple-700 border border-purple-200
                                        @elseif ($user->role === 'scout') bg-slate-100 text-[#0B1F33] border border-slate-300
                                        @else bg-emerald-50 text-[#16A34A] border border-emerald-200 @endif">
                                        {{ $user->role }}
                                    </span>
                                    <a href="{{ route('admin.users.show', $user) }}" class="text-xs font-bold text-[#0B1F33] hover:text-[#16A34A]">
                                        &rarr;
                                    </a>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-[#64748B] py-4">{{ __('No users found.') }}</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Scouting Inquiries -->
                <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                        <h3 class="text-base font-bold text-[#0B1F33]">{{ __('Recent Scouting Activity') }}</h3>
                        <a href="{{ route('scouting.interests.index') }}" class="text-xs font-bold text-[#16A34A] hover:text-[#15803D]">
                            {{ __('All Inquiries &rarr;') }}
                        </a>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse ($recentInterests as $interest)
                            <div class="py-3 flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-bold text-[#0B1F33]">
                                        <span class="text-[#16A34A]">{{ $interest->scout->name }}</span>
                                        <span class="text-gray-400">&rarr;</span>
                                        <span>{{ $interest->playerProfile->user->name }}</span>
                                    </p>
                                    <p class="text-xs text-[#64748B]">
                                        {{ $interest->scout->scoutProfile?->organization ?? __('Independent Scout') }} &bull; {{ $interest->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                        @if ($interest->status === 'pending') bg-amber-50 text-amber-800 border border-amber-200
                                        @elseif ($interest->status === 'contacted') bg-emerald-50 text-[#16A34A] border border-emerald-200
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $interest->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-[#64748B] py-4">{{ __('No scouting activity logged.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
