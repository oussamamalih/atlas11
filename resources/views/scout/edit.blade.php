<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Scout Profile') }}
            </h2>
            <a href="{{ route('scout.profile.show', $profile) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('View Profile') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Update Scout Information') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Keep your scouting details current so clubs and talents know your credentials.') }}
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 p-4 rounded-md border border-green-200">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('scout.profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Organization / Club / Agency -->
                        <div>
                            <x-input-label for="organization" :value="__('Club / Academy / Organization *')" />
                            <x-text-input id="organization" name="organization" type="text" class="mt-1 block w-full" :value="old('organization', $profile->organization)" placeholder="e.g. Raja CA, Wydad AC, Independent Scout" required />
                            <x-input-error :messages="$errors->get('organization')" class="mt-2" />
                        </div>

                        <!-- Role / Title -->
                        <div>
                            <x-input-label for="role_title" :value="__('Job Title / Role')" />
                            <x-text-input id="role_title" name="role_title" type="text" class="mt-1 block w-full" :value="old('role_title', $profile->role_title)" placeholder="e.g. Senior Talent Scout, Youth Director" />
                            <x-input-error :messages="$errors->get('role_title')" class="mt-2" />
                        </div>

                        <!-- Location -->
                        <div>
                            <x-input-label for="location" :value="__('Location / Base City *')" />
                            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $profile->location)" placeholder="e.g. Casablanca, Rabat, Marrakech" required />
                            <x-input-error :messages="$errors->get('location')" class="mt-2" />
                        </div>

                        <!-- Years of Experience -->
                        <div>
                            <x-input-label for="experience_years" :value="__('Years of Experience')" />
                            <x-text-input id="experience_years" name="experience_years" type="number" min="0" max="60" class="mt-1 block w-full" :value="old('experience_years', $profile->experience_years)" placeholder="e.g. 5" />
                            <x-input-error :messages="$errors->get('experience_years')" class="mt-2" />
                        </div>

                        <!-- License / Accreditation -->
                        <div>
                            <x-input-label for="license_number" :value="__('Scout License / Accreditation ID')" />
                            <x-text-input id="license_number" name="license_number" type="text" class="mt-1 block w-full" :value="old('license_number', $profile->license_number)" placeholder="e.g. FRMF-1234, FIFA Licensed" />
                            <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                        </div>

                        <!-- Contact Phone -->
                        <div>
                            <x-input-label for="phone" :value="__('Contact Phone')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $profile->phone)" placeholder="e.g. +212 600 000 000" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Bio / Scouting Activity -->
                    <div>
                        <x-input-label for="bio" :value="__('Scouting Activity & Philosophy')" />
                        <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Describe your recruitment targets (age groups, regions), achievements, past placements, or scouting focus...">{{ old('bio', $profile->bio) }}</textarea>
                        <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('scout.profile.show', $profile) }}" class="text-sm text-gray-600 hover:text-gray-900">
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
