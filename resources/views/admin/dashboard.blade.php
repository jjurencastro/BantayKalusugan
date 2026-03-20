<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Barangay Admin Dashboard') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.users') }}" class="inline-block px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800 transition">
                    {{ __('Manage Users') }}
                </a>
                <a href="{{ route('admin.access-codes') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    {{ __('Access Codes') }}
                </a>
                <a href="{{ route('admin.security') }}" class="inline-block px-4 py-2 bg-zinc-700 text-white rounded-lg hover:bg-zinc-800 transition">
                    {{ __('Security') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <h3 class="text-xl font-semibold mb-2">{{ __('Welcome, Admin ') }}{{ auth()->user()->name }}</h3>
                    <p class="text-gray-600 dark:text-slate-400">
                        {{ __('Manage the health monitoring system, user accounts, and generate comprehensive reports.') }}
                    </p>
                </div>
            </div>

            <!-- System Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM9 20H4v-2a3 3 0 013-3h2a3 3 0 013 3v2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Total Users') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Active Patients') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $activePatients ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Health Reports') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $healthReportsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m0-15a9.865 9.865 0 018.946 5.632A9.87 9.87 0 1112 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Incidents Reported') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $incidentsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Roles Distribution -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('User Roles Distribution') }}</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="p-4 bg-blue-50 dark:bg-slate-700 rounded">
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Patients') }}</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $roleDistribution['patient'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 bg-green-50 dark:bg-slate-700 rounded">
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Nurses') }}</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $roleDistribution['nurse'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 bg-purple-50 dark:bg-slate-700 rounded">
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Doctors') }}</p>
                            <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $roleDistribution['doctor'] ?? 0 }}</p>
                        </div>
                        <div class="p-4 bg-red-50 dark:bg-slate-700 rounded">
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Admins') }}</p>
                            <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $roleDistribution['barangay_admin'] ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.users') }}" class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-slate-700 hover:shadow-md transition cursor-pointer">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 10H9"></path>
                        </svg>
                        <h4 class="ml-3 font-semibold text-gray-900 dark:text-white">{{ __('Manage Users') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Create, edit, or delete user accounts') }}</p>
                </a>

                <a href="{{ route('admin.health-reports') }}" class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-slate-700 hover:shadow-md transition cursor-pointer">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h4 class="ml-3 font-semibold text-gray-900 dark:text-white">{{ __('Health Reports') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Generate health statistics and reports') }}</p>
                </a>

                <a href="{{ route('admin.incident-reports') }}" class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-slate-700 hover:shadow-md transition cursor-pointer">
                    <div class="flex items-center mb-4">
                        <svg class="w-8 h-8 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m0-15a9.865 9.865 0 018.946 5.632A9.87 9.87 0 1112 3z"></path>
                        </svg>
                        <h4 class="ml-3 font-semibold text-gray-900 dark:text-white">{{ __('Incident Reports') }}</h4>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('View and analyze incident data') }}</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
