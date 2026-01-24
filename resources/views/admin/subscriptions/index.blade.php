@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-7xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white tracking-tight">User Subscriptions</h1>
        <a href="{{ route('admin.subscriptions.create') }}" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Assign Subscription
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Filter -->
        <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
            <form action="{{ route('admin.subscriptions.index') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                 <div class="flex gap-3 w-full md:w-auto">
                    <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5 flex-1 md:w-48">
                        <option value="">All Statuses</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    
                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm">
                        Filter
                    </button>
                 </div>
            </form>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Plan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Start Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">End Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($subscriptions as $sub)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                         <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $sub->user->name }}</div>
                         <div class="text-xs text-gray-500 font-normal">{{ $sub->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                         <span class="text-sm font-semibold text-gray-700 bg-gray-100 px-2 py-0.5 rounded">{{ $sub->plan->name }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $sub->start_date ? $sub->start_date->format('M d, Y') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $sub->end_date ? $sub->end_date->format('M d, Y') : 'Lifetime' }}
                        @if($sub->isActive() && $sub->isExpiringSoon())
                            <div class="text-xs text-amber-600 font-semibold mt-0.5 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Expiring soon
                            </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                         <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $sub->status === 'active' ? 'bg-green-100/60 text-green-800 border border-green-200' : 
                               ($sub->status === 'expired' ? 'bg-gray-100 text-gray-800 border border-gray-200' : 'bg-red-100/60 text-red-800 border border-red-200') }}">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($sub->status === 'active')
                            <form action="{{ route('admin.subscriptions.cancel', $sub) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this subscription?');">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900 font-semibold bg-red-50 hover:bg-red-100 px-3 py-1 rounded transition-colors">Cancel</button>
                            </form>
                        @else
                            <span class="text-gray-400 italic text-xs">No actions</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">No subscriptions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <!-- Mobile View: Cards -->
        <div class="md:hidden divide-y divide-gray-100 dark:divide-gray-700">
             @forelse($subscriptions as $sub)
             <div class="p-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
                 <div class="flex justify-between items-start mb-3">
                     <div>
                         <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $sub->user->name }}</h3>
                         <div class="text-xs text-gray-500">{{ $sub->user->email }}</div>
                     </div>
                     <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $sub->status === 'active' ? 'bg-green-100/60 text-green-800 border border-green-200' : 
                           ($sub->status === 'expired' ? 'bg-gray-100 text-gray-800 border border-gray-200' : 'bg-red-100/60 text-red-800 border border-red-200') }}">
                        {{ ucfirst($sub->status) }}
                    </span>
                 </div>

                 <div class="bg-gray-50 rounded p-3 mb-3 text-sm">
                     <div class="flex justify-between mb-1">
                         <span class="text-gray-500">Plan:</span>
                         <span class="font-semibold text-gray-800">{{ $sub->plan->name }}</span>
                     </div>
                     <div class="flex justify-between mb-1">
                         <span class="text-gray-500">Starts:</span>
                         <span>{{ $sub->start_date ? $sub->start_date->format('M d, Y') : '-' }}</span>
                     </div>
                     <div class="flex justify-between">
                         <span class="text-gray-500">Ends:</span>
                         <span class="{{ $sub->isActive() && $sub->isExpiringSoon() ? 'text-amber-600 font-medium' : '' }}">
                            {{ $sub->end_date ? $sub->end_date->format('M d, Y') : 'Lifetime' }}
                         </span>
                     </div>
                 </div>

                 @if($sub->status === 'active')
                    <div class="flex justify-end pt-2">
                        <form action="{{ route('admin.subscriptions.cancel', $sub) }}" method="POST" class="inline w-full" onsubmit="return confirm('Cancel subscription?');">
                            @csrf
                            <button type="submit" class="w-full text-center text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 py-2 rounded transition-colors">Cancel Subscription</button>
                        </form>
                    </div>
                @endif
             </div>
             @empty
                <div class="p-8 text-center text-sm text-gray-500">No subscriptions found.</div>
             @endforelse
        </div>

         <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700 sm:px-6">
            {{ $subscriptions->links() }}
        </div>
    </div>
</div>
@endsection
