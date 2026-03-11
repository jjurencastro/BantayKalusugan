<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Community Health Status') }}
            </h2>
            <a href="{{ route('nurse.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Overview Stats -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-green-100 dark:border-slate-700">
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Total Population') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $communityStats['total_patients'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Active patients') }}</p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-green-100 dark:border-slate-700">
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Critical Cases') }}</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $communityStats['critical_cases'] ?? 0 }}</p>
                    <p class="text-xs text-red-500 mt-1">{{ __('Require immediate attention') }}</p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-green-100 dark:border-slate-700">
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Pending Updates') }}</p>
                    <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $communityStats['pending_updates'] ?? 0 }}</p>
                    <p class="text-xs text-orange-500 mt-1">{{ __('Health data missing') }}</p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-green-100 dark:border-slate-700">
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Healthy Status') }}</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $communityStats['healthy'] ?? 0 }}%</p>
                    <p class="text-xs text-green-500 mt-1">{{ __('Overall wellness') }}</p>
                </div>
            </div>

            <!-- Common Health Issues -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-green-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Common Health Issues') }}</h3>
                    
                    @if(isset($commonIssues) && count($commonIssues) > 0)
                        <div class="space-y-3">
                            @foreach($commonIssues as $issue)
                                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700 rounded">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $issue['name'] ?? 'Health Issue' }}</p>
                                        <p class="text-xs text-gray-500">{{ $issue['count'] ?? 0 }} {{ __('cases') }}</p>
                                    </div>
                                    <div class="w-40 bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                        <div class="bg-gradient-to-r from-green-500 to-blue-500 h-full rounded-full" style="width: {{ ($issue['count'] ?? 0) }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-8">{{ __('No health issues data available.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Recent Incidents by Severity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Critical & High -->
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Critical & High Severity Incidents') }}</h3>
                        
                        @if(isset($criticalIncidents) && $criticalIncidents->count() > 0)
                            <div class="space-y-2">
                                @foreach($criticalIncidents as $incident)
                                    <div class="p-3 border-l-4 border-red-500 bg-red-50 dark:bg-slate-700 rounded">
                                        <div class="flex justify-between">
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white text-sm">{{ ucfirst($incident->incident_type) }}</p>
                                                <p class="text-xs text-gray-600 dark:text-slate-400">{{ $incident->patient->user->name }}</p>
                                            </div>
                                            <span class="px-2 py-1 bg-red-600 text-white text-xs font-semibold rounded">{{ ucfirst($incident->severity) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600 dark:text-slate-400 text-center py-6">{{ __('No critical incidents recorded.') }}</p>
                        @endif
                    </div>
                </div>

                <!-- Community Demographics -->
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-green-100 dark:border-slate-700">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Age Distribution') }}</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('Children (0-12)') }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ageGroups['children'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full rounded-full" style="width: {{ $ageGroups['children'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('Teens (13-19)') }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ageGroups['teens'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-purple-500 h-full rounded-full" style="width: {{ $ageGroups['teens'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('Adults (20-59)') }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ageGroups['adults'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-500 h-full rounded-full" style="width: {{ $ageGroups['adults'] ?? 0 }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('Seniors (60+)') }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ageGroups['seniors'] ?? 0 }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-orange-500 h-full rounded-full" style="width: {{ $ageGroups['seniors'] ?? 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
