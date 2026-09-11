<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">

            <div class="bg-[#0d2919] border border-[#1a4030] rounded p-8 mb-8">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 rounded-full bg-[#133323] border border-[#1a4030] flex items-center justify-center flex-shrink-0">
                        <span class="font-display text-3xl uppercase text-[#10b981]">{{ strtoupper(substr($profile->user->name ?? 'S', 0, 1)) }}</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-1">
                            <h1 class="font-display text-3xl uppercase tracking-wider text-white">{{ $profile->user->name }}</h1>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium bg-[#10b981]/20 text-[#10b981] border border-[#10b981]/30 font-display uppercase">Scout</span>
                        </div>
                        <p class="text-[#8fa89c] text-sm">{{ $profile->organization }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-5">
                    <span class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Location</span>
                    <span class="text-white">{{ $profile->location ?? 'N/A' }}</span>
                </div>
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-5">
                    <span class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Experience</span>
                    <span class="text-white">{{ $profile->experience_years ?? 'N/A' }} years</span>
                </div>
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-5">
                    <span class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">License</span>
                    <span class="text-white">{{ $profile->license_number ?? 'N/A' }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-5">
                    <span class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Role Title</span>
                    <span class="text-white">{{ $profile->role_title ?? 'N/A' }}</span>
                </div>
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-5">
                    <span class="block text-xs uppercase font-display tracking-wider text-[#8fa89c] mb-1">Phone</span>
                    <span class="text-white">{{ $profile->phone ?? 'N/A' }}</span>
                </div>
            </div>

            @if($profile->bio)
                <div class="bg-[#0d2919] border border-[#1a4030] rounded p-6 mb-8">
                    <h2 class="font-display text-xl uppercase tracking-wider text-white mb-3">Bio</h2>
                    <p class="text-[#8fa89c] leading-relaxed">{{ $profile->bio }}</p>
                </div>
            @endif

            <div class="flex justify-end space-x-4">
                <a href="{{ route('scout.edit', $profile) }}" class="font-display uppercase tracking-wider px-6 py-2.5 rounded bg-[#133323] border border-[#1a4030] text-white hover:bg-[#1a4030] transition-colors">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
</x-app-layout>