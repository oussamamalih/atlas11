<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-[#0B1F33] tracking-tight">
                    {{ __('Edit Football Profile') }}
                </h2>
                <p class="text-xs text-[#64748B] mt-0.5">
                    {{ __('Update your attributes, playing experience, and contact details') }}
                </p>
            </div>
            <a href="{{ route('player.profile.show', $profile) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold text-[#0B1F33] uppercase tracking-wider rounded-lg shadow-sm hover:bg-gray-50 transition">
                &larr; {{ __('View Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6 sm:p-8">
                <div class="mb-6 pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-[#0B1F33]">{{ __('Update Profile Information') }}</h3>
                    <p class="mt-1 text-xs text-[#64748B]">
                        {{ __('Keep your profile accurate to increase your chances of being noticed by scouts.') }}
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-[#15803D] bg-emerald-50 p-4 rounded-xl border border-emerald-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('player.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Position -->
                        <div>
                            <x-input-label for="position" :value="__('Position *')" />
                            <select id="position" name="position" class="mt-1 block w-full border-gray-300 focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] rounded-lg shadow-sm text-sm" required>
                                <option value="">{{ __('Select your primary position') }}</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position }}" {{ old('position', $profile->position) === $position ? 'selected' : '' }}>
                                        {{ __($position) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('position')" class="mt-2" />
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <x-input-label for="date_of_birth" :value="__('Date of Birth *')" />
                            <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', optional($profile->date_of_birth)->format('Y-m-d'))" required />
                            <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('City / Region *')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $profile->location)" placeholder="e.g. Casablanca, Rabat, Tangier" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Preferred Foot -->
                        <div>
                            <x-input-label for="preferred_foot" :value="__('Preferred Foot')" />
                            <select id="preferred_foot" name="preferred_foot" class="mt-1 block w-full border-gray-300 focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] rounded-lg shadow-sm text-sm">
                                <option value="">{{ __('Select preferred foot') }}</option>
                                @foreach ($preferredFeet as $foot)
                                    <option value="{{ $foot }}" {{ old('preferred_foot', $profile->preferred_foot) === $foot ? 'selected' : '' }}>
                                        {{ __($foot) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('preferred_foot')" class="mt-2" />
                        </div>

                        <!-- Height -->
                        <div>
                            <x-input-label for="height" :value="__('Height (cm)')" />
                            <x-text-input id="height" name="height" type="number" min="100" max="230" class="mt-1 block w-full" :value="old('height', $profile->height)" placeholder="e.g. 180" />
                            <x-input-error :messages="$errors->get('height')" class="mt-2" />
                        </div>

                        <!-- Weight -->
                        <div>
                            <x-input-label for="weight" :value="__('Weight (kg)')" />
                            <x-text-input id="weight" name="weight" type="number" min="30" max="150" class="mt-1 block w-full" :value="old('weight', $profile->weight)" placeholder="e.g. 75" />
                            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                        </div>

                        <!-- Current Club -->
                        <div>
                            <x-input-label for="current_club" :value="__('Current Club / Academy')" />
                            <x-text-input id="current_club" name="current_club" type="text" class="mt-1 block w-full" :value="old('current_club', $profile->current_club)" placeholder="e.g. Raja CA Youth, FUS Academy" />
                            <x-input-error :messages="$errors->get('current_club')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $profile->phone)" placeholder="e.g. +212600000000" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Football Experience -->
                    <div>
                        <x-input-label for="football_experience" :value="__('Football Experience & Career Pathway')" />
                        <textarea id="football_experience" name="football_experience" rows="4" class="mt-1 block w-full border-gray-300 focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] rounded-lg shadow-sm text-sm" placeholder="List past clubs, academies, tournament achievements, or league divisions...">{{ old('football_experience', $profile->football_experience) }}</textarea>
                        <x-input-error :messages="$errors->get('football_experience')" class="mt-2" />
                    </div>

                    <!-- Bio -->
                    <div>
                        <x-input-label for="bio" :value="__('Player Bio / Playing Style Description')" />
                        <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] rounded-lg shadow-sm text-sm" placeholder="Describe your football strengths, key traits, preferred tactical roles, or career goals...">{{ old('bio', $profile->bio) }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('player.profile.show', $profile) }}" class="text-xs font-semibold text-gray-500 hover:text-gray-800">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>
                            {{ __('Update Profile') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
