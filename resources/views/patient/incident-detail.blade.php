<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Incident Details') }}
            </h2>
            <a href="{{ route('patient.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Reported Assistance') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4 text-sm">
                        <div>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Type') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Severity') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($incident->severity) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Status') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Reported') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $incident->reported_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Symptoms') }}</p>
                            <p class="text-gray-900 dark:text-white whitespace-pre-line">{{ $incident->symptoms ?: __('No symptoms provided.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Description') }}</p>
                            <p class="text-gray-900 dark:text-white whitespace-pre-line">{{ $incident->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Doctor Advice') }}</h3>

                    @if($incident->medicalAdvice)
                        <div class="space-y-4">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Provided by') }}</p>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $incident->medicalAdvice->doctor?->user?->name ?? __('Assigned Doctor') }}</p>
                                </div>
                                <div class="text-right text-xs text-gray-500">
                                    {{ $incident->medicalAdvice->created_at->format('M d, Y h:i A') }}
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-slate-400">{{ __('Advice') }}</p>
                                <p class="text-sm text-gray-800 dark:text-slate-100 whitespace-pre-line">{{ $incident->medicalAdvice->advice }}</p>
                            </div>

                            @if($incident->medicalAdvice->medication)
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-slate-400">{{ __('Medication') }}</p>
                                    <p class="text-sm text-gray-800 dark:text-slate-100 whitespace-pre-line">{{ $incident->medicalAdvice->medication }}</p>
                                </div>
                            @endif

                            @if($incident->medicalAdvice->follow_up_date)
                                <div>
                                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-slate-400">{{ __('Follow-up Date') }}</p>
                                    <p class="text-sm text-gray-800 dark:text-slate-100">{{ $incident->medicalAdvice->follow_up_date->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400">{{ __('No doctor advice has been attached to this assistance request yet.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>