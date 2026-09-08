<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Player Profile') }}
            </h2>

            @if (Auth::id() === $profile->user_id)
                <a href="{{ route('player.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    {{ __('Edit My Profile') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
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

            @if (Auth::user()?->isScout())
                @php
                    $existingInterest = \App\Models\ScoutingInterest::where('scout_id', Auth::id())
                        ->where('player_profile_id', $profile->id)
                        ->first();
                @endphp

                @if ($existingInterest)
                    <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-600 text-white font-bold text-sm">
                                ✓
                            </span>
                            <div>
                                <h4 class="text-sm font-semibold text-indigo-900">{{ __('Scouting Interest Expressed') }}</h4>
                                <p class="text-xs text-indigo-700">
                                    {{ __('You expressed interest on') }} {{ $existingInterest->created_at->format('M d, Y') }} — 
                                    <span class="font-semibold uppercase tracking-wider">{{ __($existingInterest->status) }}</span>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('scouting.interests.show', $existingInterest) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-900 underline">
                            {{ __('View Interest Details') }} &rarr;
                        </a>
                    </div>
                @else
                    <div x-data="{ open: false }" class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h4 class="text-sm font-semibold text-emerald-900">{{ __('Interested in Scouting this Talent?') }}</h4>
                                <p class="text-xs text-emerald-700">
                                    {{ __('Express your official scouting interest to start a dialogue and track this player.') }}
                                </p>
                            </div>
                            <button @click="open = !open" type="button" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700">
                                {{ __('Express Interest') }}
                            </button>
                        </div>

                        <form x-show="open" x-cloak method="POST" action="{{ route('scouting.interests.store', $profile) }}" class="mt-4 pt-4 border-t border-emerald-200 space-y-3">
                            @csrf
                            <div>
                                <x-input-label for="message" :value="__('Message or Trial Invitation (Optional)')" class="text-emerald-900" />
                                <textarea id="message" name="message" rows="3" class="mt-1 block w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm text-sm" placeholder="Introduce yourself or describe what caught your eye in this player..."></textarea>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button @click="open = false" type="button" class="px-3 py-1.5 text-xs text-gray-600 hover:text-gray-900">
                                    {{ __('Cancel') }}
                                </button>
                                <x-primary-button class="bg-emerald-700 hover:bg-emerald-800">
                                    {{ __('Send Scouting Interest') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                @endif
            @endif

            <!-- Main Header Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="h-20 w-20 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-3xl shadow">
                            {{ strtoupper(substr($profile->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $profile->user->name }}</h1>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    {{ $profile->position }}
                                </span>
                            </div>
                            <div class="mt-1 flex items-center text-sm text-gray-500 gap-4 flex-wrap">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $profile->location }}
                                </span>
                                @if ($profile->age)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $profile->age }} {{ __('years old') }}
                                    </span>
                                @endif
                                @if ($profile->current_club)
                                    <span class="flex items-center font-medium text-emerald-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        {{ $profile->current_club }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Key Attributes Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-lg shadow-sm text-center border-t-4 border-emerald-500">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ __('Position') }}</span>
                    <p class="mt-2 text-lg font-bold text-gray-800">{{ $profile->position }}</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-sm text-center border-t-4 border-indigo-500">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ __('Preferred Foot') }}</span>
                    <p class="mt-2 text-lg font-bold text-gray-800">{{ $profile->preferred_foot ?? '—' }}</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-sm text-center border-t-4 border-sky-500">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ __('Height') }}</span>
                    <p class="mt-2 text-lg font-bold text-gray-800">{{ $profile->height ? $profile->height . ' cm' : '—' }}</p>
                </div>

                <div class="bg-white p-5 rounded-lg shadow-sm text-center border-t-4 border-amber-500">
                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">{{ __('Weight') }}</span>
                    <p class="mt-2 text-lg font-bold text-gray-800">{{ $profile->weight ? $profile->weight . ' kg' : '—' }}</p>
                </div>
            </div>

            <!-- Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <!-- Football Details & Personal Info -->
                <div class="border-b border-gray-100 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Football Profile Details') }}</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Date of Birth') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">
                                {{ optional($profile->date_of_birth)->format('F j, Y') }}
                                @if ($profile->age)
                                    ({{ $profile->age }} {{ __('years old') }})
                                @endif
                            </dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Location') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->location }}</dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Current Club / Academy') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->current_club ?? __('Not specified') }}</dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Contact Phone') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->phone ?? __('Not specified') }}</dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->user->email }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Football Experience -->
                @if ($profile->football_experience)
                    <div class="border-b border-gray-100 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Football Experience') }}</h3>
                        <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $profile->football_experience }}
                        </p>
                    </div>
                @endif

                <!-- Bio -->
                @if ($profile->bio)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('About Player') }}</h3>
                        <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $profile->bio }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
