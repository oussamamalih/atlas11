<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notifications') }}
            </h2>
            @if ($unreadCount > 0)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-indigo-100 text-indigo-800">
                    {{ $unreadCount }} {{ __('unread') }}
                </span>
            @endif
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 mb-6 border-b border-gray-100 gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">
                            {{ __('Activity & Alerts') }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ __('Stay updated on scouting interest, profile views, and talent scouting activities.') }}
                        </p>
                    </div>

                    @if ($unreadCount > 0)
                        <form method="POST" action="{{ route('notifications.markAllAsRead') }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold uppercase tracking-wider rounded-md transition duration-150 ease-in-out">
                                <svg class="w-4 h-4 me-1.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Mark All as Read') }}
                            </button>
                        </form>
                    @endif
                </div>

                @if ($notifications->isEmpty())
                    <div class="p-12 text-center">
                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-900">
                            {{ __('No notifications yet') }}
                        </h4>
                        <p class="mt-1 text-sm text-gray-500">
                            {{ __('You are all caught up! You will be notified when scouts show interest in your football profile.') }}
                        </p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($notifications as $notification)
                            @php
                                $isUnread = $notification->unread();
                                $data = $notification->data;
                            @endphp
                            <div class="p-5 rounded-lg border transition duration-150 {{ $isUnread ? 'bg-indigo-50/40 border-indigo-200 shadow-sm' : 'bg-white border-gray-200' }}">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-start space-x-3.5">
                                        <!-- Notification Icon -->
                                        <div class="shrink-0 mt-0.5">
                                            @if ($isUnread)
                                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Notification Content -->
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="text-base font-semibold text-gray-900">
                                                    {{ $data['title'] ?? __('Notification') }}
                                                </h4>
                                                @if ($isUnread)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-600 text-white">
                                                        {{ __('New') }}
                                                    </span>
                                                @endif
                                            </div>

                                            @if (!empty($data['message']))
                                                <p class="text-sm text-gray-700 mt-1">
                                                    {{ $data['message'] }}
                                                </p>
                                            @endif

                                            <div class="flex items-center gap-3 text-xs text-gray-500 mt-2">
                                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                                @if (!empty($data['organization']))
                                                    <span>&bull;</span>
                                                    <span class="font-medium text-gray-700">{{ $data['organization'] }}</span>
                                                @endif
                                                @if (!empty($data['scout_name']))
                                                    <span>&bull;</span>
                                                    <span>{{ __('Scout:') }} {{ $data['scout_name'] }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center space-x-2 shrink-0">
                                        @if (!empty($data['url']))
                                            <a href="{{ $data['url'] }}" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-wider hover:bg-indigo-700 transition">
                                                {{ __('View') }}
                                            </a>
                                        @endif

                                        @if ($isUnread)
                                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md font-medium text-xs text-gray-700 uppercase tracking-wider hover:bg-gray-50 transition" title="{{ __('Mark as read') }}">
                                                    {{ __('Mark Read') }}
                                                </button>
                                            </form>
                                        @endif

                                        <form method="POST" action="{{ route('notifications.destroy', $notification->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center p-1.5 text-gray-400 hover:text-red-600 rounded-md hover:bg-gray-100 transition" title="{{ __('Delete notification') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
