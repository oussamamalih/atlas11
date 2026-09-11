<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <h1 class="font-display text-3xl sm:text-4xl uppercase tracking-wider text-white">Notifications</h1>
                    @if($unreadCount ?? 0 > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-[#10b981]/20 text-[#10b981] border border-[#10b981]/30 font-display uppercase">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </div>
                @if($unreadCount ?? 0 > 0)
                    <form action="{{ route('notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded bg-[#10b981] text-[#0a1f14] font-display uppercase text-sm font-semibold hover:bg-[#10b981]/90 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Mark All as Read
                        </button>
                    </form>
                @endif
            </div>

            @if($notifications && $notifications->count() > 0)
                <div class="space-y-3">
                    @foreach($notifications as $notification)
                        @php
                            $isUnread = !$notification->read_at;
                        @endphp
                        <div class="rounded border {{ $isUnread ? 'bg-[#10b981]/10 border-[#10b981]/30' : 'bg-[#0d2919] border-[#1a4030]' }} p-4 sm:p-5 transition-colors duration-200">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 mt-0.5">
                                    @if($isUnread)
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#10b981]/20 text-[#10b981]">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#1a4030]/50 text-[#8fa89c]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                                        </span>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1">
                                        <h3 class="font-semibold {{ $isUnread ? 'text-white' : 'text-[#8fa89c]' }} text-sm sm:text-base">
                                            {{ $notification->title ?? $notification->data['title'] ?? 'Notification' }}
                                        </h3>
                                        <span class="text-xs {{ $isUnread ? 'text-[#8fa89c]' : 'text-[#8fa89c]/60' }} font-display uppercase whitespace-nowrap">
                                            {{ $notification->created_at ? $notification->created_at->diffForHumans() : '' }}
                                        </span>
                                    </div>

                                    <p class="mt-1 text-sm {{ $isUnread ? 'text-[#8fa89c]' : 'text-[#8fa89c]/60' }}">
                                        {{ $notification->message ?? $notification->data['message'] ?? '' }}
                                    </p>

                                    <div class="flex flex-wrap items-center gap-2 mt-2">
                                        @if(($notification->organization ?? $notification->data['organization'] ?? null))
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-[#1a4030] text-[#8fa89c] border border-[#1a4030] font-display uppercase">
                                                {{ $notification->organization ?? $notification->data['organization'] }}
                                            </span>
                                        @endif
                                        @if(($notification->scout_name ?? $notification->data['scout_name'] ?? null))
                                            <span class="text-xs {{ $isUnread ? 'text-[#8fa89c]' : 'text-[#8fa89c]/60' }}">
                                                by {{ $notification->scout_name ?? $notification->data['scout_name'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex-shrink-0 flex items-center gap-2">
                                    @if($notification->route ?? $notification->data['route'] ?? null)
                                        <a href="{{ $notification->route ?? $notification->data['route'] }}" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-[#10b981] text-[#0a1f14] font-display uppercase hover:bg-[#10b981]/90 transition-colors duration-200">
                                            View
                                        </a>
                                    @endif

                                    @if($isUnread)
                                        <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-[#1a4030] text-[#8fa89c] font-display uppercase hover:bg-[#1a4030]/80 transition-colors duration-200 border border-[#1a4030]">
                                                Mark Read
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this notification?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-red-900/30 text-red-400 font-display uppercase hover:bg-red-900/50 transition-colors duration-200 border border-red-900/40">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="rounded border bg-[#0d2919] border-[#1a4030] p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#1a4030]/50 mb-4">
                        <svg class="w-8 h-8 text-[#8fa89c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                    </div>
                    <h3 class="font-display text-xl uppercase tracking-wider text-white mb-2">No Notifications</h3>
                    <p class="text-[#8fa89c] text-sm">You're all caught up! Notifications will appear here.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
