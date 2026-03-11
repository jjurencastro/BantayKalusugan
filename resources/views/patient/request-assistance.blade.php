<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Request Medical Assistance') }}
            </h2>
            <a href="{{ route('patient.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('Report Health Incident') }}</h3>
                    <p class="text-gray-600 dark:text-slate-400 mb-6">{{ __('Describe your health condition or emergency to request medical assistance from our healthcare team.') }}</p>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('patient.store-assistance') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Incident Type -->
                        <div>
                            <label for="incident_type" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Type of Incident') }} <span class="text-red-600">*</span>
                            </label>
                            <select id="incident_type" name="incident_type" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="">{{ __('Select an incident type...') }}</option>
                                <option value="injury">{{ __('Injury') }}</option>
                                <option value="illness">{{ __('Illness') }}</option>
                                <option value="emergency">{{ __('Emergency') }}</option>
                                <option value="follow_up">{{ __('Follow-up Consultation') }}</option>
                                <option value="medication_issue">{{ __('Medication Issue') }}</option>
                                <option value="other">{{ __('Other') }}</option>
                            </select>
                            @error('incident_type')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Severity Level -->
                        <div>
                            <label for="severity" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Severity Level') }} <span class="text-red-600">*</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'critical' => 'Critical'] as $value => $label)
                                    <label class="flex items-center p-3 border-2 border-gray-300 dark:border-slate-600 rounded-lg cursor-pointer hover:border-red-500 transition
                                        @if(old('severity') === $value) border-red-500 bg-red-50 dark:bg-red-900/20 @endif">
                                        <input type="radio" name="severity" value="{{ $value }}" required class="w-4 h-4 text-red-600"
                                            @if(old('severity') === $value) checked @endif>
                                        <span class="ml-2 text-sm font-medium text-gray-700 dark:text-slate-300">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('severity')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Symptoms -->
                        <div>
                            <label for="symptoms" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Symptoms') }}
                            </label>
                            <textarea id="symptoms" name="symptoms" rows="3" placeholder="{{ __('List your symptoms or physical complaints...') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('symptoms') }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">{{ __('E.g., fever, headache, shortness of breath, etc.') }}</p>
                            @error('symptoms')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                {{ __('Description') }} <span class="text-red-600">*</span>
                            </label>
                            <textarea id="description" name="description" rows="5" required placeholder="{{ __('Provide detailed information about your health condition...') }}"
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('patient.dashboard') }}" class="px-6 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                                {{ __('Submit Request') }}
                            </button>
                        </div>
                    </form>

                    <!-- Help Section -->
                    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-slate-700">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">{{ __('Emergency Hotline') }}</h4>
                        <p class="text-gray-600 dark:text-slate-400">
                            {{ __('For life-threatening emergencies, please call 911 immediately instead of using this form.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
