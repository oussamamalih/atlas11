<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-3xl font-display uppercase tracking-wider text-white">{{ __('Welcome Back') }}</h2>
        <p class="text-sm text-[#8fa89c] mt-2">{{ __('Sign in to your Atlas11 scouting portal') }}</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="uppercase tracking-wider font-display" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" class="uppercase tracking-wider font-display" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-[#10b981] hover:text-[#a3e635] transition" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-[#1a4030] text-[#10b981] shadow-sm focus:ring-[#10b981]" name="remember">
                <span class="ms-2 text-xs font-medium text-[#8fa89c]">{{ __('Remember me on this device') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        @if (Route::has('register'))
            <div class="text-center pt-2">
                <a class="text-xs font-semibold text-[#8fa89c] hover:text-[#10b981] transition" href="{{ route('register') }}">
                    {{ __('Don\'t have an account yet? Register') }}
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>