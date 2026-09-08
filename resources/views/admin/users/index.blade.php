<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User Management') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold uppercase tracking-wider rounded-md transition">
                &larr; {{ __('Back to Dashboard') }}
            </a>
        </div>
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

            <!-- Search & Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-4">
                    <div class="sm:col-span-6">
                        <label for="search" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">{{ __('Search User') }}</label>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] }}" placeholder="Search by name or email..." class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                    </div>

                    <div class="sm:col-span-4">
                        <label for="role" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1">{{ __('Filter by Role') }}</label>
                        <select name="role" id="role" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">{{ __('All Roles') }}</option>
                            @foreach ($roles as $roleKey => $roleLabel)
                                <option value="{{ $roleKey }}" @selected($filters['role'] === $roleKey)>{{ $roleLabel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2 flex items-end space-x-2">
                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            {{ __('Filter') }}
                        </button>
                        @if ($filters['search'] || $filters['role'])
                            <a href="{{ route('admin.users.index') }}" class="inline-flex justify-center items-center px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md text-xs font-semibold uppercase tracking-wider">
                                {{ __('Reset') }}
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Users Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-gray-900">
                        {{ __('Registered Users') }} ({{ $users->total() }})
                    </h3>
                </div>

                @if ($users->isEmpty())
                    <div class="p-12 text-center">
                        <div class="mx-auto w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h4 class="text-base font-semibold text-gray-900">{{ __('No users found') }}</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ __('Try adjusting your search criteria or role filters.') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500 tracking-wider">
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
                                            <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($user->isAdmin())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                                    {{ __('Admin') }}
                                                </span>
                                            @elseif ($user->isScout())
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                    {{ __('Scout') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                    {{ __('Player') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($user->isPlayer())
                                                @if ($user->playerProfile)
                                                    <span class="text-xs font-medium text-green-700 bg-green-50 px-2 py-0.5 rounded border border-green-200">
                                                        {{ $user->playerProfile->position }} &bull; {{ $user->playerProfile->location }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">{{ __('Profile not created') }}</span>
                                                @endif
                                            @elseif ($user->isScout())
                                                @if ($user->scoutProfile)
                                                    <span class="text-xs font-medium text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">
                                                        {{ $user->scoutProfile->organization }}
                                                    </span>
                                                @else
                                                    <span class="text-xs text-gray-400 italic">{{ __('Profile not created') }}</span>
                                                @endif
                                            @else
                                                <span class="text-xs text-purple-700 font-medium">{{ __('System Administrator') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-xs text-gray-500">
                                            {{ $user->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                            <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded transition">
                                                {{ __('View') }}
                                            </a>
                                            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded transition">
                                                {{ __('Edit') }}
                                            </a>
                                            @if (Auth::id() !== $user->id)
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-2.5 py-1 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 rounded transition">
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
