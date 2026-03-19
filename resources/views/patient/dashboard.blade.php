<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Patient Dashboard') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('patient.alerts') }}" class="inline-block px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    {{ __('View Alerts') }}
                </a>
                <a href="{{ route('patient.medical-advice') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    {{ __('Medical Advice') }}
                </a>
                <a href="{{ route('patient.request-assistance') }}" class="inline-block px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition">
                    {{ __('Request Medical Assistance') }}
                </a>
                <a href="{{ route('patient.report-incident') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    {{ __('Report Incident') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <h3 class="text-xl font-semibold mb-2">{{ __('Welcome Back, ') }}{{ auth()->user()->name }}</h3>
                    <p class="text-gray-600 dark:text-slate-400">
                        {{ __('Monitor your health status and stay connected with healthcare professionals.') }}
                    </p>
                </div>
            </div>

            <!-- Health Alerts Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">{{ __('Recent Health Alerts') }}</h3>
                    
                    @if($healthAlerts->count() > 0)
                        <div class="space-y-3">
                            @foreach($healthAlerts as $alert)
                                <div class="p-4 border-l-4 border-red-500 bg-red-50 dark:bg-slate-700 rounded">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $alert->title ?? 'Health Alert' }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ $alert->message ?? $alert->description }}</p>
                                            <p class="text-xs text-gray-500 mt-2">{{ $alert->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        @if(!$alert->is_read)
                                            <form method="POST" action="{{ route('patient.mark-alert-read', $alert) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-xs bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                    {{ __('Mark as Read') }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-green-600 font-semibold">{{ __('Read') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-8">{{ __('No unread alerts at this time.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Recent Health Incidents Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Your Incidents and Assistance Requests') }}</h3>
                        <a href="{{ route('patient.report-incident') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                            {{ __('+ Report New Incident') }}
                        </a>
                    </div>
                    
                    @if($healthIncidents->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-4 py-2 text-left">{{ __('Type') }}</th>
                                        <th class="px-4 py-2 text-left">{{ __('Severity') }}</th>
                                        <th class="px-4 py-2 text-left">{{ __('Status') }}</th>
                                        <th class="px-4 py-2 text-left">{{ __('Date Reported') }}</th>
                                        <th class="px-4 py-2 text-left">{{ __('Advice') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach($healthIncidents as $incident)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                            <td class="px-4 py-2">
                                                <a href="{{ route('patient.incidents.show', $incident) }}" class="text-blue-600 hover:text-blue-700 font-medium">
                                                    {{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}
                                                </a>
                                            </td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                                    @if($incident->severity === 'critical') bg-red-600
                                                    @elseif($incident->severity === 'high') bg-orange-600
                                                    @elseif($incident->severity === 'medium') bg-yellow-600
                                                    @else bg-green-600
                                                    @endif">
                                                    {{ ucfirst($incident->severity) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">
                                                <span class="px-2 py-1 rounded text-xs font-semibold
                                                    @if($incident->status === 'reported') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @elseif($incident->status === 'under_review') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                    @elseif($incident->status === 'resolved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">{{ $incident->reported_at->format('M d, Y') }}</td>
                                            <td class="px-4 py-2">
                                                @if($incident->medicalAdvice)
                                                    <a href="{{ route('patient.incidents.show', $incident) }}" class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                                        {{ __('View Advice') }}
                                                    </a>
                                                @else
                                                    <span class="text-xs text-gray-500">{{ __('Pending') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-8">{{ __('No incidents reported yet.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Quick Stats Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-red-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Active Alerts') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $healthAlerts->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-red-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Total Incidents') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $totalIncidentsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-red-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Resolved') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $resolvedIncidentsCount ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
