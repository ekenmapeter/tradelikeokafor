@extends('user.layout')

@section('content')
<div class="container mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Subscription Management</h1>
    </div>

    @if($activeSubscription)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8 border-l-4 border-green-500">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Active Subscription</h2>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $activeSubscription->plan->name }}</p>
                <p class="text-gray-500 dark:text-gray-400 mt-1">
                    Valid until {{ $activeSubscription->end_date->format('F j, Y') }}
                </p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    Active
                </span>
                <p class="text-sm text-gray-500 mt-2">{{ $activeSubscription->daysRemaining() }} days remaining</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Available Plans -->
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Available Plans</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        @foreach($availablePlans as $plan)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col hover:shadow-xl transition-shadow duration-300">
            <div class="p-6 flex-1">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $plan->name }}</h3>
                <div class="mt-4 flex items-baseline text-gray-900 dark:text-white">
                    <span class="text-3xl font-extrabold tracking-tight">${{ number_format($plan->price, 2) }}</span>
                    <span class="ml-1 text-xl font-semibold text-gray-500">/ {{ $plan->duration_days }} days</span>
                </div>
                <p class="mt-4 text-gray-500 dark:text-gray-400">
                    {{ $plan->description }}
                </p>
            </div>
            <div class="p-6 bg-gray-50 dark:bg-gray-750 border-t border-gray-200 dark:border-gray-700 space-y-3">
                <a href="{{ $plan->payment_link }}" target="_blank" class="block w-full bg-blue-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-blue-700 transition duration-150">
                    Subscribe Now (Automatic)
                </a>
                <a href="{{ route('user.subscriptions.manual-payment', $plan) }}" class="block w-full bg-gray-600 border border-transparent rounded-md py-2 text-sm font-semibold text-white text-center hover:bg-gray-700 transition duration-150">
                    Manual Bank Transfer
                </a>
                <p class="text-xs text-center text-gray-500 mt-2">External or Manual Payment</p>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Subscription History -->
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">History</h2>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Plan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Start Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">End Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($subscriptionHistory as $sub)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $sub->plan->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $sub->start_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $sub->end_date->format('M d, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $sub->status === 'active' ? 'bg-green-100 text-green-800' : 
                               ($sub->status === 'expired' ? 'bg-gray-100 text-gray-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No subscription history found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $subscriptionHistory->links() }}
        </div>
    </div>
</div>
@endsection
