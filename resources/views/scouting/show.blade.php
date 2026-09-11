<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <div class="flex items-center justify-between mb-8">
                <h1 class="font-display text-3xl uppercase tracking-wider text-white">Interest Record</h1>
                @if($interest->status === 'pending')
                    <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium bg-amber-500/20 text-amber-400 border border-amber-500/30 font-display uppercase">Pending</span>
                @elseif($interest->status === 'contacted')
                    <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium bg-[#10b981]/20 text-[#10b981] border border-[#10b981]/30 font-display uppercase">Contacted</span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded text-sm font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30 font-display uppercase">Closed</span>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-6">
                    <h2 class="font-display text-lg uppercase tracking-wider text-[#10b981] mb-4">Scout</h2>
                    <div class="space-y-2">
                        <p class="text-white">{{ $interest->scout->user->name ?? 'N/A' }}</p>
                        <p class="text-[#8fa89c] text-sm">{{ $interest->scout->organization ?? 'N/A' }}</p>
                        <p class="text-[#8fa89c] text-sm">{{ $interest->scout->role_title ?? 'N/A' }}</p>
                        <p class="text-[#8fa89c] text-sm">{{ $interest->scout->location ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-6">
                    <h2 class="font-display text-lg uppercase tracking-wider text-[#a3e635] mb-4">Player</h2>
                    <div class="space-y-2">
                        <p class="text-white">{{ $interest->player->name ?? 'N/A' }}</p>
                        <p class="text-[#8fa89c] text-sm">{{ $interest->player->position ?? 'N/A' }}</p>
                        <p class="text-[#8fa89c] text-sm">{{ $interest->player->current_club ?? 'N/A' }}</p>
                        <p class="text-[#8fa89c] text-sm">{{ $interest->player->location ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            @if($interest->message)
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-6 mb-8">
                    <h2 class="font-display text-lg uppercase tracking-wider text-white mb-3">Message</h2>
                    <p class="text-[#8fa89c] leading-relaxed">{{ $interest->message }}</p>
                </div>
            @endif

            <div class="bg-[#0d2919] border border-[#1a4030] rounded p-6">
                <h2 class="font-display text-lg uppercase tracking-wider text-white mb-4">Update Status</h2>
                <form method="POST" action="{{ route('scouting.update', $interest) }}">
                    @csrf
                    @method('PATCH')

                    <div class="flex flex-wrap items-end gap-4">
                        <div class="flex-1 min-w-[200px]">
                            <label for="status" class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Status</label>
                            <select id="status" name="status"
                                class="w-full bg-[#0a1f14] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent">
                                <option value="pending" {{ $interest->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="contacted" {{ $interest->status === 'contacted' ? 'selected' : '' }}>Contacted</option>
                                <option value="closed" {{ $interest->status === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="font-display uppercase tracking-wider px-6 py-2.5 rounded bg-[#10b981] text-[#0a1f14] hover:bg-[#059669] transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex justify-end mt-8">
                <a href="{{ route('scouting.index') }}" class="font-display uppercase tracking-wider px-6 py-2.5 rounded border border-[#1a4030] text-[#8fa89c] hover:bg-[#0d2919] transition-colors">
                    Back to List
                </a>
            </div>
        </div>
    </div>
</x-app-layout>