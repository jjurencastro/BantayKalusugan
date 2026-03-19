<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Approve Medical Report') }}
            </h2>
            <a href="{{ route('doctor.reports') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Reports') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6 space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Report Details') }}</h3>
                        <p class="text-sm text-gray-600 dark:text-slate-400">
                            {{ __('Patient ID:') }} {{ $report->patient_id }} | {{ __('Submitted:') }} {{ $report->created_at->format('M d, Y h:i A') }}
                        </p>
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-700">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ __('Diagnosis') }}</h4>
                        <p class="text-sm text-gray-700 dark:text-slate-200 whitespace-pre-line">{{ $report->diagnosis }}</p>
                    </div>

                    <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-700">
                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">{{ __('Treatment Plan') }}</h4>
                        <p class="text-sm text-gray-700 dark:text-slate-200 whitespace-pre-line">{{ $report->treatment_plan }}</p>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-2">
                        <form method="POST" action="{{ route('doctor.store-approval', $report) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                {{ __('Approve Report') }}
                            </button>
                        </form>

                        <form method="POST" action="{{ route('doctor.store-approval', $report) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                {{ __('Reject Report') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
