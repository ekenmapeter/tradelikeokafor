@extends('user.layout')

@section('content')
<div class="container mx-auto max-w-6xl">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white tracking-tight">Welcome back, {{ explode(' ', $user->name)[0] }}!</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Here is what's happening with your account today.</p>
        </div>
        <div class="hidden md:block">
             <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                System Operational
            </span>
        </div>
    </div>

    <!-- Active Subscription Card -->
    <div class="bg-gradient-to-br from-green-600 to-emerald-800 rounded-2xl shadow-xl p-6 md:p-8 text-white mb-10 relative overflow-hidden transition-transform transform hover:scale-[1.01] duration-300">
        <!-- Abstract Background Pattern -->
        <div class="absolute right-0 top-0 opacity-10 transform translate-x-10 -translate-y-10">
            <svg class="h-64 w-64" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
        </div>
        <div class="absolute bottom-0 left-0 opacity-10 transform -translate-x-10 translate-y-10">
             <svg class="h-48 w-48" fill="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle></svg>
        </div>
        
        <div class="relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-indigo-100 font-medium mb-1 uppercase tracking-wider text-sm">Current Membership</h2>
                    @if($activeSubscription)
                        <div class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight text-white">{{ $activeSubscription->plan->name }}</div>
                        <div class="flex flex-wrap items-center gap-4 text-sm md:text-base">
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                <span class="block text-indigo-100 text-xs uppercase">Status</span>
                                <span class="font-bold text-white flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Active
                                </span>
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                <span class="block text-indigo-100 text-xs uppercase">Expires In</span>
                                <span class="font-bold text-white">{{ $activeSubscription->daysRemaining() }} days</span> 
                            </div>
                            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                                <span class="block text-indigo-100 text-xs uppercase">Valid Until</span>
                                <span class="font-bold text-white">{{ $activeSubscription->end_date->format('M d, Y') }}</span>
                            </div>
                        </div>
                    @else
                        <div class="text-3xl md:text-4xl font-bold mb-3">No Active Plan</div>
                        <p class="mb-6 text-indigo-100 max-w-lg leading-relaxed">Upgrade now to unlock premium trading signals, exclusive market analysis, and mentorship.</p>
                        <a href="{{ route('user.subscriptions') }}" class="inline-flex items-center bg-white text-green-700 font-bold py-3 px-8 rounded-xl hover:bg-gray-50 transition duration-300 shadow-md transform hover:-translate-y-1">
                            Choose a Plan
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
         <!-- Account Status -->
         <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 lg:col-span-1">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800 dark:text-white">Profile Details</h3>
                <a href="{{ route('profile.edit') }}" class="p-2 bg-gray-50 hover:bg-gray-100 rounded-full transition-colors text-gray-500 hover:text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                </a>
            </div>
            
            <div class="flex flex-col items-center mb-6">
                <div class="h-24 w-24 rounded-full bg-green-100 flex items-center justify-center text-green-600 text-3xl font-bold mb-3 shadow-inner">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->name }}</h4>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                <div class="mt-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Member since {{ $user->created_at->format('M Y') }}
                </div>
            </div>

            <div class="border-t border-gray-100 dark:border-gray-700 pt-4 space-y-3">
                 <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Phone</span>
                    <span class="text-sm font-medium text-gray-800 dark:text-white">{{ $user->phone ?? 'Not set' }}</span>
                 </div>
                 <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500 dark:text-gray-400">Account Status</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst($user->status) }}
                    </span>
                 </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden lg:col-span-2 flex flex-col">
             <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50/50">
                 <h3 class="text-lg font-bold text-gray-800 dark:text-white">Recent Transactions</h3>
                 <a href="{{ route('user.transactions') }}" class="text-sm font-medium text-green-600 hover:text-green-700 flex items-center transition-colors">
                    View All 
                    <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                 </a>
             </div>
             <div class="flex-1 overflow-y-auto">
                 @forelse($recentTransactions as $transaction)
                    <div class="px-6 py-4 flex flex-col sm:flex-row sm:justify-between sm:items-center hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex items-center mb-2 sm:mb-0">
                            <div class="p-2 rounded-lg bg-green-50 text-green-600 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                 <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $transaction->plan->name }}</div>
                                 <div class="text-xs text-gray-500">{{ $transaction->created_at->format('M d, Y • h:i A') }}</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between sm:justify-end w-full sm:w-auto pl-12 sm:pl-0">
                             <div class="text-sm font-bold text-gray-800 dark:text-white mr-4">${{ number_format($transaction->amount, 2) }}</div>
                             <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                 {{ ucfirst($transaction->status) }}
                             </span>
                        </div>
                    </div>
                 @empty
                    <div class="px-6 py-12 text-center">
                        <div class="bg-gray-50 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">No transactions recorded yet.</p>
                    </div>
                 @endforelse
             </div>
        </div>
    </div>
</div>
@endsection
