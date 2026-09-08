<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-2xl text-[#0B1F33] tracking-tight">
            {{ $role === 'scout' ? __('My Sent Scouting Interests') : __('Scouting Interests Received') }}
        </h2>
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

            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 border-b border-gray-100 pb-4 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-[#0B1F33]">
                            {{ $role === 'scout' ? __('Talents You Are Tracking') : __('Clubs & Scouts Interested In You') }}
                        </h3>
                        <p class="text-xs text-[#64748B] mt-1">
                            {{ $role === 'scout' 
                                ? __('Review the status of player interests and follow up with trial offers.') 
                                : __('Scouts from clubs and academies who have expressed an official scouting interest in your profile.') }}
                        </p>
                    </div>

                    @if ($role === 'scout')
                        <a href="{{ route('scout.search') }}" class="inline-flex items-center px-4 py-2 bg-[#16A34A] hover:bg-[#15803D] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
                            {{ __('Discover More Players') }}
                        </a>
                    @endif
                </div>

                @if ($interests->isEmpty())
                    <div class="p-12 text-center">
                        <div class="mx-auto w-14 h-14 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-4 border border-gray-200">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-[#0B1F33]">
                            {{ $role === 'scout' ? __('No scouting interests sent yet') : __('No scouting interests received yet') }}
                        </h4>
                        <p class="mt-1 text-xs text-[#64748B] max-w-md mx-auto">
                            {{ $role === 'scout' 
                                ? __('Browse talent profiles and express interest to get in touch with promising football players.') 
                                : __('Keep your profile detailed and up to date to increase your visibility to visiting scouts.') }}
                        </p>
                        @if ($role === 'scout')
                            <div class="mt-6">
                                <a href="{{ route('scout.search') }}" class="inline-flex items-center px-4 py-2 bg-[#0B1F33] text-white rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-[#102A43] shadow-sm transition">
                                    {{ __('Search Talents Now') }}
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="overflow-x-auto rounded-lg border border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-[#F8FAFC]">
                                <tr>
                                    @if ($role === 'scout')
                                        <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Player') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Position') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Location') }}</th>
                                    @else
                                        <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Scout / Organization') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Role') }}</th>
                                    @endif
                                    <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Date') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-[11px] font-bold text-[#64748B] uppercase tracking-wider">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100 text-sm">
                                @foreach ($interests as $interest)
                                    <tr class="hover:bg-gray-50/70 transition">
                                        @if ($role === 'scout')
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-9 w-9 rounded-lg bg-[#0B1F33] text-white flex items-center justify-center font-bold text-xs shrink-0 me-3 border border-[#16A34A]/40">
                                                        {{ strtoupper(substr($interest->playerProfile->user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-[#0B1F33]">{{ $interest->playerProfile->user->name }}</div>
                                                        <div class="text-xs text-[#64748B]">{{ $interest->playerProfile->current_club ?? __('Free Agent') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-[#16A34A] border border-emerald-200">
                                                    {{ $interest->playerProfile->position }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#64748B]">
                                                {{ $interest->playerProfile->location }}
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-9 w-9 rounded-lg bg-[#0B1F33] text-[#A3E635] flex items-center justify-center font-bold text-xs shrink-0 me-3 border border-[#16A34A]/40">
                                                        {{ strtoupper(substr($interest->scout->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-bold text-[#0B1F33]">{{ $interest->scout->name }}</div>
                                                        <div class="text-xs font-bold text-[#16A34A]">
                                                            {{ $interest->scout->scoutProfile->organization ?? __('Independent Scout') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-xs text-[#64748B]">
                                                {{ $interest->scout->scoutProfile->role_title ?? '—' }}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-[#64748B]">
                                            {{ $interest->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider
                                                @if ($interest->status === 'pending') bg-amber-50 text-amber-800 border border-amber-200
                                                @elseif ($interest->status === 'contacted') bg-emerald-50 text-[#16A34A] border border-emerald-200
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ __($interest->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-bold">
                                            <a href="{{ route('scouting.interests.show', $interest) }}" class="text-[#0B1F33] hover:text-[#16A34A]">
                                                {{ __('View Details') }} &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $interests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
