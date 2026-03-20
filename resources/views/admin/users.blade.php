<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('User Management') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                    {{ __('Back to Dashboard') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-4 px-4 py-3 bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search Bar -->
            <div class="mb-6">
                <input type="text" placeholder="{{ __('Search users by name or email...') }}" id="searchInput"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Users Table -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-indigo-100 dark:border-slate-700">
                <div class="p-6">
                    @if($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-50 dark:bg-slate-700">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Name') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Email') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Role') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Status') }}</th>
                                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-slate-300">{{ __('Joined') }}</th>
                                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-slate-300">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach($users as $user)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                            <td class="px-4 py-3">
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                            </td>
                                            <td class="px-4 py-3 text-gray-700 dark:text-slate-300">{{ $user->email }}</td>
                                            <td class="px-4 py-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($user->role === 'patient') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                    @elseif($user->role === 'nurse') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @elseif($user->role === 'doctor') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                    @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($user->is_active ?? true) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200
                                                    @endif">
                                                    {{ ($user->is_active ?? true) ? __('Active') : __('Inactive') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 text-gray-600 dark:text-slate-400 text-xs">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <div class="flex justify-center gap-2 flex-wrap">
                                                    <a href="{{ route('admin.edit-user', $user) }}" class="px-3 py-1 bg-slate-600 text-white text-xs rounded hover:bg-slate-700 transition">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    @if($user->id !== auth()->id())
                                                        <form action="{{ route('admin.toggle-user-status', $user) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="px-3 py-1 text-white text-xs rounded transition {{ ($user->is_active ?? true) ? 'bg-gray-600 hover:bg-gray-700' : 'bg-slate-500 hover:bg-slate-600' }}">
                                                                {{ ($user->is_active ?? true) ? __('Deactivate') : __('Activate') }}
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <form action="{{ route('admin.delete-user', $user) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="px-3 py-1 bg-zinc-700 text-white text-xs rounded hover:bg-zinc-800 transition">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $users->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM9 20H4v-2a3 3 0 013-3h2a3 3 0 013 3v2z" />
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('No users found') }}</h3>
                            <p class="text-gray-600 dark:text-slate-400">{{ __('No registered users to display.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
