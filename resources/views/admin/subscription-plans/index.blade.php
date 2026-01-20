@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-7xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white tracking-tight">Subscription Plans</h1>
        <a href="{{ route('admin.subscription-plans.create') }}" class="w-full md:w-auto bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-colors flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Create New Plan
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        
        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Duration</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subscribers</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($plans as $plan)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-50 rounded-lg mr-3 shadow-sm border border-green-100">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            {{ $plan->name }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 font-mono">
                        ${{ number_format($plan->price, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                        {{ $plan->duration_days }} days
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                         <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-semibold">
                            {{ $plan->subscriptions_count }} Active
                         </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                         <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $plan->is_active ? 'bg-green-100/60 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                            {{ $plan->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="text-blue-600 hover:text-blue-800 mr-4 font-semibold">Edit</a>
                        
                        <form action="{{ route('admin.subscription-plans.toggle', $plan) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="{{ $plan->is_active ? 'text-amber-600 hover:text-amber-800' : 'text-green-600 hover:text-green-800' }} mr-4 font-semibold">
                                {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.subscription-plans.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this plan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">No subscription plans found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <!-- Mobile View: Cards -->
        <div class="md:hidden divide-y divide-gray-100 dark:divide-gray-700">
             @forelse($plans as $plan)
             <div class="p-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
                <div class="flex justify-between items-start mb-3">
                     <div class="flex items-center">
                        <div class="p-2 bg-green-50 rounded-lg mr-3 shadow-sm border border-green-100">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div>
                             <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $plan->name }}</h3>
                             <span class="text-xs font-mono text-gray-500">${{ number_format($plan->price, 2) }} / {{ $plan->duration_days }} days</span>
                        </div>
                    </div>
                     <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                        {{ $plan->is_active ? 'bg-green-100/60 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-600 border border-gray-200' }}">
                        {{ $plan->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center text-sm text-gray-500 mb-4 px-1">
                     <span>Current Subscribers:</span>
                     <span class="font-bold text-gray-800">{{ $plan->subscriptions_count }}</span>
                </div>

                <div class="flex grid grid-cols-3 gap-2 border-t border-gray-100 pt-3">
                    <a href="{{ route('admin.subscription-plans.edit', $plan) }}" class="flex items-center justify-center text-sm font-semibold text-blue-600 bg-blue-50 py-1.5 rounded hover:bg-blue-100">Edit</a>
                    
                    <form action="{{ route('admin.subscription-plans.toggle', $plan) }}" method="POST" class="flex-1 block">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center text-sm font-semibold {{ $plan->is_active ? 'text-amber-700 bg-amber-50 hover:bg-amber-100' : 'text-green-700 bg-green-50 hover:bg-green-100' }} py-1.5 rounded">
                                {{ $plan->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                    </form>

                     <form action="{{ route('admin.subscription-plans.destroy', $plan) }}" method="POST" class="flex-1 block" onsubmit="return confirm('Delete this plan?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center text-sm font-semibold text-red-600 bg-red-50 py-1.5 rounded hover:bg-red-100">Delete</button>
                    </form>
                </div>
             </div>
             @empty
                <div class="p-8 text-center text-sm text-gray-500">No plans found.</div>
             @endforelse
        </div>

         <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700 sm:px-6">
            {{ $plans->links() }}
        </div>
    </div>
</div>
@endsection
