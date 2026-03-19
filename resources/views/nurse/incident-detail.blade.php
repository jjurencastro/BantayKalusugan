<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Assistance Request Detail') }}
            </h2>
            <a href="{{ route('nurse.assistance-requests') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Requests') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 dark:border-green-700 dark:bg-green-900/20 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Patient Information -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Patient Information') }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Name') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $incident->patient->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Age') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $incident->patient->age ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Blood Type') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $incident->patient->blood_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Contact') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $incident->patient->user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Incident Details -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Assistance Request Details') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Request Type') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Severity') }}</p>
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                                @if($incident->severity === 'critical') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @elseif($incident->severity === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                @elseif($incident->severity === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @endif">
                                {{ ucfirst($incident->severity) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Reported') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $incident->reported_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        @if($incident->symptoms)
                            <div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Symptoms') }}</p>
                                <p class="text-gray-900 dark:text-white">{{ $incident->symptoms }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Description') }}</p>
                            <p class="text-gray-900 dark:text-white whitespace-pre-line">{{ $incident->description }}</p>
                        </div>
                    </div>

                    @if($incident->status !== 'resolved')
                        <div class="mt-6 border-t border-gray-200 dark:border-slate-700 pt-4">
                            <form action="{{ route('nurse.approve-assistance-request', $incident) }}" method="POST" onsubmit="return confirm('{{ __('Approve this assistance request?') }}')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center rounded bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition">
                                    {{ __('Approve Assistance Request') }}
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Medical Advice (read-only) -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Medical Advice') }}</h3>

                    @if($incident->medicalAdvice)
                        @php $advice = $incident->medicalAdvice; @endphp
                        <div class="space-y-4">
                            <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>{{ __('Provided by Dr.') }} {{ $advice->doctor->user->name }}
                                    &mdash; {{ $advice->created_at->format('M d, Y h:i A') }}</span>
                            </div>

                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-slate-400 mb-1">{{ __('Advice') }}</p>
                                <p class="text-gray-900 dark:text-white whitespace-pre-line bg-gray-50 dark:bg-slate-700 rounded p-3">{{ $advice->advice }}</p>
                            </div>

                            @if($advice->medication)
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-slate-400 mb-1">{{ __('Prescribed Medication') }}</p>
                                    <p class="text-gray-900 dark:text-white whitespace-pre-line bg-gray-50 dark:bg-slate-700 rounded p-3">{{ $advice->medication }}</p>
                                </div>
                            @endif

                            @if($advice->follow_up_date)
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-slate-400 mb-1">{{ __('Follow-up Date') }}</p>
                                    <p class="text-gray-900 dark:text-white font-semibold">{{ $advice->follow_up_date->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-10 h-10 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('No medical advice has been provided yet. Waiting for a doctor.') }}</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
