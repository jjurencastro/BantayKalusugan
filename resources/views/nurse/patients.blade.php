<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Registered Patients') }}
            </h2>
            <a href="{{ route('nurse.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-blue-100 dark:border-slate-700">
                <div class="p-6">
                    <!-- Search Bar -->
                    <div class="mb-6">
                        <input type="text" placeholder="{{ __('Search patients...') }}" id="searchInput"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    @if($patients->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Name') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Contact') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Age') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Status') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Last Update') }}</th>
                                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-slate-300">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach($patients as $patient)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                            <td class="px-4 py-3">
                                                <div>
                                                    <p class="font-medium text-gray-900 dark:text-white">{{ $patient->user->name }}</p>
                                                    <p class="text-xs text-gray-500">ID: {{ $patient->id }}</p>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3">
                                                <p class="text-gray-700 dark:text-slate-300">{{ $patient->user->email }}</p>
                                                <p class="text-xs text-gray-500">{{ $patient->user->phone ?? 'N/A' }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                <p class="text-gray-700 dark:text-slate-300">{{ $patient->age ?? 'N/A' }} {{ __('years') }}</p>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($patient->status === 'active' || $patient->status === null) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @elseif($patient->status === 'inactive') bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                    @endif">
                                                    {{ ucfirst($patient->status ?? 'active') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-slate-400 text-xs">
                                                {{ $patient->updated_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <a href="{{ route('nurse.patient-detail', $patient) }}" class="inline-block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition">
                                                    {{ __('View') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $patients->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM9 20H4v-2a3 3 0 013-3h2a3 3 0 013 3v2z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No patients found') }}</h3>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('No registered patients to display.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
