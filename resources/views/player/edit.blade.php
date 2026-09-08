<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Football Profile') }}
            </h2>
            <a href="{{ route('player.profile.show', $profile) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('View Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Update Profile Information') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Keep your profile accurate to increase your chances of being noticed by scouts.') }}
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-md border border-green-200">
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
                            <select id="position" name="position" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
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
                            <select id="preferred_foot" name="preferred_foot" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
                            <x-text-input id="height" name="height" type="number" min="120" max="250" class="mt-1 block w-full" :value="old('height', $profile->height)" placeholder="e.g. 182" />
                            <x-input-error :messages="$errors->get('height')" class="mt-2" />
                        </div>

                        <!-- Weight -->
                        <div>
                            <x-input-label for="weight" :value="__('Weight (kg)')" />
                            <x-text-input id="weight" name="weight" type="number" min="30" max="200" class="mt-1 block w-full" :value="old('weight', $profile->weight)" placeholder="e.g. 75" />
                            <x-input-error :messages="$errors->get('weight')" class="mt-2" />
                        </div>

                        <!-- Current Club / Academy -->
                        <div>
                            <x-input-label for="current_club" :value="__('Current Club / Academy')" />
                            <x-text-input id="current_club" name="current_club" type="text" class="mt-1 block w-full" :value="old('current_club', $profile->current_club)" placeholder="e.g. FUS Rabat Youth, Free Agent" />
                            <x-input-error :messages="$errors->get('current_club')" class="mt-2" />
                        </div>

                        <!-- Contact Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $profile->phone)" placeholder="e.g. +212 600 000 000" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Football Experience -->
                    <div>
                        <x-input-label for="football_experience" :value="__('Football Experience / Career History')" />
                        <textarea id="football_experience" name="football_experience" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="List past academies, youth tournaments, training camps, or leagues you played in...">{{ old('football_experience', $profile->football_experience) }}</textarea>
                        <x-input-error :messages="$errors->get('football_experience')" class="mt-2" />
                    </div>

                    <!-- Bio -->
                    <div>
                        <x-input-label for="bio" :value="__('Bio / About Me')" />
                        <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Tell scouts about your playing style, strengths, dedication, and ambitions...">{{ old('bio', $profile->bio) }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('player.profile.show', $profile) }}" class="text-sm text-gray-600 hover:text-gray-900">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>
                            {{ __('Save Changes') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
