<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <h1 class="font-display text-4xl uppercase tracking-wider text-white mb-8">
                {{ $role === 'scout' ? 'Scouting Interests' : 'Scouting Requests' }}
            </h1>

            @if($interests->count())
                <div class="bg-[#0d2919] border border-[#1a4030] rounded overflow-hidden mb-8">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-[#1a4030]">
                                <th class="text-left px-6 py-3 text-xs uppercase font-display tracking-wider text-[#8fa89c]">
                                    {{ $role === 'scout' ? 'Player' : 'Organization' }}
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
                                        {{ $role === 'scout' ? ($interest->player->name ?? 'N/A') : ($interest->scout->organization ?? 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4 text-[#8fa89c]">
                                        {{ $role === 'scout' ? ($interest->player->position ?? 'N/A') : ($interest->scout->role_title ?? 'N/A') }}
                                    </td>
                                    <td class="px-6 py-4 text-[#8fa89c] text-sm">
                                        {{ $interest->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($interest->status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-amber-500/20 text-amber-400 border border-amber-500/30 font-display uppercase">Pending</span>
                                        @elseif($interest->status === 'contacted')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-[#10b981]/20 text-[#10b981] border border-[#10b981]/30 font-display uppercase">Contacted</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30 font-display uppercase">Closed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('scouting.show', $interest) }}" class="font-display uppercase tracking-wider text-sm text-[#10b981] hover:text-white transition-colors">
                                            View
                                        </a>
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
                    <p class="text-[#8fa89c] text-lg mb-4">No scouting interests found.</p>
                    <a href="{{ route('scout.search') }}" class="font-display uppercase tracking-wider px-6 py-2.5 rounded bg-[#10b981] text-[#0a1f14] hover:bg-[#059669] transition-colors inline-block">
                        Search Players
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>