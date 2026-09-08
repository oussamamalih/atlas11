<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Scouting Interest Details') }}
            </h2>
            <a href="{{ route('scouting.interests.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-semibold">
                &larr; {{ __('Back to Interests') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="font-medium text-sm text-green-700 bg-green-50 p-4 rounded-md border border-green-200">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Main Status Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-100 pb-4">
                    <div>
                        <span class="text-xs uppercase font-semibold text-gray-400 tracking-wider">{{ __('Interest Record') }} #{{ $interest->id }}</span>
                        <p class="text-sm text-gray-500 mt-0.5">
                            {{ __('Expressed on') }} {{ $interest->created_at->format('F j, Y \a\t g:i A') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                                'viewed' => 'bg-sky-100 text-sky-800 border-sky-200',
                                'contacted' => 'bg-green-100 text-green-800 border-green-200',
                                'closed' => 'bg-gray-100 text-gray-800 border-gray-200',
                            ];
                        @endphp
                        <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full border {{ $statusClasses[$interest->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ __($interest->status) }}
                        </span>
                    </div>
                </div>

                <!-- Scout & Player Summary Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
                    <!-- Scout Card -->
                    <div class="p-4 rounded-lg bg-indigo-50 border border-indigo-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-indigo-700">{{ __('Scout / Organization') }}</span>
                        <div class="mt-3 flex items-start space-x-3">
                            <div class="h-12 w-12 rounded-full bg-indigo-700 text-white flex items-center justify-center font-bold text-lg shrink-0">
                                {{ strtoupper(substr($interest->scout->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-base">{{ $interest->scout->name }}</h4>
                                <p class="text-xs font-medium text-indigo-600">
                                    {{ $interest->scout->scoutProfile?->organization ?? __('Independent Scout') }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $interest->scout->scoutProfile?->role_title ?? '' }}
                                    @if ($interest->scout->scoutProfile?->location)
                                        &bull; {{ $interest->scout->scoutProfile->location }}
                                    @endif
                                </p>
                                @if ($interest->scout->scoutProfile)
                                    <div class="mt-3">
                                        <a href="{{ route('scout.profile.show', $interest->scout->scoutProfile) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-900 underline">
                                            {{ __('View Scout Credentials') }} &rarr;
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Player Card -->
                    <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-100">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">{{ __('Player Talent') }}</span>
                        <div class="mt-3 flex items-start space-x-3">
                            <div class="h-12 w-12 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-lg shrink-0">
                                {{ strtoupper(substr($interest->playerProfile->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-base">{{ $interest->playerProfile->user->name }}</h4>
                                <p class="text-xs font-medium text-emerald-700">
                                    {{ $interest->playerProfile->position }}
                                    @if ($interest->playerProfile->age)
                                        &bull; {{ $interest->playerProfile->age }} {{ __('yrs') }}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    {{ $interest->playerProfile->location }}
                                    @if ($interest->playerProfile->current_club)
                                        &bull; {{ $interest->playerProfile->current_club }}
                                    @endif
                                </p>
                                <div class="mt-3">
                                    <a href="{{ route('player.profile.show', $interest->playerProfile) }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-900 underline">
                                        {{ __('View Full Football Profile') }} &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Section -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-semibold text-gray-900 mb-2">{{ __('Scout Message / Note') }}</h4>
                    @if ($interest->message)
                        <div class="bg-gray-50 p-4 rounded-lg text-sm text-gray-700 whitespace-pre-line leading-relaxed border border-gray-200">
                            {{ $interest->message }}
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">
                            {{ __('No personal message was attached with this interest invitation.') }}
                        </p>
                    @endif
                </div>

                <!-- Status Update Form -->
                <div class="mt-6 pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="text-xs text-gray-500">
                        {{ __('Last updated') }}: {{ $interest->updated_at->diffForHumans() }}
                    </div>

                    <form method="POST" action="{{ route('scouting.interests.update', $interest) }}" class="flex items-center gap-2">
                        @csrf
                        @method('PATCH')

                        <x-input-label for="status" :value="__('Update Status:')" class="text-xs" />
                        <select id="status" name="status" class="text-xs border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="pending" {{ $interest->status === 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                            <option value="viewed" {{ $interest->status === 'viewed' ? 'selected' : '' }}>{{ __('Viewed') }}</option>
                            <option value="contacted" {{ $interest->status === 'contacted' ? 'selected' : '' }}>{{ __('Contacted') }}</option>
                            <option value="closed" {{ $interest->status === 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                        </select>

                        <x-primary-button class="py-1 px-3 text-xs">
                            {{ __('Update') }}
                        </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
