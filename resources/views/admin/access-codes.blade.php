<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight">
                {{ __('Access Code Management') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="inline-block px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-4 rounded-lg">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Create New Code Form -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Create New Code</h2>
                    
                    <form method="POST" action="{{ route('admin.create-access-code') }}">
                        @csrf
                        
                        <!-- Role Selection -->
                        <div class="mb-4">
                            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Role
                            </label>
                            <select name="role" id="role" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                                <option value="">Select a role...</option>
                                <option value="nurse">Nurse</option>
                                <option value="doctor">Doctor</option>
                            </select>
                            @error('role')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Usage Limit -->
                        <div class="mb-4">
                            <label for="usage_limit" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Usage Limit (optional)
                            </label>
                            <input type="number" name="usage_limit" id="usage_limit" min="1" max="100" placeholder="Leave blank for unlimited" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                            @error('usage_limit')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiration Days -->
                        <div class="mb-6">
                            <label for="expires_days" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">
                                Expires in (days, optional)
                            </label>
                            <input type="number" name="expires_days" id="expires_days" min="1" max="365" placeholder="Leave blank for no expiry" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-red-500">
                            @error('expires_days')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition">
                            Generate Code
                        </button>
                    </form>
                </div>
            </div>

            <!-- Access Codes List -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Active & Inactive Codes</h2>
                    </div>

                    @if($accessCodes->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600">
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-slate-300 uppercase tracking-wider">Code</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-slate-300 uppercase tracking-wider">Role</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-slate-300 uppercase tracking-wider">Usage</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-slate-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-slate-300 uppercase tracking-wider">Expires</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-slate-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                                    @foreach($accessCodes as $code)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                            <td class="px-6 py-4">
                                                <span class="font-mono text-sm font-semibold text-red-600 dark:text-red-400">{{ $code->code }}</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-block px-3 py-1 text-sm font-medium rounded-full bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200">
                                                    {{ ucfirst(str_replace('_', ' ', $code->role)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                                                {{ $code->used_count }}
                                                @if($code->usage_limit)
                                                    / {{ $code->usage_limit }}
                                                @else
                                                    / ∞
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($code->is_active)
                                                    @if($code->expires_at && $code->expires_at->isPast())
                                                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                            Expired
                                                        </span>
                                                    @elseif($code->usage_limit && $code->used_count >= $code->usage_limit)
                                                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                                            Exhausted
                                                        </span>
                                                    @else
                                                        <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                                            Active
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                                        Revoked
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-slate-400">
                                                @if($code->expires_at)
                                                    {{ $code->expires_at->format('M d, Y') }}
                                                @else
                                                    <span class="text-gray-400">Never</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm space-x-2">
                                                @if($code->is_active)
                                                    <form method="POST" action="{{ route('admin.revoke-access-code', $code) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-yellow-600 hover:text-yellow-700 dark:text-yellow-400 dark:hover:text-yellow-300 font-medium" onclick="return confirm('Revoke this code?')">
                                                            Revoke
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST" action="{{ route('admin.delete-access-code', $code) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium" onclick="return confirm('Delete this code?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                            {{ $accessCodes->links() }}
                        </div>
                    @else
                        <div class="p-6 text-center text-gray-600 dark:text-slate-400">
                            <p>No access codes created yet. Create one using the form on the left.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
