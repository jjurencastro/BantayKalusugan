<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Create Medical Report') }}
            </h2>
            <a href="{{ route('doctor.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Incident Summary') }}</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Patient ID') }}</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $incident->patient_id }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Incident Type') }}</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $incident->incident_type)) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Severity') }}</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst($incident->severity) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Status') }}</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $incident->status)) }}</p>
                        </div>
                    </div>
                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-700">
                        <p class="text-sm text-gray-600 dark:text-slate-400 mb-1">{{ __('Description') }}</p>
                        <p class="text-sm text-gray-800 dark:text-slate-100 whitespace-pre-line">{{ $incident->description }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <form method="POST" action="{{ route('doctor.store-report', $incident) }}" class="space-y-5">
                        @csrf

                        <div>
                            <x-input-label for="diagnosis" :value="__('Diagnosis')" />
                            <textarea id="diagnosis" name="diagnosis" rows="5" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('diagnosis') }}</textarea>
                            <x-input-error :messages="$errors->get('diagnosis')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="treatment_plan" :value="__('Treatment Plan')" />
                            <textarea id="treatment_plan" name="treatment_plan" rows="5" class="mt-1 block w-full rounded-md border-gray-300 dark:border-slate-700 dark:bg-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('treatment_plan') }}</textarea>
                            <x-input-error :messages="$errors->get('treatment_plan')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('doctor.dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                {{ __('Submit Report') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
