<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('View Health Alerts') }}
            </h2>
            <a href="{{ route('patient.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-red-100 dark:border-slate-700">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('All Health Alerts') }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('patient.alerts') }}?filter=unread" class="px-3 py-1 rounded text-sm bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200 hover:bg-blue-200">
                                {{ __('Unread') }}
                            </a>
                            <a href="{{ route('patient.alerts') }}?filter=all" class="px-3 py-1 rounded text-sm bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-200">
                                {{ __('All') }}
                            </a>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($alerts->count() > 0)
                        <div class="space-y-4">
                            @foreach($alerts as $alert)
                                <div class="p-5 border-l-4 {{ $alert->read_at ? 'border-gray-400 bg-gray-50 dark:bg-slate-700' : 'border-red-500 bg-red-50 dark:bg-slate-700' }} rounded">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h4 class="font-semibold text-gray-900 dark:text-white text-lg">{{ $alert->title ?? 'Health Alert' }}</h4>
                                                @if(!$alert->read_at)
                                                    <span class="inline-block px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded">{{ __('NEW') }}</span>
                                                @endif
                                            </div>
                                            <p class="text-gray-700 dark:text-slate-300 mb-3">{{ $alert->message ?? $alert->description }}</p>
                                            <div class="flex justify-between items-center">
                                                <p class="text-xs text-gray-500">
                                                    {{ $alert->created_at->format('M d, Y \a\t h:i A') }}
                                                </p>
                                                @if(!$alert->read_at)
                                                    <form method="POST" action="{{ route('patient.mark-alert-read', $alert) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-xs bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                            {{ __('Mark as Read') }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-xs text-green-600 font-semibold">{{ __('✓ Read') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('You\'re all caught up!') }}</h3>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('No health alerts at this time.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
