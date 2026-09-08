<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('User Details:') }} {{ $user->name }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    {{ __('Account ID:') }} #{{ $user->id }} &bull; {{ __('Registered on') }} {{ $user->created_at->format('F d, Y') }}
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold uppercase tracking-wider rounded-md transition">
                    &larr; {{ __('Back to Users') }}
                </a>
                <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold uppercase tracking-wider rounded-md transition">
                    {{ __('Edit User') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Basic User Info Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                    <h3 class="text-lg font-bold text-gray-900">{{ __('Account Overview') }}</h3>
                    <div>
                        @if ($user->isAdmin())
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-purple-100 text-purple-800">{{ __('Admin') }}</span>
                        @elseif ($user->isScout())
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-amber-100 text-amber-800">{{ __('Scout') }}</span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-green-100 text-green-800">{{ __('Player') }}</span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Full Name') }}</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Email Address') }}</p>
                        <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Email Status') }}</p>
                        <p class="text-sm font-semibold mt-1 {{ $user->email_verified_at ? 'text-green-600' : 'text-amber-600' }}">
                            {{ $user->email_verified_at ? __('Verified on ') . $user->email_verified_at->format('M d, Y') : __('Not Verified') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Role-Specific Details -->
            @if ($user->isPlayer())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Player Football Profile') }}</h3>
                        @if ($user->playerProfile)
                            <a href="{{ route('player.profile.show', $user->playerProfile) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                {{ __('View Public Profile &rarr;') }}
                            </a>
                        @endif
                    </div>

                    @if ($user->playerProfile)
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Position') }}</p>
                                <p class="text-base font-bold text-indigo-600 mt-1">{{ $user->playerProfile->position }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Location / City') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->playerProfile->location }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Date of Birth') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->playerProfile->date_of_birth->format('M d, Y') }} ({{ $user->playerProfile->age }} {{ __('yrs') }})</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Preferred Foot') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ ucfirst($user->playerProfile->preferred_foot ?? 'Not specified') }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Current Club') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->playerProfile->current_club ?? 'Free Agent' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Height / Weight') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">
                                    {{ $user->playerProfile->height ? $user->playerProfile->height . ' cm' : 'N/A' }} /
                                    {{ $user->playerProfile->weight ? $user->playerProfile->weight . ' kg' : 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Phone') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->playerProfile->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Scouting Interests Received') }}</p>
                                <p class="text-sm font-bold text-gray-900 mt-1">{{ $user->playerProfile->scoutingInterests->count() }}</p>
                            </div>
                        </div>

                        @if ($user->playerProfile->bio)
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Bio / Description') }}</p>
                                <p class="text-sm text-gray-700 mt-2 whitespace-pre-line">{{ $user->playerProfile->bio }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-gray-500 py-4 italic">{{ __('This player has not set up their football profile yet.') }}</p>
                    @endif
                </div>
            @elseif ($user->isScout())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
                        <h3 class="text-lg font-bold text-gray-900">{{ __('Scout Professional Profile') }}</h3>
                        @if ($user->scoutProfile)
                            <a href="{{ route('scout.profile.show', $user->scoutProfile) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                {{ __('View Scout Profile &rarr;') }}
                            </a>
                        @endif
                    </div>

                    @if ($user->scoutProfile)
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Organization / Club') }}</p>
                                <p class="text-base font-bold text-indigo-600 mt-1">{{ $user->scoutProfile->organization }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Role Title') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->scoutProfile->role_title ?? 'Scout' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Location') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->scoutProfile->location }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Experience') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->scoutProfile->experience_years ? $user->scoutProfile->experience_years . ' years' : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Phone') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->scoutProfile->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('License') }}</p>
                                <p class="text-sm font-semibold text-gray-900 mt-1">{{ $user->scoutProfile->license_number ?? 'None' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('Interests Expressed') }}</p>
                                <p class="text-sm font-bold text-gray-900 mt-1">{{ $user->sentScoutingInterests->count() }}</p>
                            </div>
                        </div>

                        @if ($user->scoutProfile->bio)
                            <div class="mt-6 pt-6 border-t border-gray-100">
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">{{ __('About / Bio') }}</p>
                                <p class="text-sm text-gray-700 mt-2 whitespace-pre-line">{{ $user->scoutProfile->bio }}</p>
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-gray-500 py-4 italic">{{ __('This scout has not set up their scout profile yet.') }}</p>
                    @endif
                </div>
            @endif

            <!-- Danger Zone: Delete User -->
            @if (Auth::id() !== $user->id)
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-base font-bold text-red-800">{{ __('Delete User Account') }}</h4>
                            <p class="text-xs text-red-600 mt-1">
                                {{ __('Permanently remove this user and all associated profiles, notifications, and scouting interests.') }}
                            </p>
                        </div>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('WARNING: Are you sure you want to permanently delete this user? All associated data will be removed.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold text-xs uppercase tracking-wider rounded-md transition">
                                {{ __('Delete Account') }}
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
