<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-[#0B1F33] tracking-tight">
                    {{ __('User Management') }}
                </h2>
                <p class="text-xs text-[#64748B] mt-0.5">
                    {{ __('Platform user directory, authorization roles, and account controls') }}
                </p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold text-[#0B1F33] uppercase tracking-wider rounded-lg shadow-sm hover:bg-gray-50 transition">
                &larr; {{ __('Back to Dashboard') }}
            </a>
        </div>
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

            <!-- Search & Filters -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="sm:col-span-6">
                        <label for="search" class="block text-xs font-bold text-[#0B1F33] uppercase tracking-wider mb-1.5">{{ __('Search User') }}</label>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] }}" placeholder="Search by name or email..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] text-sm placeholder:text-gray-400">
                    </div>

                    <div class="sm:col-span-4">
                        <label for="role" class="block text-xs font-bold text-[#0B1F33] uppercase tracking-wider mb-1.5">{{ __('Filter by Role') }}</label>
                        <select name="role" id="role" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] text-sm">
                            <option value="">{{ __('All Roles') }}</option>
                            @foreach ($roles as $roleKey => $roleLabel)
                                <option value="{{ $roleKey }}" @selected($filters['role'] === $roleKey)>{{ $roleLabel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2 flex items-end space-x-2">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-[#16A34A] hover:bg-[#15803D] text-white text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm transition">
                            {{ __('Filter') }}
                        </button>
                        @if ($filters['search'] || $filters['role'])
                            <a href="{{ route('admin.users.index') }}" class="inline-flex justify-center items-center px-3 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-[#0B1F33] rounded-lg text-xs font-semibold uppercase tracking-wider transition">
                                {{ __('Reset') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-[#0B1F33]">
                        {{ __('Registered Users') }} <span class="text-xs font-normal text-[#64748B] ms-1">({{ $users->total() }})</span>
                    </h3>
                </div>

                @if ($users->isEmpty())
                    <div class="p-12 text-center">
                        <div class="mx-auto w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-gray-400 mb-3 border border-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h4 class="text-base font-bold text-[#0B1F33]">{{ __('No users found') }}</h4>
                        <p class="text-xs text-[#64748B] mt-1">{{ __('Try adjusting your search criteria or role filters.') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-[#F8FAFC] text-[11px] uppercase font-bold text-[#64748B] tracking-wider">
                                <tr>
                                    <th class="px-6 py-3.5">{{ __('User') }}</th>
                                    <th class="px-6 py-3.5">{{ __('Role') }}</th>
                                    <th class="px-6 py-3.5">{{ __('Profile Status') }}</th>
                                    <th class="px-6 py-3.5">{{ __('Joined') }}</th>
                                    <th class="px-6 py-3.5 text-right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50/70 transition">
                                        <td class="px-6 py-4">
                                            <div class="font-bold text-[#0B1F33]">{{ $user->name }}</div>
                                            <div class="text-xs text-[#64748B]">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($user->isAdmin())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#0B1F33] text-white">
                                                    {{ __('Admin') }}
                                                </span>
                                            @elseif ($user->isScout())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-[#0B1F33] text-[#A3E635]">
                                                    {{ __('Scout') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-[#16A34A] border border-emerald-200">
                                                    {{ __('Player') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($user->isPlayer())
                                                @if ($user->playerProfile)
                                                    <span class="text-xs font-bold text-[#16A34A] bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                                        {{ $user->playerProfile->position }} &bull; {{ $user->playerProfile->location }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">{{ __('Profile not created') }}</span>
                                                @endif
                                            @elseif ($user->isScout())
                                                @if ($user->scoutProfile)
                                                    <span class="text-xs font-bold text-[#0B1F33] bg-slate-100 px-2 py-0.5 rounded-md border border-slate-200">
                                                        {{ $user->scoutProfile->organization }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">{{ __('Profile not created') }}</span>
                                                @endif
                                            @else
                                                <span class="text-xs text-purple-700 font-semibold">{{ __('System Administrator') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs text-[#64748B]">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                            <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-[#0B1F33] bg-[#F8FAFC] hover:bg-gray-100 rounded-lg border border-gray-200 transition">
                                                {{ __('View') }}
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-white bg-[#0B1F33] hover:bg-[#102A43] rounded-lg transition">
                                                {{ __('Edit') }}
                                            </a>
                                            @if (Auth::id() !== $user->id)
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 text-xs font-bold text-[#DC2626] bg-red-50 hover:bg-red-100 rounded-lg border border-red-200 transition">
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="p-6 border-t border-gray-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
