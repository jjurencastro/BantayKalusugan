<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Provide Medical Advice') }}
            </h2>
            <a href="{{ route('doctor.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Patient Information -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Patient Information') }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Name') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $patient->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Age') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $patient->age ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Blood Type') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $patient->blood_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Contact') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $patient->user->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Latest Nurse Health Update') }}</h3>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mb-4">{{ __('Read-only data entered by nursing staff.') }}</p>

                    @if($latestHealthUpdate)
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Blood Pressure') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $latestHealthUpdate->blood_pressure ?? __('N/A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Heart Rate') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $latestHealthUpdate->heart_rate ? $latestHealthUpdate->heart_rate . ' BPM' : __('N/A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Temperature') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $latestHealthUpdate->temperature ? $latestHealthUpdate->temperature . ' °C' : __('N/A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Weight') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $latestHealthUpdate->weight ? $latestHealthUpdate->weight . ' kg' : __('N/A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Height') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $latestHealthUpdate->height ? $latestHealthUpdate->height . ' cm' : __('N/A') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Recorded At') }}</p>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $latestHealthUpdate->recorded_at?->format('M d, Y h:i A') ?? __('N/A') }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Nurse Notes') }}</p>
                            <p class="text-gray-900 dark:text-white whitespace-pre-line">{{ $latestHealthUpdate->notes ?? __('No notes provided.') }}</p>
                        </div>

                        <div class="mt-3 text-xs text-gray-500 dark:text-slate-400">
                            {{ __('Updated by:') }} {{ $latestHealthUpdate->nurse?->user?->name ?? __('Nurse') }}
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-6">{{ __('No nurse health updates recorded yet.') }}</p>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Selected Assistance Request') }}</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Incident Type') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Severity') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ ucfirst($incident->severity) }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Reported') }}</p>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $incident->reported_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Symptoms') }}</p>
                            <p class="text-gray-900 dark:text-white">{{ $incident->symptoms ?: __('No symptoms provided.') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Description') }}</p>
                            <p class="text-gray-900 dark:text-white whitespace-pre-line">{{ $incident->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Health Incidents -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Recent Health Incidents') }}</h3>

                    @if($recentIncidents && $recentIncidents->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentIncidents as $recentIncident)
                                <div class="p-4 border-l-4 border-orange-500 bg-orange-50 dark:bg-slate-700 rounded">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $recentIncident->incident_type)) }}</h4>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            @if($recentIncident->severity === 'critical') bg-red-600 text-white
                                            @elseif($recentIncident->severity === 'high') bg-orange-600 text-white
                                            @elseif($recentIncident->severity === 'medium') bg-yellow-600 text-white
                                            @else bg-green-600 text-white
                                            @endif">
                                            {{ ucfirst($recentIncident->severity) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700 dark:text-slate-300 text-sm">{{ $recentIncident->description }}</p>
                                    @if($recentIncident->symptoms)
                                        <p class="text-sm text-gray-600 dark:text-slate-400 mt-2"><strong>{{ __('Symptoms:') }}</strong> {{ $recentIncident->symptoms }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500 mt-2">{{ $recentIncident->reported_at->format('M d, Y h:i A') }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-6">{{ __('No recent incidents recorded.') }}</p>
                    @endif
                </div>
            </div>

            <!-- Medical Advice Form -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Medical Advice') }}</h3>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('doctor.store-advice', $incident) }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Diagnosis -->
                        <div>
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Diagnosis') }} <span class="text-red-600">*</span>
                            </label>
                            <textarea id="diagnosis" name="diagnosis" rows="3" required placeholder="{{ __('Provide your diagnosis based on patient symptoms...') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('diagnosis') }}</textarea>
                            @error('diagnosis')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Treatment Plan -->
                        <div>
                            <label for="treatment_plan" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Treatment Plan') }} <span class="text-red-600">*</span>
                            </label>
                            <textarea id="treatment_plan" name="treatment_plan" rows="4" required placeholder="{{ __('Outline the recommended treatment plan...') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('treatment_plan') }}</textarea>
                            @error('treatment_plan')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Medication -->
                        <div>
                            <label for="medication" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Prescribed Medication (Optional)') }}
                            </label>
                            <textarea id="medication" name="medication" rows="3" placeholder="{{ __('List prescribed medications, dosage, and frequency...') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('medication') }}</textarea>
                        </div>

                        <!-- Recommendations -->
                        <div>
                            <label for="recommendations" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Health Recommendations (Optional)') }}
                            </label>
                            <textarea id="recommendations" name="recommendations" rows="3" placeholder="{{ __('Additional health recommendations (diet, rest, follow-ups, etc.)...') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('recommendations') }}</textarea>
                        </div>

                        <!-- Follow-up Date -->
                        <div>
                            <label for="follow_up_date" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Follow-up Date (Optional)') }}
                            </label>
                            <input type="text" id="follow_up_date" name="follow_up_date" data-date-picker
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                                value="{{ old('follow_up_date') }}">
                            <p class="text-xs text-gray-500 mt-1">{{ __('Select a follow-up date from the calendar.') }}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                            <a href="{{ route('doctor.dashboard') }}" class="px-6 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-medium">
                                {{ __('Submit Medical Advice') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
