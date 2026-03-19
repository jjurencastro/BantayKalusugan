<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Medical Advice') }}
            </h2>
            <a href="{{ route('patient.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Advice From Your Doctors') }}</h3>

                    @if($advices->count() > 0)
                        <div class="space-y-4">
                            @foreach($advices as $advice)
                                <div class="p-5 border-l-4 border-purple-500 bg-purple-50 dark:bg-slate-700 rounded">
                                    <div class="flex justify-between items-start gap-4 mb-3">
                                        <div>
                                            <h4 class="font-semibold text-gray-900 dark:text-white">
                                                {{ $advice->doctor?->user?->name ?? __('Assigned Doctor') }}
                                            </h4>
                                            <p class="text-xs text-gray-500">{{ $advice->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        @if($advice->follow_up_date)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                {{ __('Follow-up:') }} {{ $advice->follow_up_date->format('M d, Y') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="space-y-3">
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
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $advices->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No medical advice yet') }}</h3>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('Advice from doctors will appear here once available.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
