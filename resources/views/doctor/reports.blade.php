<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Medical Reports Review') }}
            </h2>
            <a href="{{ route('doctor.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="mb-6 flex gap-2 flex-wrap">
                <a href="{{ route('doctor.reports') }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300' }} hover:bg-purple-700 transition">
                    {{ __('All Reports') }}
                </a>
                <a href="{{ route('doctor.reports', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'pending' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300' }} hover:bg-yellow-700 transition">
                    {{ __('Pending Approval') }}
                </a>
                <a href="{{ route('doctor.reports', ['status' => 'approved']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'approved' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300' }} hover:bg-green-700 transition">
                    {{ __('Approved') }}
                </a>
                <a href="{{ route('doctor.reports', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'rejected' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-slate-300' }} hover:bg-red-700 transition">
                    {{ __('Rejected') }}
                </a>
            </div>

            @if($reports->count() > 0)
                <div class="space-y-4">
                    @foreach($reports as $report)
                        <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border 
                            @if($report->status === 'pending') border-yellow-100 dark:border-slate-700
                            @elseif($report->status === 'approved') border-green-100 dark:border-slate-700
                            @else border-red-100 dark:border-slate-700
                            @endif">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $report->patient->user->name }}</h3>
                                        <p class="text-sm text-gray-600 dark:text-slate-400">
                                            {{ __('Incident Type:') }}
                                            {{ $report->healthIncident?->incident_type ? ucfirst(str_replace('_', ' ', $report->healthIncident->incident_type)) : __('N/A') }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $report->created_at->format('M d, Y h:i A') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                                            @if($report->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                            @elseif($report->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                            @endif">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-4 p-4 bg-gray-50 dark:bg-slate-700 rounded space-y-2">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-slate-400">{{ __('Diagnosis') }}</p>
                                        <p class="text-sm text-gray-700 dark:text-slate-300 whitespace-pre-line">{{ $report->diagnosis }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-slate-400">{{ __('Treatment Plan') }}</p>
                                        <p class="text-sm text-gray-700 dark:text-slate-300 whitespace-pre-line">{{ $report->treatment_plan }}</p>
                                    </div>
                                </div>

                                @if($report->status === 'pending')
                                    <div class="flex gap-3">
                                        <a href="{{ route('doctor.approve-report', $report) }}" class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 transition">
                                            {{ __('Approve') }}
                                        </a>
                                        <button class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition" onclick="alert('{{ __('Implement rejection functionality') }}')">
                                            {{ __('Reject') }}
                                        </button>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-600 dark:text-slate-400">
                                        <strong>{{ __('Status:') }}</strong> {{ ucfirst($report->status) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $reports->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No reports found') }}</h3>
                    <p class="text-gray-600 dark:text-slate-400">{{ __('No medical reports to review.') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
