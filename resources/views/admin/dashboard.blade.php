@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-7xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white tracking-tight">Admin Dashboard</h1>
         <span class="inline-flex items-center px-3 py-1 rounded-full text-xs md:text-sm font-medium bg-green-100 text-green-800">
            <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
            System Healthy
        </span>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 md:p-6 transition hover:shadow-md">
            <div class="flex items-center justify-between mb-3 md:mb-4">
                <div class="p-2 md:p-3 rounded-xl bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <span class="text-[10px] md:text-xs font-semibold text-green-600 bg-green-50 px-1.5 py-0.5 md:px-2 md:py-1 rounded-full">+{{ $stats['new_users_today'] ?? '0' }}</span>
            </div>
            <div>
                <h3 class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</h3>
                <div class="flex items-baseline mt-1">
                    <p class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</p>
                </div>
                 <div class="mt-1 md:mt-2 text-xs md:text-sm text-gray-500">
                    <span class="text-green-600 font-medium">{{ $stats['active_users'] }} active</span>
                </div>
            </div>
        </div>

        <!-- Active Subscriptions -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 md:p-6 transition hover:shadow-md">
           <div class="flex items-center justify-between mb-3 md:mb-4">
                <div class="p-2 md:p-3 rounded-xl bg-green-50 text-green-600 dark:bg-green-900/20 dark:text-green-400">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400">Active Subs</h3>
                 <div class="flex items-baseline mt-1">
                    <p class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['active_subscriptions'] }}</p>
                </div>
                 <div class="mt-1 md:mt-2 text-xs md:text-sm text-gray-500">
                    <span class="text-red-500 font-medium">{{ $stats['expired_subscriptions'] }} expired</span>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 md:p-6 transition hover:shadow-md">
            <div class="flex items-center justify-between mb-3 md:mb-4">
                <div class="p-2 md:p-3 rounded-xl bg-yellow-50 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400">Revenue</h3>
                 <div class="flex items-baseline mt-1">
                    <p class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">${{ number_format($stats['total_revenue'], 0) }}</p>
                </div>
                <div class="mt-1 md:mt-2 text-xs md:text-sm text-gray-500">
                    <span class="text-gray-800 font-semibold dark:text-gray-200">${{ number_format($stats['monthly_revenue'], 0) }}</span> mo
                </div>
            </div>
        </div>
        
        <!-- Suspended Users -->
         <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 md:p-6 transition hover:shadow-md">
             <div class="flex items-center justify-between mb-3 md:mb-4">
                <div class="p-2 md:p-3 rounded-xl bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                </div>
            </div>
            <div>
                <h3 class="text-xs md:text-sm font-medium text-gray-500 dark:text-gray-400">Suspended</h3>
                <div class="flex items-baseline mt-1">
                    <p class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['suspended_users'] }}</p>
                </div>
                <div class="mt-1 md:mt-2 text-xs md:text-sm text-gray-500">
                    Action needed
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription Plans Distribution -->
    <div class="mb-8">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Active Subscriptions by Plan</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($stats['subscriptions_by_plan'] as $plan)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-4 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h4 class="font-semibold text-gray-800 text-xs dark:text-white">{{ $plan->name }}</h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $plan->duration }} Days • ${{ number_format($plan->price, 0) }}</p>
                        </div>
                        <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">
                            {{ $plan->subscriptions_count }} Active
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2 dark:bg-gray-700">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $stats['active_subscriptions'] > 0 ? ($plan->subscriptions_count / $stats['active_subscriptions']) * 100 : 0 }}%"></div>
                    </div>
                </div>
                @endforeach
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
        <!-- New Users -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800 dark:text-white">New Users</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700">View All</a>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700 flex-1 overflow-y-auto max-h-[400px]">
                @forelse($recent_users as $user)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                        <div class="flex items-center">
                           <div class="h-10 w-10 rounded-full bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center text-green-700 font-bold uppercase shadow-sm border border-green-100">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">No recent users found.</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Transactions -->
         <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800 dark:text-white">Latest Transactions</h3>
                <a href="{{ route('admin.transactions.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700">View All</a>
            </div>
             <div class="divide-y divide-gray-100 dark:divide-gray-700 flex-1 overflow-y-auto max-h-[400px]">
                @forelse($recent_transactions as $transaction)
                    <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                         <div class="flex items-center">
                            <div class="p-2 rounded-lg bg-green-50 text-green-600 mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $transaction->user->name }}</div>
                                <div class="text-xs text-gray-500">
                                    {{ $transaction->plan->name }}
                                </div>
                            </div>
                        </div>
                         <div class="text-right">
                             <div class="text-sm font-bold text-green-600 dark:text-green-400">+${{ number_format($transaction->amount, 2) }}</div>
                             <div class="text-xs text-gray-400">{{ $transaction->created_at->diffForHumans() }}</div>
                         </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-gray-500">No recent transactions.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
