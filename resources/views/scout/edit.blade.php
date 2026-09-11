<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <h1 class="font-display text-4xl uppercase tracking-wider text-white mb-8">Edit Scout Profile</h1>

            <form method="POST" action="{{ route('scout.update', $profile) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="organization" class="block text-sm font-medium text-[#8fa89c] mb-1">Organization</label>
                        <input id="organization" name="organization" type="text" value="{{ old('organization', $profile->organization) }}" required
                            class="w-full bg-[#0d2919] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                        @error('organization')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role_title" class="block text-sm font-medium text-[#8fa89c] mb-1">Role Title</label>
                        <input id="role_title" name="role_title" type="text" value="{{ old('role_title', $profile->role_title) }}" required
                            class="w-full bg-[#0d2919] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                        @error('role_title')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-[#8fa89c] mb-1">Location</label>
                        <input id="location" name="location" type="text" value="{{ old('location', $profile->location) }}"
                            class="w-full bg-[#0d2919] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                        @error('location')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="experience_years" class="block text-sm font-medium text-[#8fa89c] mb-1">Experience Years</label>
                        <input id="experience_years" name="experience_years" type="number" value="{{ old('experience_years', $profile->experience_years) }}"
                            class="w-full bg-[#0d2919] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                        @error('experience_years')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="license_number" class="block text-sm font-medium text-[#8fa89c] mb-1">License Number</label>
                        <input id="license_number" name="license_number" type="text" value="{{ old('license_number', $profile->license_number) }}"
                            class="w-full bg-[#0d2919] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                        @error('license_number')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-[#8fa89c] mb-1">Phone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $profile->phone) }}"
                            class="w-full bg-[#0d2919] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent" />
                        @error('phone')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="bio" class="block text-sm font-medium text-[#8fa89c] mb-1">Bio</label>
                    <textarea id="bio" name="bio" rows="4"
                        class="w-full bg-[#0d2919] border border-[#1a4030] text-white rounded px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#10b981] focus:border-transparent">{{ old('bio', $profile->bio) }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('scout.show', $profile) }}" class="font-display uppercase tracking-wider px-6 py-2.5 rounded border border-[#1a4030] text-[#8fa89c] hover:bg-[#0d2919] transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="font-display uppercase tracking-wider px-6 py-2.5 rounded bg-[#10b981] text-[#0a1f14] hover:bg-[#059669] transition-colors">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>