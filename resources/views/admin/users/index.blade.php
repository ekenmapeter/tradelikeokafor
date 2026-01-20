@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-7xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white tracking-tight">User Management</h1>
        <a href="{{ route('admin.users.create') }}" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Add New User
        </a>
    </div>

    <!-- Mobile Filter Toggle (Optional, can just stack filters on mobile) -->
    
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Search and Filter -->
        <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
            <form action="{{ route('admin.users.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" placeholder="Search by name or email" value="{{ request('search') }}" class="pl-10 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm w-full py-2.5">
                </div>
                
                <div class="flex gap-3">
                    <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5 flex-1 md:w-40">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                    
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                        Search
                    </button>
                </div>
            </form>
        </div>

        <!-- Desktop View: Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subscription</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold uppercase shadow-sm border border-green-200">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-green-600 transition-colors">{{ $user->name }}</a>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->status === 'active' ? 'bg-green-100/60 text-green-800 border border-green-200' : 'bg-red-100/60 text-red-800 border border-red-200' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->activeSubscription)
                            <span class="text-sm text-green-700 font-semibold bg-green-50 px-2 py-0.5 rounded">{{ $user->activeSubscription->plan->name }}</span>
                            <div class="text-xs text-gray-500 mt-0.5">Expires: {{ $user->activeSubscription->end_date->format('M d, Y') }}</div>
                        @else
                            <span class="text-sm text-gray-400 italic">No Active Plan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.users.impersonate', $user) }}" class="text-purple-600 hover:text-purple-800 mr-4 font-semibold">Impersonate</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 mr-4 font-semibold">Edit</a>
                        
                        @if($user->status === 'active')
                            <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to suspend this user?');">
                                @csrf
                                <button type="submit" class="text-amber-600 hover:text-amber-800 mr-4 font-semibold">Suspend</button>
                            </form>
                        @else
                             <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to activate this user?');">
                                @csrf
                                <button type="submit" class="text-green-600 hover:text-green-800 mr-4 font-semibold">Activate</button>
                            </form>
                        @endif

                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No users found matching your criteria.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <!-- Mobile View: Cards -->
        <div class="md:hidden">
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($users as $user)
                <div class="p-4 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center">
                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold uppercase shadow-sm border border-green-200">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="ml-3">
                             <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-bold text-gray-900 dark:text-white hover:text-green-600 transition-colors">{{ $user->name }}</a>
                             <div class="text-xs text-gray-500">{{ $user->email }}</div>
                         </div>
                        </div>
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $user->status === 'active' ? 'bg-green-100/60 text-green-800 border border-green-200' : 'bg-red-100/60 text-red-800 border border-red-200' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center mb-3 text-sm">
                        <span class="text-gray-500">Subscription:</span>
                        @if($user->activeSubscription)
                            <div class="text-right">
                                <span class="bg-green-50 text-green-700 px-2 py-0.5 rounded text-xs font-semibold">{{ $user->activeSubscription->plan->name }}</span>
                                <div class="text-[10px] text-gray-400 mt-0.5">Expires: {{ $user->activeSubscription->end_date->format('M d') }}</div>
                            </div>
                        @else
                            <span class="text-gray-400 italic">None</span>
                        @endif
                    </div>
                    
                     <div class="flex justify-between items-center mb-3 text-sm">
                        <span class="text-gray-500">Joined:</span>
                        <span class="text-gray-700 dark:text-gray-300 font-medium">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>

                    <div class="mt-4 flex justify-end space-x-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('admin.users.impersonate', $user) }}" class="text-purple-600 hover:text-purple-800 font-semibold text-sm">Impersonate</a>
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 font-semibold text-sm">Edit</a>
                         @if($user->status === 'active')
                            <form action="{{ route('admin.users.suspend', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to suspend this user?');">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-amber-600 hover:text-amber-800">Suspend</button>
                            </form>
                        @else
                             <form action="{{ route('admin.users.activate', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to activate this user?');">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-green-600 hover:text-green-800">Activate</button>
                            </form>
                        @endif
                         <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </div>
                </div>
                @empty
                 <div class="p-8 text-center text-sm text-gray-500">No users found.</div>
                @endforelse
            </div>
        </div>

         <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700 sm:px-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
