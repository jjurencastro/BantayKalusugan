<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Create Account</h2>
        <p class="text-slate-600 dark:text-slate-400">Join BantayKalusugan PH and start monitoring your health</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone Number')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- User Role -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Account Type')" />
            <select id="role" name="role" required class="block mt-1 w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                <option value="">{{ __('Select your account type...') }}</option>
                <option value="patient" @selected(old('role') === 'patient')>{{ __('Patient') }}</option>
                <option value="nurse" @selected(old('role') === 'nurse')>{{ __('Nurse') }}</option>
                <option value="doctor" @selected(old('role') === 'doctor')>{{ __('Doctor') }}</option>
                <option value="barangay_admin" @selected(old('role') === 'barangay_admin')>{{ __('Barangay Admin') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Access Code (for non-patient roles) -->
        <div class="mt-4" id="access-code-field" style="display: none;">
            <x-input-label for="access_code" :value="__('Administrator Access Code')" />
            <x-text-input id="access_code" class="block mt-1 w-full" type="text" name="access_code" :value="old('access_code')" placeholder="Enter the access code provided by administrator" autocomplete="off" />
            <x-input-error :messages="$errors->get('access_code')" class="mt-2" />
            <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Required for Nurse, Doctor, or Admin registration</p>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-center mt-6">
            <x-primary-button class="w-full justify-center mb-4">
                {{ __('Create Account') }}
            </x-primary-button>
            
            <p class="text-center text-gray-600 dark:text-slate-400 text-sm">
                {{ __('Already have an account?') }}
                <a class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-semibold" href="{{ route('login') }}">
                    {{ __('Sign in here') }}
                </a>
            </p>
        </div>
    </form>

    <script>
        // Show/hide access code field based on role selection
        document.getElementById('role').addEventListener('change', function() {
            const accessCodeField = document.getElementById('access-code-field');
            const accessCodeInput = document.getElementById('access_code');
            
            if (this.value && this.value !== 'patient') {
                accessCodeField.style.display = 'block';
                accessCodeInput.required = true;
            } else {
                accessCodeField.style.display = 'none';
                accessCodeInput.required = false;
                accessCodeInput.value = ''; // Clear the field
            }
        });

        // Check on page load in case form was resubmitted with errors
        document.addEventListener('DOMContentLoaded', function() {
            const role = document.getElementById('role').value;
            const accessCodeField = document.getElementById('access-code-field');
            const accessCodeInput = document.getElementById('access_code');
            
            if (role && role !== 'patient') {
                accessCodeField.style.display = 'block';
                accessCodeInput.required = true;
            }
        });
    </script>
</x-guest-layout>
