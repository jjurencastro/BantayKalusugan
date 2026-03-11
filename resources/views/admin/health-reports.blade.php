<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Health Reports') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Report Generation Form -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Generate Health Report') }}</h3>
                    
                    <form action="{{ route('admin.generate-report') }}" method="POST" class="space-y-4" target="_blank">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Report Type -->
                            <div>
                                <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('Report Type') }}
                                </label>
                                <select id="report_type" name="report_type" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    <option value="overall">{{ __('Overall Community Health') }}</option>
                                    <option value="incidents">{{ __('Incidents Summary') }}</option>
                                    <option value="demographics">{{ __('Demographics Report') }}</option>
                                    <option value="monthly">{{ __('Monthly Statistics') }}</option>
                                </select>
                            </div>

                            <!-- Date Range From -->
                            <div>
                                <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('From Date') }}
                                </label>
                                <input type="date" id="date_from" name="date_from" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>

                            <!-- Date Range To -->
                            <div>
                                <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('To Date') }}
                                </label>
                                <input type="date" id="date_to" name="date_to" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium">
                                {{ __('Generate Report') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Recent Reports -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Key Health Metrics') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Active Cases -->
                        <div class="p-4 bg-red-50 dark:bg-slate-700 rounded">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Active Health Cases') }}</p>
                                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $activeCases ?? 0 }}</p>
                                </div>
                                <svg class="w-12 h-12 text-red-200 dark:text-red-800" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Recovery Rate -->
                        <div class="p-4 bg-green-50 dark:bg-slate-700 rounded">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Recovery Rate') }}</p>
                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $recoveryRate ?? 85 }}%</p>
                                </div>
                                <svg class="w-12 h-12 text-green-200 dark:text-green-800" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Average Age -->
                        <div class="p-4 bg-blue-50 dark:bg-slate-700 rounded">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Average Patient Age') }}</p>
                                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $averageAge ?? 35 }} {{ __('yrs') }}</p>
                                </div>
                                <svg class="w-12 h-12 text-blue-200 dark:text-blue-800" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Total Consultations -->
                        <div class="p-4 bg-purple-50 dark:bg-slate-700 rounded">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Total Consultations') }}</p>
                                    <p class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $consultations ?? 0 }}</p>
                                </div>
                                <svg class="w-12 h-12 text-purple-200 dark:text-purple-800" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zm0 20c-4.962 0-9-4.038-9-9s4.038-9 9-9 9 4.038 9 9-4.038 9-9 9z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Common Health Conditions -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Most Common Health Conditions') }}</h3>
                    
                    <div class="space-y-3">
                        @forelse([
                            ['name' => 'Hypertension', 'count' => 45, 'percentage' => 65],
                            ['name' => 'Diabetes', 'count' => 32, 'percentage' => 46],
                            ['name' => 'Respiratory Issues', 'count' => 28, 'percentage' => 40],
                            ['name' => 'Arthritis', 'count' => 22, 'percentage' => 31],
                        ] as $condition)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700 rounded">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $condition['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $condition['count'] }} {{ __('cases') }}</p>
                                </div>
                                <div class="w-40 bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 h-full rounded-full" style="width: {{ $condition['percentage'] }}%"></div>
                                </div>
                                <p class="ml-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $condition['percentage'] }}%</p>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-slate-400 text-center py-6">{{ __('No data available') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
