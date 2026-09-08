<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-navy-900">Reset Your Password</h2>
        <p class="mt-2 text-sm text-slate-500 leading-relaxed">
            {{ __('Forgot your password? No problem. Enter your registered email address and we will send you a password reset link to choose a new one.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs font-semibold uppercase tracking-wider text-slate-600" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2 flex items-center justify-between">
            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-500 hover:text-navy-900 transition-colors">
                &larr; Back to login
            </a>
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
