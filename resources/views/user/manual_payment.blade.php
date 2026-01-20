@extends('user.layout')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6 flex items-center">
        <a href="{{ route('user.subscriptions') }}" class="mr-4 text-blue-600 hover:text-blue-800 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Manual Payment Proof</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border border-gray-200 dark:border-gray-700">
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Plan: {{ $plan->name }}</h2>
            <div class="flex items-center justify-between p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg mb-6">
                <span class="text-blue-900 dark:text-blue-200">Total to pay:</span>
                <span class="text-2xl font-bold text-blue-900 dark:text-blue-200">${{ number_format($plan->price, 2) }}</span>
            </div>

            <div class="mb-8">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Bank Account Details</h3>
                <div class="space-y-4">
                    @php
                        $bankName = $settings['bank_name'] ?? 'N/A';
                        $accountName = $settings['account_name'] ?? 'N/A';
                        $accountNumber = $settings['account_number'] ?? 'N/A';
                    @endphp

                    <div class="p-4 bg-gray-50 dark:bg-gray-750 rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Bank Name:</span>
                            <div class="flex items-center">
                                <span class="font-medium text-gray-900 dark:text-white mr-2" id="bank_name">{{ $bankName }}</span>
                                <button onclick="copyToClipboard('bank_name')" class="text-blue-600 hover:text-blue-800 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-2">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Account Name:</span>
                            <div class="flex items-center">
                                <span class="font-medium text-gray-900 dark:text-white mr-2" id="account_name">{{ $accountName }}</span>
                                <button onclick="copyToClipboard('account_name')" class="text-blue-600 hover:text-blue-800 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Account Number:</span>
                            <div class="flex items-center">
                                <span class="font-medium text-gray-900 dark:text-white text-lg mr-2" id="account_number">{{ $accountNumber }}</span>
                                <button onclick="copyToClipboard('account_number')" class="text-blue-600 hover:text-blue-800 p-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('user.subscriptions.submit-manual-payment', $plan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Payment Proof (Receipt/Screenshot)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-blue-400 transition-colors cursor-pointer" id="drop-zone">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="proof" class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Upload a file</span>
                                    <input id="proof" name="proof" type="file" class="sr-only" required accept="image/*" onchange="previewFile()">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </div>
                    @error('proof')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <div id="file-preview-container" class="hidden mt-4">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview:</p>
                        <img id="file-preview" class="max-h-64 rounded-lg mx-auto" src="#" alt="Proof Preview">
                    </div>
                </div>

                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    Submit Payment Proof
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert('Copied to clipboard: ' + text);
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }

    function previewFile() {
        const preview = document.getElementById('file-preview');
        const container = document.getElementById('file-preview-container');
        const file = document.getElementById('proof').files[0];
        const reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
            container.classList.remove('hidden');
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
            container.classList.add('hidden');
        }
    }

    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('proof');

    dropZone.onclick = () => fileInput.click();

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/10');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/10');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50', 'dark:bg-blue-900/10');
        
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            previewFile();
        }
    });
</script>
@endsection
