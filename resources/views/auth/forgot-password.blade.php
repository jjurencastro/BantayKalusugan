<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">Reset Password</h2>
        <p class="text-slate-600 dark:text-slate-400">Forgot your password? We'll help you reset it.</p>
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-slate-400 bg-blue-50 dark:bg-slate-700 p-3 rounded-md border border-blue-200 dark:border-slate-600">
        {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-center mt-6">
            <x-primary-button class="w-full justify-center mb-4">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
            
            <a href="{{ route('login') }}" class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                {{ __('Back to login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
