<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-extrabold text-[#0B1F33] tracking-tight">{{ __('Create Your Account') }}</h2>
        <p class="text-xs text-[#64748B] mt-1">{{ __('Join Morocco\'s football talent scouting platform') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Full name" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Role -->
        <div>
            <x-input-label for="role" :value="__('Account Type')" />
            <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] rounded-lg shadow-sm text-sm" required>
                <option value="player" {{ old('role', request('role', 'player')) === 'player' ? 'selected' : '' }}>{{ __('player') }} — {{ __('Football Player') }}</option>
                <option value="scout" {{ old('role', request('role')) === 'scout' ? 'selected' : '' }}>{{ __('scout') }} — {{ __('Club Scout / Recruiter') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-1" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <div class="pt-2">
            <x-primary-button class="w-full">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="text-center pt-2">
            <a class="text-xs font-semibold text-[#64748B] hover:text-[#0B1F33] transition" href="{{ route('login') }}">
                {{ __('Already registered? Log in') }}
            </a>
        </div>
    </form>
</x-guest-layout>
