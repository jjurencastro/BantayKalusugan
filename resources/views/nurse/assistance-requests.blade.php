<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Patient Assistance Requests') }}
            </h2>
            <a href="{{ route('nurse.dashboard') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <p class="text-sm text-blue-600 dark:text-blue-400 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ __('Read-only view. You can monitor assistance requests and their associated medical advice.') }}
                    </p>

                    @if($incidents->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-700 dark:text-slate-300">
                                <thead class="text-xs uppercase bg-gray-50 dark:bg-slate-700 text-gray-600 dark:text-slate-400">
                                    <tr>
                                        <th class="px-4 py-3">{{ __('Patient') }}</th>
                                        <th class="px-4 py-3">{{ __('Incident Type') }}</th>
                                        <th class="px-4 py-3">{{ __('Severity') }}</th>
                                        <th class="px-4 py-3">{{ __('Status') }}</th>
                                        <th class="px-4 py-3">{{ __('Medical Advice') }}</th>
                                        <th class="px-4 py-3">{{ __('Reported') }}</th>
                                        <th class="px-4 py-3">{{ __('Details') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach($incidents as $incident)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                                                {{ $incident->patient->user->name }}
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                    @if($incident->severity === 'critical') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                    @elseif($incident->severity === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                                    @elseif($incident->severity === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                    @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @endif">
                                                    {{ ucfirst($incident->severity) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    {{ ucfirst(str_replace('_', ' ', $incident->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                @if($incident->medicalAdvice)
                                                    <span class="text-green-600 dark:text-green-400 font-medium text-xs">
                                                        ✓ {{ __('Provided by Dr.') }} {{ $incident->medicalAdvice->doctor->user->name }}
                                                    </span>
                                                @else
                                                    <span class="text-yellow-600 dark:text-yellow-400 text-xs">{{ __('Pending') }}</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 text-gray-500 dark:text-slate-400 text-xs">
                                                {{ $incident->reported_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="{{ route('nurse.incident-detail', $incident) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                                    {{ __('View') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $incidents->links() }}
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-12">{{ __('No assistance requests found.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
