@extends('admin.layout')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Profit Record Keeping</h2>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.profit-records.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition duration-200 shadow-md">
            Record New Profit
        </a>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-sm" role="alert">
        {{ session('error') }}
    </div>
@endif

<div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ref ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Student Profit</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Our Commission</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Evidence</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($records as $record)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400">
                    {{ $record->reference_id }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    {{ $record->student_display_name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $record->currency }} {{ number_format($record->profit_amount, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 dark:text-white">
                    {{ $record->currency }} {{ number_format($record->commission_received, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $record->evidences->count() }} Files
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $record->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <a href="{{ route('admin.profit-records.show', $record) }}" class="text-blue-600 hover:text-blue-900 mr-3">View Details</a>
                    <form action="{{ route('admin.profit-records.destroy', $record) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this record? This will also delete all evidence screenshots.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                    No profit records found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $records->links() }}
</div>
@endsection
