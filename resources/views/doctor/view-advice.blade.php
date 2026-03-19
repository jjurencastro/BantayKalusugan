<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('View Medical Advice') }}
            </h2>
            <a href="{{ route('doctor.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('info'))
                <div class="rounded-md bg-blue-100 text-blue-800 px-4 py-3 dark:bg-blue-900 dark:text-blue-200">
                    {{ session('info') }}
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700">
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Patient') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $advice->patient?->user?->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Incident') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $advice->healthIncident ? ucfirst(str_replace('_', ' ', $advice->healthIncident->incident_type)) : __('General Advice') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-slate-400">{{ __('Submitted') }}</p>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $advice->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700">
                <div class="p-6 space-y-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-slate-400">{{ __('Advice') }}</p>
                        <p class="text-sm text-gray-800 dark:text-slate-100 whitespace-pre-line">{{ $advice->advice }}</p>
                    </div>

                    @if($advice->medication)
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-slate-400">{{ __('Medication') }}</p>
                            <p class="text-sm text-gray-800 dark:text-slate-100 whitespace-pre-line">{{ $advice->medication }}</p>
                        </div>
                    @endif

                    @if($advice->follow_up_date)
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-slate-400">{{ __('Follow-up Date') }}</p>
                            <p class="text-sm text-gray-800 dark:text-slate-100">{{ $advice->follow_up_date->format('M d, Y') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>