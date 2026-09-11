<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <h1 class="font-display text-4xl uppercase tracking-wider text-white mb-8">Talent Discovery &amp; Search</h1>

            <form method="GET" action="{{ route('scout.search') }}" class="bg-[#0d2919] border border-[#1a4030] rounded p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="keyword" class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Keyword</label>
                        <input id="keyword" name="keyword" type="text" value="{{ request('keyword') }}" placeholder="Name or skill..."
                            class="w-full bg-[#0a1f14] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                    </div>
                    <div>
                        <label for="position" class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Position</label>
                        <select id="position" name="position"
                            class="w-full bg-[#0a1f14] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent">
                            <option value="">All Positions</option>
                            @foreach(['Goalkeeper','Defender','Midfielder','Forward'] as $pos)
                                <option value="{{ $pos }}" {{ request('position') === $pos ? 'selected' : '' }}>{{ $pos }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="location" class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Location</label>
                        <input id="location" name="location" type="text" value="{{ request('location') }}" placeholder="City or region..."
                            class="w-full bg-[#0a1f14] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                    </div>
                    <div>
                        <label for="min_age" class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Min Age</label>
                        <input id="min_age" name="min_age" type="number" value="{{ request('min_age') }}" min="10" max="45"
                            class="w-full bg-[#0a1f14] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                    </div>
                    <div>
                        <label for="max_age" class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Max Age</label>
                        <input id="max_age" name="max_age" type="number" value="{{ request('max_age') }}" min="10" max="45"
                            class="w-full bg-[#0a1f14] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                    </div>
                    <div>
                        <label for="preferred_foot" class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Preferred Foot</label>
                        <select id="preferred_foot" name="preferred_foot"
                            class="w-full bg-[#0a1f14] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent">
                            <option value="">Any</option>
                            <option value="left" {{ request('preferred_foot') === 'left' ? 'selected' : '' }}>Left</option>
                            <option value="right" {{ request('preferred_foot') === 'right' ? 'selected' : '' }}>Right</option>
                            <option value="both" {{ request('preferred_foot') === 'both' ? 'selected' : '' }}>Both</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end mt-4 space-x-3">
                    <a href="{{ route('scout.search') }}" class="font-display uppercase tracking-wider px-5 py-2 rounded border border-[#1a4030] text-[#8fa89c] hover:bg-[#133323] transition-colors text-sm">
                        Reset Filters
                    </a>
                    <button type="submit" class="font-display uppercase tracking-wider px-5 py-2 rounded bg-[#10b981] text-[#0a1f14] hover:bg-[#059669] transition-colors text-sm">
                        Search
                    </button>
                </div>
            </form>

            <p class="text-[#8fa89c] text-sm mb-6">{{ $players->total() }} player{{ $players->total() !== 1 ? 's' : '' }} found</p>

            @if($players->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($players as $player)
                        <div class="bg-[#0d2919] border border-[#1a4030] rounded p-6 hover:border-[#10b981]/40 transition-colors">
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="w-12 h-12 rounded-full bg-[#133323] border border-[#1a4030] flex items-center justify-center flex-shrink-0">
                                    <span class="font-display text-lg uppercase text-[#10b981]">{{ strtoupper(substr($player->name, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-white font-medium truncate">{{ $player->name }}</h3>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-[#a3e635]/15 text-[#a3e635] border border-[#a3e635]/20 font-display uppercase">
                                        {{ $player->position ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-2 mb-4 text-center">
                                <div class="bg-[#0a1f14] rounded py-2">
                                    <span class="block text-xs text-[#8fa89c]">Age</span>
                                    <span class="text-white text-sm font-medium">{{ $player->date_of_birth ? \Carbon\Carbon::parse($player->date_of_birth)->age : 'N/A' }}</span>
                                </div>
                                <div class="bg-[#0a1f14] rounded py-2">
                                    <span class="block text-xs text-[#8fa89c]">Foot</span>
                                    <span class="text-white text-sm font-medium">{{ $player->preferred_foot ?? 'N/A' }}</span>
                                </div>
                                <div class="bg-[#0a1f14] rounded py-2">
                                    <span class="block text-xs text-[#8fa89c]">Height</span>
                                    <span class="text-white text-sm font-medium">{{ $player->height ?? 'N/A' }}</span>
                                </div>
                            </div>

                            @if($player->current_club)
                                <p class="text-sm text-[#8fa89c] mb-2">{{ $player->current_club }}</p>
                            @endif

                            @if($player->bio)
                                <p class="text-sm text-[#8fa89c] line-clamp-2 mb-4">{{ $player->bio }}</p>
                            @endif

                            <a href="{{ route('player.show', $player) }}" class="block text-center font-display uppercase tracking-wider text-sm px-4 py-2 rounded bg-[#133323] border border-[#1a4030] text-[#10b981] hover:bg-[#1a4030] transition-colors">
                                View Profile
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $players->withQueryString()->links() }}
                </div>
            @else
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-12 text-center">
                    <p class="text-[#8fa89c] text-lg mb-4">No players match your search criteria.</p>
                    <a href="{{ route('scout.search') }}" class="font-display uppercase tracking-wider px-6 py-2.5 rounded bg-[#10b981] text-[#0a1f14] hover:bg-[#059669] transition-colors inline-block">
                        Reset Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>