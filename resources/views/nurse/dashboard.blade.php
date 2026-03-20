<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Nurse Dashboard') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('nurse.assistance-requests') }}" class="inline-block px-4 py-2 bg-white/90 text-gray-700 rounded-lg border border-gray-200 hover:bg-white transition dark:bg-slate-700 dark:text-slate-200 dark:border-slate-600 dark:hover:bg-slate-600">
                    {{ __('Assistance Requests') }}
                </a>
                <a href="{{ route('nurse.patients') }}" class="inline-block px-4 py-2 bg-white/90 text-gray-700 rounded-lg border border-gray-200 hover:bg-white transition dark:bg-slate-700 dark:text-slate-200 dark:border-slate-600 dark:hover:bg-slate-600">
                    {{ __('View Patients') }}
                </a>
                <a href="{{ route('nurse.community-health') }}" class="inline-block px-4 py-2 bg-white/90 text-gray-700 rounded-lg border border-gray-200 hover:bg-white transition dark:bg-slate-700 dark:text-slate-200 dark:border-slate-600 dark:hover:bg-slate-600">
                    {{ __('Community Health') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <h3 class="text-xl font-semibold mb-2">{{ __('Welcome, Nurse ') }}{{ auth()->user()->name }}</h3>
                    <p class="text-gray-600 dark:text-slate-400">
                        {{ __('Monitor your assigned patients and track community health metrics.') }}
                    </p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-blue-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Registered Patients') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $patientCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-blue-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Pending Reports') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $pendingReports ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-blue-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m0-15a9 9 0 110 18 9 9 0 010-18z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Critical Alerts') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $criticalAlerts ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-blue-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Completed Updates') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $completedUpdates ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">{{ __('Recent Patient Updates') }}</h3>
                    <p class="text-gray-600 dark:text-slate-400 text-center py-8">
                        {{ __('View your assigned patients to see their latest health updates and manage their care.') }}
                    </p>
                    <div class="text-center">
                        <a href="{{ route('nurse.patients') }}" class="inline-block px-6 py-2 bg-white/90 text-gray-700 rounded-lg border border-gray-200 hover:bg-white transition dark:bg-slate-700 dark:text-slate-200 dark:border-slate-600 dark:hover:bg-slate-600">
                            {{ __('View All Patients') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
