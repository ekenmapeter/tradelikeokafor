@extends('admin.layout')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.profit-records.index') }}" class="text-emerald-600 hover:text-emerald-700 flex items-center gap-1 font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back to Records
    </a>
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white mt-2">Record New Profit</h2>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-4xl">
    <form action="{{ route('admin.profit-records.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            {{-- Student Selection --}}
            <div>
                <label for="student_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Registered Student (Optional)</label>
                <select name="student_id" id="student_id" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="">-- Select Student --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('student_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Leave blank if the student is not registered on the platform.</p>
            </div>

            {{-- Manual Student Name --}}
            <div>
                <label for="student_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Student Name (if not registered)</label>
                <input type="text" name="student_name" id="student_name" value="{{ old('student_name') }}" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500" placeholder="Enter name manually">
                @error('student_name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            {{-- Currency --}}
            <div>
                <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                <select name="currency" id="currency" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                    <option value="NGN" {{ old('currency', 'NGN') == 'NGN' ? 'selected' : '' }}>NGN (₦)</option>
                </select>
            </div>

            {{-- Profit Amount --}}
            <div>
                <label for="profit_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Student's Total Profit</label>
                <div class="relative">
                    <input type="number" step="0.01" name="profit_amount" id="profit_amount" value="{{ old('profit_amount') }}" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 pl-10" placeholder="0.00">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                </div>
                @error('profit_amount')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Commission Received --}}
            <div>
                <label for="commission_received" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Commission Received</label>
                <div class="relative">
                    <input type="number" step="0.01" name="commission_received" id="commission_received" value="{{ old('commission_received') }}" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500 pl-10" placeholder="0.00">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                </div>
                @error('commission_received')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Reason --}}
        <div class="mb-6">
            <label for="reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason for Profit / Description</label>
            <textarea name="reason" id="reason" rows="4" required class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:border-emerald-500 focus:ring-emerald-500" placeholder="Explain the service provided or why this profit was earned...">{{ old('reason') }}</textarea>
            @error('reason')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Screenshots --}}
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Evidence Screenshots (Multiple Allowed)</label>
            <div onclick="document.getElementById('screenshots').click()" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-700 border-dashed rounded-md hover:border-emerald-500 transition-colors cursor-pointer group">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 group-hover:text-emerald-500 transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                        <span class="relative font-medium text-emerald-600 hover:text-emerald-500">
                            Upload files
                        </span>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">
                        PNG, JPG, GIF up to 5MB each. Select as many as you need.
                    </p>
                    <input id="screenshots" name="screenshots[]" type="file" class="hidden" multiple required>
                </div>
            </div>
            <div id="file-list" class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Preview will be inserted here by JS --}}
            </div>
            @error('screenshots')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
            @foreach($errors->get('screenshots.*') as $message)
                <p class="mt-1 text-xs text-red-500">{{ $message[0] }}</p>
            @endforeach
        </div>

        <div class="flex justify-end gap-4">
            <button type="reset" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                Reset Form
            </button>
            <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                Save Record & Evidence
            </button>
        </div>
    </form>
</div>

<script>
    const uploadZone = document.querySelector('.border-dashed');
    const fileInput = document.getElementById('screenshots');

    // Handle clicks to trigger input
    // (Already handled by onclick in HTML, but good to keep JS organized)

    // Handle drag and drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        uploadZone.addEventListener(eventName, () => {
            uploadZone.classList.add('border-emerald-500', 'bg-emerald-50', 'dark:bg-emerald-900/20');
        }, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        uploadZone.addEventListener(eventName, () => {
            uploadZone.classList.remove('border-emerald-500', 'bg-emerald-50', 'dark:bg-emerald-900/20');
        }, false);
    });

    uploadZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        // Trigger the change event manually to run the preview logic
        fileInput.dispatchEvent(new Event('change'));
    }

    fileInput.addEventListener('change', function(e) {
        const fileList = document.getElementById('file-list');
        fileList.innerHTML = '';
        
        if (this.files.length > 0) {
            for (const file of this.files) {
                const reader = new FileReader();
                const div = document.createElement('div');
                div.className = 'relative group';
                
                reader.onload = function(event) {
                    div.innerHTML = `
                        <img src="${event.target.result}" class="h-24 w-full object-cover rounded-lg border dark:border-gray-700">
                        <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg">
                            <span class="text-white text-[10px] font-bold truncate px-2">${file.name}</span>
                        </div>
                    `;
                };
                
                reader.readAsDataURL(file);
                fileList.appendChild(div);
            }
        }
    });

    // Simple currency symbol switcher
    document.getElementById('currency').addEventListener('change', function() {
        const symbol = this.value === 'USD' ? '$' : '₦';
        document.querySelectorAll('.absolute.inset-y-0.left-0 span').forEach(el => {
            el.textContent = symbol;
        });
    });
</script>
@endsection
