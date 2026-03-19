<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Generated Report') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6 flex flex-wrap gap-4 text-sm text-gray-700 dark:text-slate-200">
                    <span class="px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                        {{ __('Type:') }} {{ ucfirst($validated['report_type']) }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-200">
                        {{ __('Start:') }} {{ \Illuminate\Support\Carbon::parse($startDate)->format('M d, Y') }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-200">
                        {{ __('End:') }} {{ \Illuminate\Support\Carbon::parse($endDate)->format('M d, Y') }}
                    </span>
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        {{ __('Records:') }} {{ $data->count() }}
                    </span>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    @if($data->isEmpty())
                        <p class="text-center py-8 text-gray-600 dark:text-slate-400">{{ __('No records found for the selected filters.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-slate-700 text-gray-700 dark:text-slate-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left">{{ __('ID') }}</th>
                                        @if($validated['report_type'] === 'health')
                                            <th class="px-4 py-3 text-left">{{ __('Patient ID') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Diagnosis') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Status') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Created') }}</th>
                                        @elseif($validated['report_type'] === 'incidents')
                                            <th class="px-4 py-3 text-left">{{ __('Patient ID') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Incident Type') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Severity') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Status') }}</th>
                                        @else
                                            <th class="px-4 py-3 text-left">{{ __('Name') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Email') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Role') }}</th>
                                            <th class="px-4 py-3 text-left">{{ __('Created') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700 text-gray-700 dark:text-slate-200">
                                    @foreach($data as $row)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                            <td class="px-4 py-3">{{ $row->id }}</td>
                                            @if($validated['report_type'] === 'health')
                                                <td class="px-4 py-3">{{ $row->patient_id }}</td>
                                                <td class="px-4 py-3">{{ \Illuminate\Support\Str::limit($row->diagnosis, 80) }}</td>
                                                <td class="px-4 py-3">{{ ucfirst($row->status) }}</td>
                                                <td class="px-4 py-3">{{ optional($row->created_at)->format('M d, Y') }}</td>
                                            @elseif($validated['report_type'] === 'incidents')
                                                <td class="px-4 py-3">{{ $row->patient_id }}</td>
                                                <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $row->incident_type)) }}</td>
                                                <td class="px-4 py-3">{{ ucfirst($row->severity) }}</td>
                                                <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $row->status)) }}</td>
                                            @else
                                                <td class="px-4 py-3">{{ $row->name }}</td>
                                                <td class="px-4 py-3">{{ $row->email }}</td>
                                                <td class="px-4 py-3">{{ ucfirst(str_replace('_', ' ', $row->role)) }}</td>
                                                <td class="px-4 py-3">{{ optional($row->created_at)->format('M d, Y') }}</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
