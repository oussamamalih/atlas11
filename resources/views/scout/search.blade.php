<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Talent Discovery & Search') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Search & Filter Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('scout.search') }}" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        <!-- Keyword / Name -->
                        <div class="lg:col-span-2">
                            <x-input-label for="keyword" :value="__('Player Name or Keyword')" />
                            <x-text-input id="keyword" name="keyword" type="text" class="mt-1 block w-full" :value="request('keyword')" placeholder="Search by name, club, or bio..." />
                        </div>

                        <!-- Position -->
                        <div>
                            <x-input-label for="position" :value="__('Position')" />
                            <select id="position" name="position" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">{{ __('All Positions') }}</option>
                                @foreach ($positions as $pos)
                                    <option value="{{ $pos }}" {{ request('position') === $pos ? 'selected' : '' }}>
                                        {{ __($pos) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- City / Location -->
                        <div>
                            <x-input-label for="location" :value="__('City / Region')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="request('location')" placeholder="e.g. Casablanca" />
                        </div>

                        <!-- Age Range -->
                        <div>
                            <x-input-label for="min_age" :value="__('Min Age')" />
                            <x-text-input id="min_age" name="min_age" type="number" min="12" max="45" class="mt-1 block w-full" :value="request('min_age')" placeholder="16" />
                        </div>

                        <div>
                            <x-input-label for="max_age" :value="__('Max Age')" />
                            <x-text-input id="max_age" name="max_age" type="number" min="12" max="45" class="mt-1 block w-full" :value="request('max_age')" placeholder="23" />
                        </div>
                    </div>

                    <!-- Additional Row: Preferred Foot & Actions -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
                        <div class="w-full sm:w-64">
                            <x-input-label for="preferred_foot" :value="__('Preferred Foot')" />
                            <select id="preferred_foot" name="preferred_foot" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">{{ __('Any Foot') }}</option>
                                @foreach ($preferredFeet as $foot)
                                    <option value="{{ $foot }}" {{ request('preferred_foot') === $foot ? 'selected' : '' }}>
                                        {{ __($foot) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex items-center gap-3 self-end sm:self-auto">
                            @if (request()->hasAny(['keyword', 'position', 'location', 'min_age', 'max_age', 'preferred_foot']))
                                <a href="{{ route('scout.search') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                    {{ __('Clear Filters') }}
                                </a>
                            @endif
                            <x-primary-button>
                                <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{ __('Search Talents') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Results Section -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ __('Search Results') }}
                        <span class="text-sm font-normal text-gray-500 ms-2">
                            ({{ $players->total() }} {{ trans_choice('talent found|talents found', $players->total()) }})
                        </span>
                    </h3>
                </div>

                @if ($players->isEmpty())
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">{{ __('No players found') }}</h4>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ __('We could not find any player profiles matching your criteria. Try adjusting or clearing your filters.') }}
                        </p>
                        @if (request()->hasAny(['keyword', 'position', 'location', 'min_age', 'max_age', 'preferred_foot']))
                            <div class="mt-6">
                                <a href="{{ route('scout.search') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                                    {{ __('Reset Filters') }}
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($players as $player)
                            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-150 overflow-hidden border border-gray-100 flex flex-col justify-between">
                                <div class="p-6">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-12 w-12 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shadow-sm shrink-0">
                                                {{ strtoupper(substr($player->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-lg hover:text-indigo-600 transition">
                                                    {{ $player->user->name }}
                                                </h4>
                                                <p class="text-sm text-gray-500 flex items-center mt-0.5">
                                                    <svg class="w-3.5 h-3.5 me-1 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    </svg>
                                                    {{ $player->location }}
                                                </p>
                                            </div>
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 shrink-0">
                                            {{ $player->position }}
                                        </span>
                                    </div>

                                    <!-- Quick Stats Grid -->
                                    <div class="mt-5 grid grid-cols-3 gap-2 py-3 px-2 bg-gray-50 rounded-md text-center text-xs">
                                        <div>
                                            <span class="text-gray-400 uppercase font-semibold">{{ __('Age') }}</span>
                                            <p class="font-bold text-gray-800 mt-0.5">{{ $player->age ? $player->age . ' yrs' : '—' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-400 uppercase font-semibold">{{ __('Foot') }}</span>
                                            <p class="font-bold text-gray-800 mt-0.5">{{ $player->preferred_foot ?? '—' }}</p>
                                        </div>
                                        <div>
                                            <span class="text-gray-400 uppercase font-semibold">{{ __('Height') }}</span>
                                            <p class="font-bold text-gray-800 mt-0.5">{{ $player->height ? $player->height . 'cm' : '—' }}</p>
                                        </div>
                                    </div>

                                    @if ($player->current_club)
                                        <div class="mt-3 text-xs text-emerald-700 font-medium flex items-center">
                                            <svg class="w-3.5 h-3.5 me-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            {{ $player->current_club }}
                                        </div>
                                    @endif

                                    @if ($player->bio)
                                        <p class="mt-3 text-xs text-gray-600 line-clamp-2">
                                            {{ $player->bio }}
                                        </p>
                                    @endif
                                </div>

                                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-end">
                                    <a href="{{ route('player.profile.show', $player) }}" class="inline-flex items-center text-xs font-semibold text-indigo-600 hover:text-indigo-900">
                                        {{ __('View Full Profile') }}
                                        <svg class="w-3.5 h-3.5 ms-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $players->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
