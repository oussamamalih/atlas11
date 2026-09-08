<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-[#0B1F33] tracking-tight">
                    {{ __('Scout Profile') }}
                </h2>
                <p class="text-xs text-[#64748B] mt-0.5">
                    {{ __('Official Verified Talent Scout Credentials') }}
                </p>
            </div>

            @if (Auth::id() === $profile->user_id)
                <a href="{{ route('scout.profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-[#0B1F33] hover:bg-[#102A43] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
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

            <!-- Main Header Card -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <div class="flex items-center space-x-5">
                        <div class="h-20 w-20 rounded-2xl bg-[#0B1F33] text-[#A3E635] flex items-center justify-center font-black text-3xl shadow-md shrink-0 border-2 border-[#16A34A]">
                            {{ strtoupper(substr($profile->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <h1 class="text-2xl font-extrabold text-[#0B1F33]">{{ $profile->user->name }}</h1>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#0B1F33] text-[#A3E635]">
                                    {{ __('Scout / Club') }}
                                </span>
                            </div>
                            <p class="text-sm font-bold text-[#16A34A] mt-1">
                                {{ $profile->role_title ? $profile->role_title . ' — ' : '' }}{{ $profile->organization }}
                            </p>
                            <div class="mt-2 flex items-center text-xs text-[#64748B] gap-4 flex-wrap">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $profile->location }}
                                </span>
                                @if ($profile->experience_years)
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $profile->experience_years }} {{ __('years experience') }}
                                    </span>
                                @endif
                                @if ($profile->license_number)
                                    <span class="flex items-center font-semibold text-[#0B1F33]">
                                        <svg class="w-4 h-4 me-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6 space-y-6">
                <!-- Professional Details -->
                <div class="border-b border-gray-100 pb-6">
                    <h3 class="text-base font-bold text-[#0B1F33] mb-4">{{ __('Professional Information') }}</h3>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-xs">
                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Organization / Club') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->organization }}</dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Role / Title') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->role_title ?? __('Scout') }}</dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Location') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->location }}</dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Scout License / ID') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->license_number ?? __('Not specified') }}</dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Email') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->user->email }}</dd>
                        </div>

                        <div class="bg-[#F8FAFC] p-3 rounded-lg border border-gray-100">
                            <dt class="text-[#64748B] font-semibold uppercase tracking-wider text-[10px]">{{ __('Contact Phone') }}</dt>
                            <dd class="mt-1 text-sm font-bold text-[#0B1F33]">{{ $profile->phone ?? __('Not specified') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Bio / Scouting Activity -->
                @if ($profile->bio)
                    <div>
                        <h3 class="text-base font-bold text-[#0B1F33] mb-2">{{ __('Scouting Focus & Philosophy') }}</h3>
                        <div class="p-4 bg-[#F8FAFC] rounded-lg border border-gray-100 text-sm text-[#111827] whitespace-pre-line leading-relaxed">
                            {{ $profile->bio }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
