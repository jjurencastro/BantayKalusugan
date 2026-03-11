<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Incident Reports') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Incident Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-indigo-100 dark:border-slate-700">
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Total Incidents') }}</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalIncidents ?? 0 }}</p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-red-100 dark:border-slate-700">
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Critical') }}</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ $criticalIncidents ?? 0 }}</p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-orange-100 dark:border-slate-700">
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('High Severity') }}</p>
                    <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $highSeverity ?? 0 }}</p>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-green-100 dark:border-slate-700">
                    <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Resolved') }}</p>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $resolvedIncidents ?? 0 }}</p>
                </div>
            </div>

            <!-- Incidents by Type -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Incidents by Type') }}</h3>
                    
                    <div class="space-y-3">
                        @forelse([
                            ['type' => 'Injury', 'count' => 25],
                            ['type' => 'Illness', 'count' => 42],
                            ['type' => 'Emergency', 'count' => 8],
                            ['type' => 'Follow-up', 'count' => 35],
                            ['type' => 'Medication Issue', 'count' => 12],
                        ] as $type)
                            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700 rounded">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $type['type'] }}</p>
                                </div>
                                <div class="w-40 bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-gradient-to-r from-orange-500 to-red-500 h-full rounded-full" style="width: {{ ($type['count'] / 45) * 100 }}%"></div>
                                </div>
                                <p class="ml-4 text-sm font-semibold text-gray-900 dark:text-white">{{ $type['count'] }} {{ __('cases') }}</p>
                            </div>
                        @empty
                            <p class="text-gray-600 dark:text-slate-400 text-center py-6">{{ __('No incident data available') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Incidents Table -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Recent Health Incidents') }}</h3>
                    
                    @if(isset($recentIncidents) && $recentIncidents->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Patient') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Type') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Severity') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Status') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach($recentIncidents as $incident)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $incident->patient->user->name }}</td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-slate-300">{{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($incident->severity === 'critical') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                    @elseif($incident->severity === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                                    @elseif($incident->severity === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @endif">
                                                    {{ ucfirst($incident->severity) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($incident->status === 'reported') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @elseif($incident->status === 'under_review') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                    @elseif($incident->status === 'resolved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-slate-400 text-xs">{{ $incident->reported_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-8">{{ __('No recent incidents recorded.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Severity Trends -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Severity Distribution') }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('Critical') }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">15%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-red-600 h-full rounded-full" style="width: 15%"></div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('High') }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">30%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-orange-600 h-full rounded-full" style="width: 30%"></div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('Medium') }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">35%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-yellow-600 h-full rounded-full" style="width: 35%"></div>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-600 dark:text-slate-400">{{ __('Low') }}</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">20%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-600 h-2 rounded-full overflow-hidden">
                                    <div class="bg-green-600 h-full rounded-full" style="width: 20%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded">
                            <p class="text-sm text-gray-700 dark:text-slate-300 mb-3">
                                <strong>{{ __('Key Insights:') }}</strong>
                            </p>
                            <ul class="text-sm text-gray-600 dark:text-slate-400 space-y-2">
                                <li>• {{ __('45% of incidents require urgent attention') }}</li>
                                <li>• {{ __('Most common incident type: Illness (45%)') }}</li>
                                <li>• {{ __('Average resolution time: 3-5 days') }}</li>
                                <li>• {{ __('Recovery rate: 85% success') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
