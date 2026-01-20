@extends('user.layout')

@section('content')
<div class="container mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Transaction History</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden" x-data="{ openDetail: false, currentTransaction: {} }">
        <!-- Filter -->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900">
            <form action="{{ route('user.transactions') }}" method="GET" class="flex gap-4">
                <select name="status" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Statuses</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filter
                </button>
            </form>
        </div>

        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Plan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($transactions as $transaction)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $transaction->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        {{ $transaction->plan->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        ${{ number_format($transaction->amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500 dark:text-gray-400">
                        {{ $transaction->reference }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <button 
                            @click="openDetail = true; currentTransaction = {
                                id: '{{ $transaction->id }}',
                                plan: '{{ $transaction->plan->name }}',
                                amount: '${{ number_format($transaction->amount, 2) }}',
                                reference: '{{ $transaction->reference }}',
                                status: '{{ ucfirst($transaction->status) }}',
                                date: '{{ $transaction->created_at->format('M d, Y H:i') }}',
                                proof: '{{ $transaction->proof ? Storage::url($transaction->proof) : '' }}',
                                notes: '{{ addslashes($transaction->admin_notes) }}'
                            }"
                            class="text-blue-600 hover:text-blue-900 bg-blue-50 dark:bg-blue-900/30 px-3 py-1 rounded transition-colors"
                        >
                            View Details
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Transaction Details Modal -->
        <div x-show="openDetail" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="openDetail" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity" @click="openDetail = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
                <div x-show="openDetail" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white mb-4" id="modal-title">
                                    Transaction Details
                                </h3>
                                <div class="mt-2 space-y-3">
                                    <div class="flex justify-between border-b border-gray-100 dark:border-gray-700 pb-2 text-sm">
                                        <span class="text-gray-500">Reference:</span>
                                        <span class="font-mono font-medium text-gray-900 dark:text-white" x-text="currentTransaction.reference"></span>
                                    </div>
                                    <div class="flex justify-between border-b border-gray-100 dark:border-gray-700 pb-2 text-sm">
                                        <span class="text-gray-500">Plan:</span>
                                        <span class="font-medium text-gray-900 dark:text-white" x-text="currentTransaction.plan"></span>
                                    </div>
                                    <div class="flex justify-between border-b border-gray-100 dark:border-gray-700 pb-2 text-sm">
                                        <span class="text-gray-500">Amount:</span>
                                        <span class="font-bold text-gray-900 dark:text-white" x-text="currentTransaction.amount"></span>
                                    </div>
                                    <div class="flex justify-between border-b border-gray-100 dark:border-gray-700 pb-2 text-sm">
                                        <span class="text-gray-500">Status:</span>
                                        <span x-text="currentTransaction.status" :class="{
                                            'text-green-600': currentTransaction.status === 'Completed',
                                            'text-yellow-600': currentTransaction.status === 'Pending',
                                            'text-red-600': currentTransaction.status === 'Failed'
                                        }" class="font-bold"></span>
                                    </div>
                                    <div class="flex justify-between border-b border-gray-100 dark:border-gray-700 pb-2 text-sm">
                                        <span class="text-gray-500">Date:</span>
                                        <span class="text-gray-900 dark:text-white" x-text="currentTransaction.date"></span>
                                    </div>

                                    <template x-if="currentTransaction.notes">
                                        <div class="mt-4 p-3 bg-red-50 dark:bg-red-900/20 rounded-lg text-sm">
                                            <p class="font-semibold text-red-800 dark:text-red-300">Admin Notes:</p>
                                            <p class="text-red-700 dark:text-red-400 mt-1" x-text="currentTransaction.notes"></p>
                                        </div>
                                    </template>

                                    <div class="mt-4" x-show="currentTransaction.proof">
                                        <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Payment Proof:</p>
                                        <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                                            <img :src="currentTransaction.proof" class="max-w-full h-auto" alt="Payment Proof">
                                        </div>
                                        <div class="mt-2 text-center">
                                            <a :href="currentTransaction.proof" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 font-medium">Open in full size</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm" @click="openDetail = false">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            {{ $transactions->links() }}
        </div>
    </div>
    </div>
</div>
@endsection
