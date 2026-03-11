<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Security Management') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.security-audit') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    {{ __('View Audit Log') }}
                </a>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    {{ __('Back to Dashboard') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Security Status Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-red-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m7 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('System Status') }}</p>
                            <p class="text-xl font-semibold text-green-600 dark:text-green-400">{{ __('Secure') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-red-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Encrypted Data') }}</p>
                            <p class="text-xl font-semibold text-blue-600 dark:text-blue-400">100%</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-red-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-lg">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0 5v2m0-15a9.865 9.865 0 018.946 5.632A9.87 9.87 0 1112 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Active Users') }}</p>
                            <p class="text-xl font-semibold text-orange-600 dark:text-orange-400">{{ $activeUsers ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-red-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v2m0-15a9.865 9.865 0 018.946 5.632A9.87 9.87 0 1112 3z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Threats Detected') }}</p>
                            <p class="text-xl font-semibold text-red-600 dark:text-red-400">0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Protection Settings -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">{{ __('Data Protection Settings') }}</h3>
                    
                    <div class="space-y-6">
                        <!-- Backup Schedule -->
                        <div class="flex items-start justify-between p-4 border border-gray-200 dark:border-slate-700 rounded">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ __('Automated Backups') }}</h4>
                                <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">{{ __('Last backup: Today at 3:00 AM') }}</p>
                            </div>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                {{ __('Configure') }}
                            </button>
                        </div>

                        <!-- Encryption -->
                        <div class="flex items-start justify-between p-4 border border-gray-200 dark:border-slate-700 rounded">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ __('End-to-End Encryption') }}</h4>
                                <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">{{ __('All patient data is encrypted using AES-256') }}</p>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full text-sm font-semibold">
                                {{ __('Enabled') }}
                            </span>
                        </div>

                        <!-- Password Policy -->
                        <div class="flex items-start justify-between p-4 border border-gray-200 dark:border-slate-700 rounded">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ __('Password Policy') }}</h4>
                                <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">{{ __('Minimum 12 characters with special characters') }}</p>
                            </div>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                {{ __('Update') }}
                            </button>
                        </div>

                        <!-- Two-Factor Authentication -->
                        <div class="flex items-start justify-between p-4 border border-gray-200 dark:border-slate-700 rounded">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ __('Two-Factor Authentication') }}</h4>
                                <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">{{ __('Enforce 2FA for all admin accounts') }}</p>
                            </div>
                            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">
                                {{ __('Enable') }}
                            </button>
                        </div>

                        <!-- HIPAA Compliance -->
                        <div class="flex items-start justify-between p-4 border border-gray-200 dark:border-slate-700 rounded">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ __('HIPAA Compliance') }}</h4>
                                <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">{{ __('System follows HIPAA privacy and security standards') }}</p>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full text-sm font-semibold">
                                {{ __('Compliant') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Access Control -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Role-Based Access Control') }}</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">{{ __('Role') }}</th>
                                    <th class="px-4 py-3 text-left font-semibold">{{ __('View Patients') }}</th>
                                    <th class="px-4 py-3 text-left font-semibold">{{ __('Edit Data') }}</th>
                                    <th class="px-4 py-3 text-left font-semibold">{{ __('Delete Data') }}</th>
                                    <th class="px-4 py-3 text-left font-semibold">{{ __('Admin Panel') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ __('Patient') }}</td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                    <td class="px-4 py-3"><span class="text-gray-400">-</span></td>
                                    <td class="px-4 py-3"><span class="text-gray-400">-</span></td>
                                    <td class="px-4 py-3"><span class="text-gray-400">-</span></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ __('Nurse') }}</td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                    <td class="px-4 py-3"><span class="text-gray-400">-</span></td>
                                    <td class="px-4 py-3"><span class="text-gray-400">-</span></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ __('Doctor') }}</td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                    <td class="px-4 py-3"><span class="text-gray-400">-</span></td>
                                    <td class="px-4 py-3"><span class="text-gray-400">-</span></td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 font-medium">{{ __('Admin') }}</td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                    <td class="px-4 py-3"><span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 text-xs rounded">✓</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Activity Log Link -->
            <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-slate-700 dark:to-slate-600 border border-red-100 dark:border-slate-700 p-6 rounded-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2">{{ __('Security Audit Log') }}</h3>
                        <p class="text-sm text-gray-600 dark:text-slate-400">
                            {{ __('View all user activities and system-wide security events. Check who accessed what data and when.') }}
                        </p>
                    </div>
                    <a href="{{ route('admin.security-audit') }}" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium whitespace-nowrap">
                        {{ __('View Audit Log') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
