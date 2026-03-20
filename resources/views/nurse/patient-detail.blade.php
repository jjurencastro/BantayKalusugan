<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Patient Profile: ') }}{{ $patient->user->name }}
            </h2>
            <a href="{{ route('nurse.patients') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Patients') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Patient Info Card -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Full Name') }}</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $patient->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Email') }}</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $patient->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Age') }}</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $patient->age ?? 'N/A' }} {{ __('years') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Blood Type') }}</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $patient->blood_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Contact Number') }}</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $patient->user->phone ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Patient Status') }}</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                <span class="px-3 py-1 rounded-full text-sm
                                    @if($patient->status === 'active' || $patient->status === null) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($patient->status === 'inactive') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                    @endif">
                                    {{ ucfirst($patient->status ?? 'active') }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update Health Data Form -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Update Health Data') }}</h3>

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('nurse.update-patient-health', $patient) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('POST')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Blood Pressure -->
                            <div>
                                <label for="blood_pressure" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('Blood Pressure (mmHg)') }}
                                </label>
                                <input type="text" id="blood_pressure" name="blood_pressure" placeholder="{{ __('e.g., 120/80') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('blood_pressure', $latestHealthUpdate->blood_pressure ?? '') }}">
                            </div>

                            <!-- Heart Rate -->
                            <div>
                                <label for="heart_rate" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('Heart Rate (bpm)') }}
                                </label>
                                <input type="number" id="heart_rate" name="heart_rate" placeholder="{{ __('e.g., 72') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('heart_rate', $latestHealthUpdate->heart_rate ?? '') }}">
                            </div>

                            <!-- Temperature -->
                            <div>
                                <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('Temperature (°C)') }}
                                </label>
                                <input type="number" id="temperature" name="temperature" step="0.1" placeholder="{{ __('e.g., 36.5') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('temperature', $latestHealthUpdate->temperature ?? '') }}">
                            </div>

                            <!-- Weight -->
                            <div>
                                <label for="weight" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('Weight (kg)') }}
                                </label>
                                <input type="number" id="weight" name="weight" step="0.1" placeholder="{{ __('e.g., 70') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('weight', $latestHealthUpdate->weight ?? '') }}">
                            </div>

                            <!-- Oxygen Level -->
                            <div>
                                <label for="oxygen_level" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('Oxygen Level (%)') }}
                                </label>
                                <input type="number" id="oxygen_level" name="oxygen_level" min="0" max="100" placeholder="{{ __('e.g., 98') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('oxygen_level', $latestHealthUpdate->oxygen_level ?? '') }}">
                            </div>

                            <!-- Glucose Level -->
                            <div>
                                <label for="glucose_level" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                    {{ __('Glucose Level (mg/dL)') }}
                                </label>
                                <input type="number" id="glucose_level" name="glucose_level" placeholder="{{ __('e.g., 100') }}"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    value="{{ old('glucose_level', $latestHealthUpdate->glucose_level ?? '') }}">
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Clinical Notes') }}
                            </label>
                            <textarea id="notes" name="notes" rows="4" placeholder="{{ __('Add clinical observations and notes...') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $latestHealthUpdate->notes ?? '') }}</textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                                {{ __('Update Health Data') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Send Health Alert -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Send Health Alert') }}</h3>

                    <form action="{{ route('nurse.store-health-alert', $patient) }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="alert_type" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">{{ __('Alert Type') }}</label>
                                <select id="alert_type" name="alert_type" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="high_bp">{{ __('High Blood Pressure') }}</option>
                                    <option value="fever">{{ __('Fever') }}</option>
                                    <option value="unusual_symptoms">{{ __('Unusual Symptoms') }}</option>
                                    <option value="medication_reminder">{{ __('Medication Reminder') }}</option>
                                    <option value="follow_up">{{ __('Follow-up Required') }}</option>
                                    <option value="emergency">{{ __('Emergency') }}</option>
                                    <option value="other">{{ __('Other') }}</option>
                                </select>
                                @error('alert_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label for="severity" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">{{ __('Severity') }}</label>
                                <select id="severity" name="severity" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                                    <option value="low">{{ __('Low') }}</option>
                                    <option value="medium" selected>{{ __('Medium') }}</option>
                                    <option value="high">{{ __('High') }}</option>
                                    <option value="critical">{{ __('Critical') }}</option>
                                </select>
                                @error('severity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label for="alert_message" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">{{ __('Message') }}</label>
                            <textarea id="alert_message" name="message" rows="3"
                                placeholder="{{ __('Describe the health concern or alert details...') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('message') }}</textarea>
                            @error('message')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                                {{ __('Send Alert') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Health History -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Health History') }}</h3>
                    
                    @if($healthHistory && $healthHistory->count() > 0)
                        <div class="space-y-3">
                            @foreach($healthHistory as $update)
                                <div class="p-4 border border-gray-200 dark:border-slate-700 rounded">
                                    <p class="text-xs text-gray-500 mb-2">{{ $update->created_at->format('M d, Y h:i A') }}</p>
                                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                        @if($update->blood_pressure)
                                            <div><span class="text-gray-600 dark:text-slate-400">BP:</span> <span class="font-semibold text-gray-900 dark:text-white">{{ $update->blood_pressure }}</span></div>
                                        @endif
                                        @if($update->heart_rate)
                                            <div><span class="text-gray-600 dark:text-slate-400">HR:</span> <span class="font-semibold text-gray-900 dark:text-white">{{ $update->heart_rate }} bpm</span></div>
                                        @endif
                                        @if($update->temperature)
                                            <div><span class="text-gray-600 dark:text-slate-400">Temp:</span> <span class="font-semibold text-gray-900 dark:text-white">{{ $update->temperature }}°C</span></div>
                                        @endif
                                        @if($update->oxygen_level)
                                            <div><span class="text-gray-600 dark:text-slate-400">O₂:</span> <span class="font-semibold text-gray-900 dark:text-white">{{ $update->oxygen_level }}%</span></div>
                                        @endif
                                        @if($update->glucose_level)
                                            <div><span class="text-gray-600 dark:text-slate-400">Glucose:</span> <span class="font-semibold text-gray-900 dark:text-white">{{ $update->glucose_level }} mg/dL</span></div>
                                        @endif
                                    </div>
                                    @if($update->notes)
                                        <p class="text-sm text-gray-600 dark:text-slate-400 mt-2">{{ __('Notes:') }} {{ $update->notes }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-8">{{ __('No health history available.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
