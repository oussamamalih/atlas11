<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-[#0B1F33] tracking-tight">
                    {{ __('Scouting Interest Details') }}
                </h2>
                <p class="text-xs text-[#64748B] mt-0.5">
                    {{ __('Official inquiry log and communications record') }}
                </p>
            </div>
            <a href="{{ route('scouting.interests.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold text-[#0B1F33] uppercase tracking-wider rounded-lg shadow-sm hover:bg-gray-50 transition">
                &larr; {{ __('Back to Interests') }}
            </a>
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

            <!-- Main Status Card -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-5">
                    <div>
                        <span class="text-[11px] uppercase font-bold text-gray-400 tracking-wider">{{ __('Interest Record') }} #{{ $interest->id }}</span>
                        <p class="text-xs text-[#64748B] mt-0.5 font-medium">
                            {{ __('Expressed on') }} {{ $interest->created_at->format('F j, Y \a\t g:i A') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full border
                            @if ($interest->status === 'pending') bg-amber-50 text-amber-800 border-amber-200
                            @elseif ($interest->status === 'contacted') bg-emerald-50 text-[#16A34A] border border-emerald-200
                            @else bg-gray-100 text-gray-800 border-gray-200 @endif">
                            {{ __($interest->status) }}
                        </span>
                    </div>
                </div>

                <!-- Scout & Player Summary Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
                    <!-- Scout Card -->
                    <div class="p-5 rounded-xl bg-[#F8FAFC] border border-gray-200">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#0B1F33]">{{ __('Scout / Organization') }}</span>
                        <div class="mt-3 flex items-start space-x-3">
                            <div class="h-11 w-11 rounded-lg bg-[#0B1F33] text-[#A3E635] flex items-center justify-center font-black text-base shrink-0 border border-[#16A34A]/30">
                                {{ strtoupper(substr($interest->scout->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-[#0B1F33] text-base truncate">{{ $interest->scout->name }}</h4>
                                <p class="text-xs font-bold text-[#16A34A] truncate">
                                    {{ $interest->scout->scoutProfile?->organization ?? __('Independent Scout') }}
                                </p>
                                <p class="text-xs text-[#64748B] mt-0.5">
                                    {{ $interest->scout->scoutProfile?->role_title ?? '' }}
                                    @if ($interest->scout->scoutProfile?->location)
                                        &bull; {{ $interest->scout->scoutProfile->location }}
                                    @endif
                                </p>
                                @if ($interest->scout->scoutProfile)
                                    <div class="mt-3">
                                        <a href="{{ route('scout.profile.show', $interest->scout->scoutProfile) }}" class="text-xs font-bold text-[#0B1F33] hover:text-[#16A34A] underline">
                                            {{ __('View Scout Credentials') }} &rarr;
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Player Card -->
                    <div class="p-5 rounded-xl bg-[#F8FAFC] border border-gray-200">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-[#16A34A]">{{ __('Player Talent') }}</span>
                        <div class="mt-3 flex items-start space-x-3">
                            <div class="h-11 w-11 rounded-lg bg-[#0B1F33] text-white flex items-center justify-center font-black text-base shrink-0 border border-[#16A34A]/30">
                                {{ strtoupper(substr($interest->playerProfile->user->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-bold text-[#0B1F33] text-base truncate">{{ $interest->playerProfile->user->name }}</h4>
                                <p class="text-xs font-bold text-[#16A34A]">
                                    {{ $interest->playerProfile->position }}
                                    @if ($interest->playerProfile->age)
                                        &bull; {{ $interest->playerProfile->age }} {{ __('yrs') }}
                                    @endif
                                </p>
                                <p class="text-xs text-[#64748B] mt-0.5 truncate">
                                    {{ $interest->playerProfile->location }}
                                    @if ($interest->playerProfile->current_club)
                                        &bull; {{ $interest->playerProfile->current_club }}
                                    @endif
                                </p>
                                <div class="mt-3">
                                    <a href="{{ route('player.profile.show', $interest->playerProfile) }}" class="text-xs font-bold text-[#16A34A] hover:text-[#15803D] underline">
                                        {{ __('View Full Football Profile') }} &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Section -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#0B1F33] mb-2">{{ __('Scout Message / Note') }}</h4>
                    @if ($interest->message)
                        <div class="bg-[#F8FAFC] p-4 rounded-xl text-sm text-[#111827] whitespace-pre-line leading-relaxed border border-gray-200">
                            {{ $interest->message }}
                        </div>
                    @else
                        <p class="text-xs text-[#64748B] italic">
                            {{ __('No personal message was attached with this interest invitation.') }}
                        </p>
                    @endif
                </div>

                <!-- Status Update Form -->
                <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="text-xs text-[#64748B]">
                        {{ __('Last updated') }}: {{ $interest->updated_at->diffForHumans() }}
                    </div>

                    <form method="POST" action="{{ route('scouting.interests.update', $interest) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')

                        <x-input-label for="status" :value="__('Update Status:')" class="text-xs !mb-0" />
                        <select id="status" name="status" class="text-xs border-gray-300 focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] rounded-lg shadow-sm">
                            <option value="pending" {{ $interest->status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="viewed" {{ $interest->status === 'viewed' ? 'selected' : '' }}>{{ __('Viewed') }}</option>
                            <option value="contacted" {{ $interest->status === 'contacted' ? 'selected' : '' }}>{{ __('Contacted') }}</option>
                            <option value="closed" {{ $interest->status === 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                        </select>

                        <x-primary-button class="py-1.5 px-3 text-xs">
                            {{ __('Update') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
