<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-2xl text-[#0B1F33] tracking-tight">
                    {{ __('Edit User:') }} {{ $user->name }}
                </h2>
                <p class="text-xs text-[#64748B] mt-0.5">
                    {{ __('Modify account credentials and system role assignment') }}
                </p>
            </div>
            <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold text-[#0B1F33] uppercase tracking-wider rounded-lg shadow-sm hover:bg-gray-50 transition">
                &larr; {{ __('Cancel & Return') }}
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-6 font-medium text-sm text-red-700 bg-red-50 p-4 rounded-xl border border-red-200">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200/80 shadow-sm p-6 sm:p-8">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Full Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Email Address')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <!-- Role -->
                    <div>
                        <x-input-label for="role" :value="__('User Role')" />
                        <select id="role" name="role" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#16A34A] focus:ring-1 focus:ring-[#16A34A] text-sm">
                            @foreach ($roles as $roleKey => $roleLabel)
                                <option value="{{ $roleKey }}" @selected(old('role', $user->role) === $roleKey)>
                                    {{ $roleLabel }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        <p class="text-xs text-[#64748B] mt-1.5">
                            {{ __('Changing a user role alters their permissions and accessible interfaces across Atlas11.') }}
                        </p>
                    </div>

                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-semibold text-gray-500 hover:text-gray-800">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button>
                            {{ __('Update User') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
