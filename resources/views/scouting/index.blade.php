<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <h1 class="font-display text-4xl uppercase tracking-wider text-white mb-8">
                {{ $role === 'scout' ? 'My Sent Scouting Interests' : 'Scouting Interests Received' }}
            </h1>

            <div class="mb-6 flex flex-wrap items-center gap-2">
                <a href="{{ route('scouting.interests.index') }}" class="px-3 py-1.5 rounded-full text-xs font-display uppercase tracking-wider border transition-colors {{ is_null($selectedStatus) ? 'bg-[#10b981] text-[#0a1f14] border-[#10b981]' : 'bg-[#0d2919] text-[#8fa89c] border-[#1a4030] hover:text-white hover:border-[#10b981]' }}">
                    All
                </a>
                @foreach (\App\Models\ScoutingInterest::statuses() as $status)
                    <a href="{{ route('scouting.interests.index', ['status' => $status]) }}" class="px-3 py-1.5 rounded-full text-xs font-display uppercase tracking-wider border transition-colors {{ $selectedStatus === $status ? 'bg-[#10b981] text-[#0a1f14] border-[#10b981]' : 'bg-[#0d2919] text-[#8fa89c] border-[#1a4030] hover:text-white hover:border-[#10b981]' }}">
                        {{ $status }}
                    </a>
                @endforeach
            </div>

            @if($interests->count())
                <div class="bg-[#0d2919] border border-[#1a4030] rounded overflow-hidden mb-8">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[#1a4030]">
                                <th class="text-left px-6 py-3 text-xs uppercase font-display tracking-wider text-[#8fa89c]">
                                    {{ $role === 'scout' ? 'Player' : 'Scout / Organization' }}
                                </th>
                                <th class="text-left px-6 py-3 text-xs uppercase font-display tracking-wider text-[#8fa89c]">
                                    {{ $role === 'scout' ? 'Position' : 'Role' }}
                                </th>
                                <th class="text-left px-6 py-3 text-xs uppercase font-display tracking-wider text-[#8fa89c]">Date</th>
                                <th class="text-left px-6 py-3 text-xs uppercase font-display tracking-wider text-[#8fa89c]">Status</th>
                                <th class="text-right px-6 py-3 text-xs uppercase font-display tracking-wider text-[#8fa89c]">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#1a4030]">
                            @foreach($interests as $interest)
                                <tr class="hover:bg-[#133323]/50 transition-colors">
                                    <td class="px-6 py-4 text-white">
                                        @if($role === 'scout')
                                            <div>
                                                @if($interest->playerProfile)
                                                    <a href="{{ route('player.profile.show', $interest->playerProfile) }}" class="text-white hover:text-[#10b981] transition-colors">
                                                        {{ $interest->playerProfile->user->name ?? 'N/A' }}
                                                    </a>
                                                @else
                                                    {{ $interest->playerProfile?->user?->name ?? 'N/A' }}
                                                @endif
                                            </div>
                                        @else
                                            <div>{{ $interest->scout?->name ?? 'N/A' }}</div>
                                            @if($interest->scout?->scoutProfile?->organization)
                                                <div class="text-xs text-[#8fa89c]">{{ $interest->scout->scoutProfile->organization }}</div>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-[#8fa89c]">
                                        {{ $role === 'scout' ? ($interest->playerProfile?->position ?? 'N/A') : ($interest->scout?->scoutProfile?->role_title ?? 'Scout') }}
                                    </td>
                                    <td class="px-6 py-4 text-[#8fa89c] text-sm">
                                        {{ $interest->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($interest->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-amber-500/20 text-amber-400 border border-amber-500/30 font-display uppercase">Pending</span>
                                        @elseif($interest->status === 'viewed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-sky-500/20 text-sky-400 border border-sky-500/30 font-display uppercase">Viewed</span>
                                        @elseif($interest->status === 'contacted')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-[#10b981]/20 text-[#10b981] border border-[#10b981]/30 font-display uppercase">Contacted</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30 font-display uppercase">Closed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('scouting.interests.show', $interest) }}" class="font-display uppercase tracking-wider text-sm text-[#10b981] hover:text-white transition-colors">
                                            View
                                        </a>
                                        @if($role === 'scout' && $interest->isCancellable())
                                            <form method="POST" action="{{ route('scouting.interests.cancel', $interest) }}" class="inline-block" onsubmit="return confirm('Cancel this scouting interest?');">
                                                @csrf
                                                <button type="submit" class="font-display uppercase tracking-wider text-sm text-[#8fa89c] hover:text-red-400 transition-colors ml-4">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div>
                    {{ $interests->links() }}
                </div>
            @else
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-12 text-center">
                    <p class="text-[#8fa89c] text-lg mb-4">{{ $selectedStatus ? 'No '.$selectedStatus.' scouting interests found.' : 'No scouting interests found.' }}</p>
                    <a href="{{ route('scout.search') }}" class="font-display uppercase tracking-wider px-6 py-2.5 rounded bg-[#10b981] text-[#0a1f14] hover:bg-[#059669] transition-colors inline-block">
                        Search Players
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>