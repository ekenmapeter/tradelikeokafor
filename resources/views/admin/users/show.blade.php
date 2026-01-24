@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-7xl">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="p-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 text-gray-500 hover:text-green-600 transition-colors shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white tracking-tight">User Details</h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm">Managing account of {{ $user->name }}</p>
            </div>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.users.impersonate', $user) }}" class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-semibold rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Impersonate
            </a>
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-sm transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit
            </a>
            @if($user->status === 'active')
                <form action="{{ route('admin.users.suspend', $user) }}" method="POST" onsubmit="return confirm('Suspend user?');">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-lg shadow-sm transition-colors">
                         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        Suspend
                    </button>
                </form>
            @else
                <form action="{{ route('admin.users.activate', $user) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-sm transition-colors">
                         <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Activate
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Profile Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                <div class="h-24 bg-gradient-to-r from-green-500 to-green-600"></div>
                <div class="px-6 pb-6">
                    <div class="relative -mt-12 mb-4">
                        <div class="h-24 w-24 rounded-2xl bg-white dark:bg-gray-700 p-1 shadow-md border-4 border-white dark:border-gray-800 inline-block overflow-hidden">
                            <div class="h-full w-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-700 dark:text-green-500 text-3xl font-bold uppercase">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-1">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $user->email }}</p>
                    
                    <div class="space-y-4">
                        <div class="flex items-center text-sm">
                            <span class="w-8 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </span>
                            <span class="text-gray-700 dark:text-gray-300">{{ $user->phone ?? 'Not provided' }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <span class="w-8 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </span>
                            <span class="text-gray-700 dark:text-gray-300">Joined {{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm">
                            <span class="w-8 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $user->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Subscription Box -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="font-bold text-gray-800 dark:text-white mb-4">Active Plan</h3>
                @if($user->activeSubscription)
                    <div class="p-4 bg-green-50 dark:bg-green-900/10 rounded-xl border border-green-100 dark:border-green-800/50">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-green-800 dark:text-green-400">{{ $user->activeSubscription->plan->name }}</h4>
                            <span class="text-xs font-bold text-green-600 dark:text-green-500 uppercase">Active</span>
                        </div>
                        <div class="text-xs text-green-700 dark:text-green-600 mb-4">
                            {{ $user->activeSubscription->end_date ? 'Expires on ' . $user->activeSubscription->end_date->format('M d, Y') : 'Lifetime Access' }}
                        </div>
                         <form action="{{ route('admin.subscriptions.cancel', $user->activeSubscription) }}" method="POST" onsubmit="return confirm('Cancel this subscription?');">
                            @csrf
                            <button type="submit" class="w-full py-2 bg-white dark:bg-gray-800 text-red-600 hover:text-red-700 border border-red-100 dark:border-red-900/30 rounded-lg text-xs font-bold transition-colors">
                                Cancel Plan
                            </button>
                        </form>
                    </div>
                @else
                    <div class="text-center py-6 bg-gray-50 dark:bg-gray-750 rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-500 mb-4">No active subscription</p>
                        <a href="{{ route('admin.subscriptions.create', ['user_id' => $user->id]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-bold rounded-lg transition-colors">
                            Assign Plan
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Main Activity -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Tabs -->
            <div x-data="{ activeTab: 'subscriptions' }">
                <div class="flex border-b border-gray-100 dark:border-gray-700 mb-6 overflow-x-auto">
                    <button @click="activeTab = 'subscriptions'" :class="activeTab === 'subscriptions' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-6 py-3 border-b-2 font-bold text-sm transition-colors whitespace-nowrap">
                        Subscriptions History
                    </button>
                    <button @click="activeTab = 'transactions'" :class="activeTab === 'transactions' ? 'border-green-600 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700'" class="px-6 py-3 border-b-2 font-bold text-sm transition-colors whitespace-nowrap">
                        Payment Transactions
                    </button>
                </div>

                <!-- Subscriptions Tab -->
                <div x-show="activeTab === 'subscriptions'" class="space-y-4">
                    @forelse($user->subscriptions as $sub)
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-gray-50 dark:bg-gray-700 flex items-center justify-center text-gray-400 mr-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 dark:text-white text-sm">{{ $sub->plan->name }}</h4>
                                    <p class="text-[10px] text-gray-500">
                                        {{ $sub->start_date->format('M d, Y') }} - {{ $sub->end_date ? $sub->end_date->format('M d, Y') : 'Lifetime' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $sub->status === 'active' ? 'bg-green-100 text-green-700' : ($sub->status === 'expired' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ $sub->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 text-gray-500">
                            No subscription history found.
                        </div>
                    @endforelse
                </div>

                <!-- Transactions Tab -->
                <div x-show="activeTab === 'transactions'" class="space-y-4" style="display: none;">
                    @forelse($user->transactions as $tx)
                        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-xl bg-green-50 dark:bg-green-900/10 flex items-center justify-center text-green-600 mr-4">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 dark:text-white text-sm">{{ $tx->plan->name }}</h4>
                                    <p class="text-[10px] text-gray-500">Ref: {{ $tx->reference ?? 'Manual' }} • {{ $tx->created_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 w-full sm:w-auto justify-between sm:justify-end">
                                <div class="text-right">
                                    <div class="font-bold text-gray-900 dark:text-white">${{ number_format($tx->amount, 2) }}</div>
                                    <div class="text-[10px] font-bold uppercase {{ $tx->status === 'completed' ? 'text-green-600' : 'text-amber-500' }}">{{ $tx->status }}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 text-gray-500">
                            No transactions found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
