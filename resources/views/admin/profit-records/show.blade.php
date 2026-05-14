@extends('admin.layout')

@section('content')
    <div class="mb-6 flex justify-between items-start">
        <div>
            <a href="{{ route('admin.profit-records.index') }}"
                class="text-green-600 hover:text-green-700 flex items-center gap-1 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Back to Records
            </a>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mt-2">Audit Detail: <span
                    class="text-green-600">{{ $profitRecord->reference_id }}</span></h2>
            <p class="text-sm text-gray-500 mt-1">Recorded on {{ $profitRecord->created_at->format('F d, Y \a\t h:i A') }}
            </p>
        </div>
        <div class="flex gap-2">
            <button onclick="window.print()"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded transition flex items-center gap-2 print:hidden">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Print Audit
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">
                    Transaction Summary</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Student</p>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">
                            @if ($profitRecord->student)
                                <a href="{{ route('admin.users.show', $profitRecord->student) }}"
                                    class="text-green-600 hover:underline">
                                    {{ $profitRecord->student->name }}
                                </a>
                            @else
                                {{ $profitRecord->student_name }} (Manual Entry)
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold tracking-wider mb-1">Reason for Profit</p>
                        <p class="text-gray-900 dark:text-white">{{ $profitRecord->reason }}</p>
                    </div>
                </div>

                <div
                    class="bg-gray-50 dark:bg-gray-900 rounded-xl p-6 grid grid-cols-1 md:grid-cols-2 gap-4 border dark:border-gray-700">
                    <div class="text-center md:border-r dark:border-gray-700">
                        <p class="text-sm text-gray-500 mb-1">Student Profit</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $profitRecord->currency }}
                            {{ number_format($profitRecord->profit_amount, 2) }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-500 mb-1">Commission Received</p>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $profitRecord->currency }}
                            {{ number_format($profitRecord->commission_received, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b dark:border-gray-700 pb-2">
                    Evidence Screenshots ({{ $profitRecord->evidences->count() }})</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach ($profitRecord->evidences as $evidence)
                        <div class="relative group">
                            <a href="{{ Storage::url($evidence->file_path) }}" target="_blank" class="block">
                                <img src="{{ Storage::url($evidence->file_path) }}" alt="{{ $evidence->file_name }}"
                                    class="w-full h-48 object-cover rounded-lg border dark:border-gray-700 hover:opacity-90 transition shadow-sm">
                            </a>
                            <div class="mt-2 flex justify-between items-center px-1">
                                <span
                                    class="text-xs text-gray-500 truncate max-w-[150px]">{{ $evidence->file_name }}</span>
                                <a href="{{ Storage::url($evidence->file_path) }}" download
                                    class="text-green-600 hover:text-green-700 text-xs font-bold">Download</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Metadata / Audit Info --}}
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-t-4 border-green-500">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Audit Metadata</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Created By</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $profitRecord->admin->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Admin IP Address</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $profitRecord->ip_address ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold">Timestamp</p>
                        <p class="text-sm text-gray-900 dark:text-white">
                            {{ $profitRecord->created_at->toDayDateTimeString() }}</p>
                    </div>
                    <div class="pt-4 border-t dark:border-gray-700">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                            <p class="text-xs text-blue-700 dark:text-blue-300 flex gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                This record is immutable and was logged for compliance and auditing purposes.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 print:hidden">
                <h3 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h3>
                <p class="text-xs text-gray-500 mb-4">Deleting this record will permanently remove it and all associated
                    evidence files from the server.</p>
                <form action="{{ route('admin.profit-records.destroy', $profitRecord) }}" method="POST"
                    onsubmit="return confirm('WARNING: Are you sure you want to permanently delete this audit record? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded transition">
                        Delete Record Permanently
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                background-color: white;
                color: black;
            }

            .print\:hidden {
                display: none !important;
            }

            .bg-white,
            .bg-gray-50,
            .bg-green-50 {
                background-color: white !important;
                border: 1px solid #ddd !important;
            }

            .shadow,
            .shadow-lg {
                shadow: none !important;
            }
        }
    </style>
@endsection
