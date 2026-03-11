<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Tailwind CSS CDN Fallback -->
            <script src="https://cdn.tailwindcss.com"></script>
        @endif
    </head>
    <body class="font-sans antialiased dark:bg-slate-900">
        <div class="min-h-screen flex">
            <!-- Left Side - Statistics -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-red-600 to-red-700 dark:from-red-800 dark:to-red-900 p-12 flex-col justify-center">
                <div class="text-white">
                    <h1 class="text-4xl font-bold mb-2">BantayKalusugan PH</h1>
                    <p class="text-red-100 text-lg mb-12">Community Health Monitoring Platform</p>
                    
                    <!-- Statistics -->
                    <div class="space-y-8">
                        <div class="group">
                            <div class="flex items-start space-x-4">
                                <div class="p-3 bg-white/20 rounded-lg backdrop-blur">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM9 20H4v-2a3 3 0 013-3h2a3 3 0 013 3v2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-3xl font-bold">{{ \App\Models\User::where('role', '!=', 'admin')->count() }}</p>
                                    <p class="text-red-100">Active Users</p>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="flex items-start space-x-4">
                                <div class="p-3 bg-white/20 rounded-lg backdrop-blur">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-3xl font-bold">{{ \App\Models\Patient::count() }}</p>
                                    <p class="text-red-100">Patients Monitored</p>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="flex items-start space-x-4">
                                <div class="p-3 bg-white/20 rounded-lg backdrop-blur">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-3xl font-bold">{{ \App\Models\HealthAlert::count() }}</p>
                                    <p class="text-red-100">Health Alerts Generated</p>
                                </div>
                            </div>
                        </div>

                        <div class="group">
                            <div class="flex items-start space-x-4">
                                <div class="p-3 bg-white/20 rounded-lg backdrop-blur">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-3xl font-bold">{{ \App\Models\HealthIncident::count() }}</p>
                                    <p class="text-red-100">Incidents Reported</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Text -->
                    <div class="mt-12 pt-8 border-t border-red-500/30">
                        <p class="text-red-100 text-sm">Serving the health needs of our community through modern digital monitoring technology.</p>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center px-8 py-12 sm:px-12 lg:px-16 bg-white dark:bg-slate-900">
                <div class="max-w-md w-full mx-auto">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-6" :status="session('status')" />

                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Welcome Back</h2>
                        <p class="text-slate-600 dark:text-slate-400">Sign in to your BantayKalusugan PH account</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />

                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-slate-600 dark:bg-slate-700 text-red-600 shadow-sm focus:ring-red-500 dark:focus:ring-red-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600 dark:text-slate-400">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <div class="flex flex-col items-center justify-center mt-6">
                            <x-primary-button class="w-full justify-center mb-4">
                                {{ __('Sign In') }}
                            </x-primary-button>
                            
                            <div class="w-full">
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-slate-900 block mb-3 text-center" href="{{ route('password.request') }}">
                                        {{ __('Forgot your password?') }}
                                    </a>
                                @endif

                                <p class="text-center text-gray-600 dark:text-slate-400 text-sm">
                                    {{ __('Don\'t have an account?') }}
                                    <a class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-semibold" href="{{ route('register') }}">
                                        {{ __('Create one here') }}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
