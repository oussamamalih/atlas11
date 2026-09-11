<x-app-layout>
    <div class="min-h-screen bg-[#0a1f14] py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="font-display text-3xl sm:text-4xl uppercase tracking-wider text-white">Account Profile & Security</h1>
                <p class="mt-2 text-[#8fa89c] text-sm">Manage your account settings and security preferences.</p>
            </div>

            <div class="space-y-6">
                <div class="rounded border bg-[#0d2919] border-[#1a4030] overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#1a4030]">
                        <h2 class="font-display text-lg uppercase tracking-wider text-white">Profile Information</h2>
                        <p class="mt-1 text-xs text-[#8fa89c]">Update your account's profile information and email address.</p>
                    </div>
                    <div class="px-6 py-6">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="rounded border bg-[#0d2919] border-[#1a4030] overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#1a4030]">
                        <h2 class="font-display text-lg uppercase tracking-wider text-white">Update Password</h2>
                        <p class="mt-1 text-xs text-[#8fa89c]">Ensure your account is using a long, random password to stay secure.</p>
                    </div>
                    <div class="px-6 py-6">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="rounded border bg-[#0d2919] border-[#1a4030] overflow-hidden">
                    <div class="px-6 py-4 border-b border-[#1a4030]">
                        <h2 class="font-display text-lg uppercase tracking-wider text-white">Delete Account</h2>
                        <p class="mt-1 text-xs text-[#8fa89c]">Permanently delete your account and all of its resources.</p>
                    </div>
                    <div class="px-6 py-6">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
