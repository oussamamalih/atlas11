<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Scout Profile') }}
            </h2>

            @if (Auth::id() === $profile->user_id)
                <a href="{{ route('scout.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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

            <!-- Main Header Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="h-20 w-20 rounded-full bg-indigo-700 text-white flex items-center justify-center font-bold text-3xl shadow">
                            {{ strtoupper(substr($profile->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $profile->user->name }}</h1>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                    {{ __('Scout / Club') }}
                                </span>
                            </div>
                            <p class="text-md font-medium text-indigo-600 mt-0.5">
                                {{ $profile->role_title ? $profile->role_title . ' — ' : '' }}{{ $profile->organization }}
                            </p>
                            <div class="mt-2 flex items-center text-sm text-gray-500 gap-4 flex-wrap">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $profile->location }}
                                </span>
                                @if ($profile->experience_years)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $profile->experience_years }} {{ __('years experience') }}
                                    </span>
                                @endif
                                @if ($profile->license_number)
                                    <span class="flex items-center font-medium text-gray-600">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                        {{ $profile->license_number }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                <!-- Professional Details -->
                <div class="border-b border-gray-100 pb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ __('Professional Information') }}</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Organization / Club') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->organization }}</dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Role / Title') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->role_title ?? __('Not specified') }}</dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Location') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->location }}</dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Scout License / ID') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->license_number ?? __('Not specified') }}</dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->user->email }}</dd>
                        </div>

                        <div>
                            <dt class="text-gray-500 font-medium">{{ __('Contact Phone') }}</dt>
                            <dd class="mt-1 text-gray-900 font-semibold">{{ $profile->phone ?? __('Not specified') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Bio / Scouting Activity -->
                @if ($profile->bio)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Scouting Focus & Philosophy') }}</h3>
                        <p class="text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $profile->bio }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
