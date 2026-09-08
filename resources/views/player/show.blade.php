<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-[#0B1F33] tracking-tight">
                    {{ __('Player Profile') }}
                </h2>
                <p class="text-xs text-[#64748B] mt-0.5">
                    {{ __('Official Moroccan Football Scouting Dossier') }}
                </p>
            </div>

            @if (Auth::id() === $profile->user_id)
                <a href="{{ route('player.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-[#0B1F33] hover:bg-[#102A43] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
                    <svg class="w-4 h-4 me-1.5 text-[#A3E635]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    {{ __('Edit My Profile') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
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

            @if (Auth::user()?->isScout())
                @php
                    $existingInterest = \App\Models\ScoutingInterest::where('scout_id', Auth::id())
                        ->where('player_profile_id', $profile->id)
                        ->first();
                @endphp

                @if ($existingInterest)
                    <div class="bg-emerald-50/80 border border-emerald-200 rounded-xl p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3 shadow-sm">
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-[#16A34A] text-white font-black text-sm">
                                ✓
                            </span>
                            <div>
                                <h4 class="text-sm font-bold text-[#0B1F33]">{{ __('Scouting Interest Expressed') }}</h4>
                                <p class="text-xs text-[#64748B]">
                                    {{ __('You expressed interest on') }} {{ $existingInterest->created_at->format('M d, Y') }} — 
                                    <span class="font-bold uppercase tracking-wider text-[#16A34A]">{{ __($existingInterest->status) }}</span>
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('scouting.interests.show', $existingInterest) }}" class="inline-flex items-center text-xs font-bold text-[#0B1F33] hover:text-[#16A34A] underline underline-offset-2">
                            {{ __('View Interest Details') }} &rarr;
                        </a>
                    </div>
                @else
                    <div x-data="{ open: false }" class="bg-white border border-emerald-200 rounded-xl p-5 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                            <div>
                                <h4 class="text-sm font-bold text-[#0B1F33]">{{ __('Interested in Scouting this Talent?') }}</h4>
                                <p class="text-xs text-[#64748B] mt-0.5">
                                    {{ __('Express your official scouting interest to start a dialogue and track this player.') }}
                                </p>
                            </div>
                            <button @click="open = !open" type="button" class="inline-flex items-center justify-center px-4 py-2 bg-[#16A34A] hover:bg-[#15803D] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
                                {{ __('Express Interest') }}
                            </button>
                        </div>

                        <form x-show="open" x-cloak method="POST" action="{{ route('scouting.interests.store', $profile) }}" class="mt-4 pt-4 border-t border-gray-100 space-y-3">
                            @csrf
                            <div>
                                <x-input-label for="message" :value="__('Message or Trial Invitation (Optional)')" />
                                <textarea id="message" name="message" rows="3" class="mt-1 block w-full border-gray-300 focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] rounded-lg shadow-sm text-sm" placeholder="Introduce yourself, club affiliation, or describe trial opportunities..."></textarea>
                            </div>
                            <div class="flex justify-end items-center gap-3">
                                <button @click="open = false" type="button" class="px-3 py-1.5 text-xs font-semibold text-gray-500 hover:text-gray-800">
                                    {{ __('Cancel') }}
                                </button>
                                <x-primary-button>
                                    {{ __('Send Scouting Interest') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                @endif
            @endif

            <!-- Main Dossier Header Card -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <div class="flex items-center space-x-5">
                        <div class="h-20 w-20 rounded-2xl bg-[#0B1F33] text-white flex items-center justify-center font-black text-3xl shadow-md shrink-0 border-2 border-[#16A34A]">
                            {{ strtoupper(substr($profile->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <h1 class="text-2xl font-extrabold text-[#0B1F33]">{{ $profile->user->name }}</h1>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-[#16A34A] border border-emerald-200">
                                    {{ $profile->position }}
                                </span>
                            </div>
                            <div class="mt-2 flex items-center text-xs text-[#64748B] gap-4 flex-wrap">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $profile->location }}
                                </span>
                                @if ($profile->age)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $profile->age }} {{ __('years old') }}
                                    </span>
                                @endif
                                @if ($profile->current_club)
                                    <span class="flex items-center font-bold text-[#16A34A]">
                                        <svg class="w-4 h-4 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                <div class="bg-white p-4 rounded-xl shadow-sm text-center border border-gray-200/80 border-t-4 border-t-[#0B1F33]">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ __('Position') }}</span>
                    <p class="mt-1 text-base font-extrabold text-[#0B1F33]">{{ $profile->position }}</p>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm text-center border border-gray-200/80 border-t-4 border-t-[#16A34A]">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ __('Preferred Foot') }}</span>
                    <p class="mt-1 text-base font-extrabold text-[#0B1F33]">{{ $profile->preferred_foot ?? '—' }}</p>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm text-center border border-gray-200/80 border-t-4 border-t-[#0B1F33]">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ __('Height') }}</span>
                    <p class="mt-1 text-base font-extrabold text-[#0B1F33]">{{ $profile->height ? $profile->height . ' cm' : '—' }}</p>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm text-center border border-gray-200/80 border-t-4 border-t-amber-500">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-gray-400">{{ __('Weight') }}</span>
                    <p class="mt-1 text-base font-extrabold text-[#0B1F33]">{{ $profile->weight ? $profile->weight . ' kg' : '—' }}</p>
                </div>
            </div>

            <!-- Details Card -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6 space-y-6">
                <!-- Football Details & Personal Info -->
                <div class="border-b border-gray-100 pb-6">
                    <h3 class="text-base font-bold text-[#0B1F33] mb-4">{{ __('Football Profile Details') }}</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-xs">
                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Date of Birth') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">
                                {{ optional($profile->date_of_birth)->format('F j, Y') }}
                                @if ($profile->age)
                                    <span class="text-[#64748B] font-medium text-xs">({{ $profile->age }} {{ __('years old') }})</span>
                                @endif
                            </dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Location') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->location }}</dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Current Club / Academy') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->current_club ?? __('Free Agent / Unaffiliated') }}</dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Contact Phone') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->phone ?? __('Not specified') }}</dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100 sm:col-span-2">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->user->email }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Football Experience -->
                @if ($profile->football_experience)
                    <div class="border-b border-gray-100 pb-6">
                        <h3 class="text-base font-bold text-[#0B1F33] mb-2">{{ __('Football Experience') }}</h3>
                        <div class="p-4 bg-[#F8FAFC] rounded-lg border border-gray-100 text-sm text-[#111827] whitespace-pre-line leading-relaxed">
                            {{ $profile->football_experience }}
                        </div>
                    </div>
                @endif

                <!-- Bio -->
                @if ($profile->bio)
                    <div>
                        <h3 class="text-base font-bold text-[#0B1F33] mb-2">{{ __('About Player') }}</h3>
                        <div class="p-4 bg-[#F8FAFC] rounded-lg border border-gray-100 text-sm text-[#111827] whitespace-pre-line leading-relaxed">
                            {{ $profile->bio }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
