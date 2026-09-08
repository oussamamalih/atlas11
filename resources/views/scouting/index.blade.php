<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $role === 'scout' ? __('My Sent Scouting Interests') : __('Scouting Interests Received') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ $role === 'scout' ? __('Talents You Are Tracking') : __('Clubs & Scouts Interested In You') }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $role === 'scout' 
                                ? __('Review the status of player interests and follow up with trial offers.') 
                                : __('Scouts from clubs and academies who have expressed an official scouting interest in your profile.') }}
                        </p>
                    </div>

                    @if ($role === 'scout')
                        <a href="{{ route('scout.search') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            {{ __('Discover More Players') }}
                        </a>
                    @endif
                </div>

                @if ($interests->isEmpty())
                    <div class="p-12 text-center">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">
                            {{ $role === 'scout' ? __('No scouting interests sent yet') : __('No scouting interests received yet') }}
                        </h4>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ $role === 'scout' 
                                ? __('Browse talent profiles and express interest to get in touch with promising football players.') 
                                : __('Keep your profile detailed and up to date to increase your visibility to visiting scouts.') }}
                        </p>
                        @if ($role === 'scout')
                            <div class="mt-6">
                                <a href="{{ route('scout.search') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-xs font-semibold uppercase tracking-wider hover:bg-indigo-700">
                                    {{ __('Search Talents Now') }}
                                </a>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @if ($role === 'scout')
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Player') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Position') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Location') }}</th>
                                    @else
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Scout / Organization') }}</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Role') }}</th>
                                    @endif
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($interests as $interest)
                                    <tr class="hover:bg-gray-50 transition">
                                        @if ($role === 'scout')
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-9 w-9 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shrink-0 me-3">
                                                        {{ strtoupper(substr($interest->playerProfile->user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-gray-900">{{ $interest->playerProfile->user->name }}</div>
                                                        <div class="text-xs text-gray-500">{{ $interest->playerProfile->current_club ?? __('Free Agent') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                    {{ $interest->playerProfile->position }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $interest->playerProfile->location }}
                                            </td>
                                        @else
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-9 w-9 rounded-full bg-indigo-700 text-white flex items-center justify-center font-bold text-sm shrink-0 me-3">
                                                        {{ strtoupper(substr($interest->scout->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="text-sm font-semibold text-gray-900">{{ $interest->scout->name }}</div>
                                                        <div class="text-xs font-medium text-indigo-600">
                                                            {{ $interest->scout->scoutProfile->organization ?? __('Independent Scout') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $interest->scout->scoutProfile->role_title ?? '—' }}
                                            </td>
                                        @endif
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $interest->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-amber-100 text-amber-800',
                                                    'viewed' => 'bg-sky-100 text-sky-800',
                                                    'contacted' => 'bg-green-100 text-green-800',
                                                    'closed' => 'bg-gray-100 text-gray-800',
                                                ];
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold uppercase tracking-wider {{ $statusClasses[$interest->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ __($interest->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('scouting.interests.show', $interest) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold text-xs uppercase tracking-wider">
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
