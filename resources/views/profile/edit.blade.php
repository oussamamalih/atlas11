<x-app-layout>
    <x-slot name="header">
        <div>
            <span class="inline-flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wider text-pitch-600 bg-pitch-50 px-2.5 py-1 rounded-full border border-pitch-100 mb-2">
                Account Settings
            </span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-navy-900 tracking-tight">
                {{ __('Account Profile & Security') }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">Manage your login credentials, personal details, and account preferences.</p>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="p-6 sm:p-8 bg-white border border-slate-200/80 rounded-2xl shadow-sm">
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white border border-slate-200/80 rounded-2xl shadow-sm">
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white border border-red-100 rounded-2xl shadow-sm">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
