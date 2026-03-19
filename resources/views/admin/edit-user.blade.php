<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Edit User') }}
            </h2>
            <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Users') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    @if(session('success'))
                        <div class="mb-4 rounded-md bg-green-100 text-green-800 px-4 py-3 dark:bg-green-900 dark:text-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.update-user', $user) }}" class="space-y-5">
                        @csrf
                        @method('PATCH')

                        <div>
                            <x-input-label for="name" :value="__('Full Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email Address')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" :value="__('Phone Number')" />
                            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="address" :value="__('Address')" />
                            <textarea id="address" name="address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500">{{ old('address', $user->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500" required>
                                @php($selectedRole = old('role', $user->role))
                                <option value="patient" @selected($selectedRole === 'patient')>{{ __('Patient') }}</option>
                                <option value="nurse" @selected($selectedRole === 'nurse')>{{ __('Nurse') }}</option>
                                <option value="doctor" @selected($selectedRole === 'doctor')>{{ __('Doctor') }}</option>
                                <option value="barangay_admin" @selected($selectedRole === 'barangay_admin')>{{ __('Barangay Admin') }}</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-3 pt-1">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" id="is_active" name="is_active" value="1"
                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                            <x-input-label for="is_active" :value="__('Active (user can log in)')" class="!mb-0 cursor-pointer" />
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3">
                            <a href="{{ route('admin.users') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
