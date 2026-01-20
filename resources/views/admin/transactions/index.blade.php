@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-7xl">
    <div class="mb-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-white tracking-tight">Transactions</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Filter -->
        <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50">
            <form action="{{ route('admin.transactions.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                 <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" placeholder="Search user or ref..." value="{{ request('search') }}" 
                        class="pl-9 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm w-full py-2.5">
                </div>
                
                <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5">
                    <option value="">All Statuses</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>

                <div class="flex gap-2 items-center">
                     <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5">
                     <span class="text-gray-400">-</span>
                     <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500 text-sm py-2.5">
                </div>
                
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2.5 px-6 rounded-lg transition-colors shadow-sm w-full md:w-auto">
                    Filter Records
                </button>
            </form>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Plan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Reference</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Proof</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($transactions as $transaction)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $transaction->created_at->format('M d, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                         <div class="flex items-center">
                            <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold uppercase text-xs mr-3">
                                {{ substr($transaction->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $transaction->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-semibold">{{ $transaction->plan->name }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white">
                        ${{ number_format($transaction->amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-gray-500 dark:text-gray-400">
                        <span class="bg-gray-50 px-2 py-1 rounded">{{ $transaction->reference }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($transaction->proof)
                            <a href="{{ Storage::url($transaction->proof) }}" target="_blank" class="text-blue-600 hover:text-blue-900 flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View
                            </a>
                        @else
                            <span class="text-gray-400">No Proof</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $transaction->status === 'completed' ? 'bg-green-100/60 text-green-800 border border-green-200' : 
                                ($transaction->status === 'pending' ? 'bg-yellow-100/60 text-yellow-800 border border-yellow-200' : 'bg-red-100/60 text-red-800 border border-red-200') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($transaction->status === 'pending')
                            <div class="flex justify-end space-x-2">
                                <form action="{{ route('admin.transactions.approve', $transaction) }}" method="POST" onsubmit="return confirm('Approve this payment and activate plan?')">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 px-2 py-1 rounded">Approve</button>
                                </form>
                                <button onclick="rejectTransaction({{ $transaction->id }})" class="text-red-600 hover:text-red-900 bg-red-50 px-2 py-1 rounded">Reject</button>
                            </div>
                        @else
                            <span class="text-gray-400">No Actions</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-500">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <script>
            function rejectTransaction(id) {
                const notes = prompt('Enter reason for rejection:');
                if (notes !== null) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/transactions/${id}/reject`;
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';
                    const notesInput = document.createElement('input');
                    notesInput.type = 'hidden';
                    notesInput.name = 'notes';
                    notesInput.value = notes;
                    form.appendChild(csrf);
                    form.appendChild(notesInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>

        <!-- Mobile View: Cards -->
        <div class="md:hidden divide-y divide-gray-100 dark:divide-gray-700">
             @forelse($transactions as $transaction)
             <div class="p-4 bg-white dark:bg-gray-800 hover:bg-gray-50 transition-colors">
                 <div class="flex justify-between items-start mb-3">
                     <div class="flex items-center">
                         <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold uppercase text-xs mr-3 shadow-sm">
                            {{ substr($transaction->user->name, 0, 1) }}
                        </div>
                         <div>
                             <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $transaction->user->name }}</h3>
                             <div class="text-xs text-gray-500">{{ $transaction->created_at->format('M d, H:i') }}</div>
                         </div>
                     </div>
                     <div class="text-right">
                         <div class="text-sm font-bold text-gray-900 dark:text-white">${{ number_format($transaction->amount, 2) }}</div>
                         <span class="px-2 inline-flex text-[10px] leading-4 font-semibold rounded-full mt-1
                            {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                               ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($transaction->status) }}
                        </span>
                     </div>
                 </div>

                 <div class="bg-gray-50 rounded p-2 text-xs flex justify-between items-center border border-gray-100">
                     <span class="text-gray-500">Ref: <span class="font-mono text-gray-700">{{ $transaction->reference }}</span></span>
                     <span class="font-semibold text-gray-700">{{ $transaction->plan->name }}</span>
                 </div>
             </div>
             @empty
                <div class="p-8 text-center text-sm text-gray-500">No transactions found.</div>
             @endforelse
        </div>

        <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700 sm:px-6">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection
