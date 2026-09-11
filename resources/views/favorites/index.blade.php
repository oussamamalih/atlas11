<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <h1 class="font-display text-3xl sm:text-4xl uppercase tracking-wider text-white">My Saved Talents</h1>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-[#10b981]/20 text-[#10b981] border border-[#10b981]/30 font-display uppercase">
                        {{ $favorites->total() ?? $favorites->count() ?? 0 }}
                    </span>
                </div>
                <a href="{{ route('players.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded bg-[#10b981] text-[#0a1f14] font-display uppercase text-sm font-semibold hover:bg-[#10b981]/90 transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Discover More Players
                </a>
            </div>

            @if($favorites && $favorites->count() > 0)
                <div class="rounded border bg-[#0d2919] border-[#1a4030] overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[#1a4030]">
                            <thead>
                                <tr class="bg-[#133323]">
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-[#8fa89c] font-display uppercase tracking-wider">Player</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-[#8fa89c] font-display uppercase tracking-wider">Position</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-[#8fa89c] font-display uppercase tracking-wider">Location</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-[#8fa89c] font-display uppercase tracking-wider">Age</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-[#8fa89c] font-display uppercase tracking-wider">Club</th>
                                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-[#8fa89c] font-display uppercase tracking-wider">Saved</th>
                                    <th scope="col" class="px-6 py-3.5 text-right text-xs font-semibold text-[#8fa89c] font-display uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#1a4030]">
                                @foreach($favorites as $favorite)
                                    @php
                                        $player = $favorite->player ?? $favorite;
                                    @endphp
                                    <tr class="hover:bg-[#133323]/50 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-[#1a4030] overflow-hidden">
                                                    @if($player->avatar ?? $player->profile_photo_path ?? null)
                                                        <img src="{{ $player->avatar ?? $player->profile_photo_url }}" alt="{{ $player->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-[#8fa89c] font-display text-sm uppercase">
                                                            {{ strtoupper(substr($player->name ?? 'P', 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-white">{{ $player->name ?? 'Unknown' }}</div>
                                                    <div class="text-xs text-[#8fa89c]">{{ $player->email ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($player->position ?? null)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-semibold bg-[#a3e635]/15 text-[#a3e635] border border-[#a3e635]/20 font-display uppercase">
                                                    {{ $player->position }}
                                                </span>
                                            @else
                                                <span class="text-[#8fa89c]/60 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8fa89c]">
                                            {{ $player->location ?? $player->city ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8fa89c]">
                                            {{ $player->age ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[#8fa89c]">
                                            {{ $player->club ?? $player->team ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-xs text-[#8fa89c]/60">
                                            {{ $favorite->created_at ? $favorite->created_at->diffForHumans() : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('players.show', $player->id ?? $favorite->player_id ?? $favorite->id) }}" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-[#10b981] text-[#0a1f14] font-display uppercase hover:bg-[#10b981]/90 transition-colors duration-200">
                                                    View
                                                </a>
                                                <form action="{{ route('favorites.destroy', $favorite->id ?? $favorite) }}" method="POST" onsubmit="return confirm('Remove this player from your saved talents?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded text-xs font-semibold bg-red-900/30 text-red-400 font-display uppercase hover:bg-red-900/50 transition-colors duration-200 border border-red-900/40">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($favorites instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="mt-8">
                        {{ $favorites->links() }}
                    </div>
                @endif
            @else
                <div class="rounded border bg-[#0d2919] border-[#1a4030] p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#1a4030]/50 mb-4">
                        <svg class="w-8 h-8 text-[#8fa89c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </div>
                    <h3 class="font-display text-xl uppercase tracking-wider text-white mb-2">No Saved Talents</h3>
                    <p class="text-[#8fa89c] text-sm mb-6">You haven't saved any players yet. Start exploring to find talent!</p>
                    <a href="{{ route('players.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded bg-[#10b981] text-[#0a1f14] font-display uppercase text-sm font-semibold hover:bg-[#10b981]/90 transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Search Players
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
