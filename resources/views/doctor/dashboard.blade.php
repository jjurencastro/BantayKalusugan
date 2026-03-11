<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Doctor Dashboard') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('doctor.reports') }}" class="inline-block px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    {{ __('Review Reports') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Welcome Section -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700">
                <div class="p-6 text-gray-900 dark:text-slate-100">
                    <h3 class="text-xl font-semibold mb-2">{{ __('Welcome, Dr. ') }}{{ auth()->user()->name }}</h3>
                    <p class="text-gray-600 dark:text-slate-400">
                        {{ __('Review patient cases, provide medical advice, and issue health recommendations.') }}
                    </p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-purple-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Pending Requests') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $pendingRequests ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-purple-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Reports to Review') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $reportsForApproval ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-purple-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Advices Given') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $advicesGiven ?? 0 }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-slate-800 p-6 rounded-lg shadow-sm border border-purple-100 dark:border-slate-700">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-600 dark:text-slate-400 text-sm">{{ __('Patients Consulted') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $patientsConsulted ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Assistance Requests -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-purple-100 dark:border-slate-700">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('Recent Assistance Requests') }}</h3>
                        <a href="{{ route('doctor.reports') }}" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                            {{ __('View All') }}
                        </a>
                    </div>

                    @if(isset($recentRequests) && $recentRequests->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentRequests as $request)
                                <div class="p-4 border border-gray-200 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $request->patient->user->name }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-slate-400 mt-1">{{ ucfirst(str_replace('_', ' ', $request->incident_type)) }}</p>
                                            <p class="text-xs text-gray-500 mt-2">{{ $request->created_at->format('M d, Y h:i A') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if($request->severity === 'critical') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @elseif($request->severity === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                                @elseif($request->severity === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @endif">
                                                {{ ucfirst($request->severity) }}
                                            </span>
                                            <a href="{{ route('doctor.provide-advice', $request->patient) }}" class="block mt-2 text-purple-600 hover:text-purple-700 text-sm font-medium">
                                                {{ __('Provide Advice →') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-slate-400 text-center py-8">{{ __('No pending assistance requests.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
