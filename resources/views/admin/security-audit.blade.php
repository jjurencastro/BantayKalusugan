<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Security Audit') }}
            </h2>
            <a href="{{ route('admin.security') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Security') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">{{ __('Audit Checklist') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-slate-400 mb-6">
                        {{ __('Use this page as a quick operational checklist for regular security reviews.') }}
                    </p>

                    <div class="space-y-3">
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                            <span class="text-gray-800 dark:text-slate-100">{{ __('Review privileged user accounts') }}</span>
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">{{ __('Action Needed') }}</span>
                        </div>
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                            <span class="text-gray-800 dark:text-slate-100">{{ __('Rotate and revoke inactive access codes') }}</span>
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">{{ __('Action Needed') }}</span>
                        </div>
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                            <span class="text-gray-800 dark:text-slate-100">{{ __('Validate authentication and password reset flow') }}</span>
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">{{ __('Track Monthly') }}</span>
                        </div>
                        <div class="p-4 rounded-lg bg-gray-50 dark:bg-slate-700 flex justify-between items-center">
                            <span class="text-gray-800 dark:text-slate-100">{{ __('Review sensitive data exposure in logs') }}</span>
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">{{ __('Track Monthly') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
