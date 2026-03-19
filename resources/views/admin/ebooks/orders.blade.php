@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Ebook Orders</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Review and manage customer ebook purchases</p>
    </div>
    <a href="{{ route('admin.ebooks.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold py-2 px-4 rounded transition duration-200">← Back to Ebooks</a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Order</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ebook</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Method</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Proof</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($orders as $order)
            <tr class="{{ $order->status === 'pending' ? 'bg-yellow-50 dark:bg-yellow-900/10' : '' }}">
                <td class="px-4 py-4 whitespace-nowrap">
                    <span class="text-xs font-mono font-bold text-gray-800 dark:text-white">{{ $order->order_number }}</span>
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $order->customer_name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $order->customer_email }}</div>
                    @if($order->customer_phone)
                        <div class="text-xs text-gray-400">{{ $order->customer_phone }}</div>
                    @endif
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                    {{ $order->ebook ? Str::limit($order->ebook->title, 25) : 'Deleted' }}
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-sm font-bold text-green-600">
                    ${{ number_format($order->amount, 2) }}
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    @if($order->payment_method === 'paypal')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">PayPal</span>
                    @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Bank Transfer</span>
                    @endif
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    @if($order->payment_proof)
                        <a href="{{ Storage::url($order->payment_proof) }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-xs font-semibold underline flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            View
                        </a>
                    @else
                        <span class="text-gray-400 text-xs">None</span>
                    @endif
                </td>
                <td class="px-4 py-4 whitespace-nowrap">
                    @if($order->status === 'pending')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">⏳ Pending</span>
                    @elseif($order->status === 'approved')
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">✅ Approved</span>
                    @else
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">❌ Declined</span>
                    @endif
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-xs text-gray-500 dark:text-gray-400">
                    {{ $order->created_at->format('M d, Y') }}
                    <div>{{ $order->created_at->format('H:i') }}</div>
                </td>
                <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @if($order->status === 'pending')
                        <div class="flex items-center justify-end gap-2">
                            <form action="{{ route('admin.ebook-orders.approve', $order) }}" method="POST" onsubmit="return confirm('Approve this order? The ebook PDF will be sent to the customer.')">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-1.5 px-3 rounded transition">
                                    ✅ Approve
                                </button>
                            </form>
                            <form action="{{ route('admin.ebook-orders.decline', $order) }}" method="POST" onsubmit="return confirm('Decline this order?')">
                                @csrf
                                <input type="hidden" name="admin_note" value="">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1.5 px-3 rounded transition">
                                    ❌ Decline
                                </button>
                            </form>
                        </div>
                    @else
                        <span class="text-xs text-gray-400">{{ $order->status === 'approved' ? 'Processed' : 'Declined' }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                    No ebook orders yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
