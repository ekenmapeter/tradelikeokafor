@extends('admin.layout')

@section('content')
    <div class="container mx-auto max-w-2xl">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Assign Subscription</h1>
            <p class="text-gray-600 dark:text-gray-400">Manually assign a subscription plan to a user. This will create a
                completed transaction record.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <form action="{{ route('admin.subscriptions.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6">
                    <!-- User Selection -->
                    <div x-data="{ 
                        open: false, 
                        search: '', 
                        users: {{ $users->map(fn($u) => ['id' => $u->id, 'name' => $u->name, 'email' => $u->email])->toJson() }},
                        selectedId: '{{ old('user_id') }}',
                        selectedName: '{{ old('user_id') ? ($users->find(old('user_id'))->name ?? '') : '' }}',
                        get filteredUsers() {
                            if (!this.search) return this.users;
                            return this.users.filter(u => 
                                u.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                u.email.toLowerCase().includes(this.search.toLowerCase())
                            );
                        },
                        selectUser(user) {
                            this.selectedId = user.id;
                            this.selectedName = user.name;
                            this.open = false;
                            this.search = '';
                        }
                    }" class="relative">
                        <label for="user_search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select
                            User</label>
                        <input type="hidden" name="user_id" :value="selectedId">

                        <div class="relative mt-1">
                            <button type="button" @click="open = !open"
                                class="relative w-full bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <span class="block truncate" x-text="selectedName || '-- Select a User --'"></span>
                                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute z-10 mt-1 w-full bg-white dark:bg-gray-800 shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                                <div class="sticky top-0 z-10 bg-white dark:bg-gray-800 px-2 py-1">
                                    <input type="text" x-model="search" placeholder="Search by name or email..."
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                                <ul class="mt-1">
                                    <template x-for="user in filteredUsers" :key="user.id">
                                        <li @click="selectUser(user)"
                                            class="text-gray-900 dark:text-gray-200 cursor-default select-none relative py-2 pl-3 pr-9 hover:bg-indigo-600 hover:text-white">
                                            <div class="flex items-center">
                                                <span x-text="user.name" class="font-normal block truncate"></span>
                                                <span x-text="'(' + user.email + ')'"
                                                    class="ml-2 text-xs text-gray-500 group-hover:text-indigo-200 truncate"></span>
                                            </div>
                                        </li>
                                    </template>
                                    <li x-show="filteredUsers.length === 0"
                                        class="text-gray-500 dark:text-gray-400 py-2 pl-3">
                                        No users found.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @error('user_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Plan Selection -->
                    <div>
                        <label for="subscription_plan_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Plan</label>
                        <select name="subscription_plan_id" id="subscription_plan_id" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Select a Plan --</option>
                            @foreach($plans as $plan)
                                <option value="{{ $plan->id }}" {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} - ${{ $plan->price }} (Lifetime)
                                </option>
                            @endforeach
                        </select>
                        @error('subscription_plan_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start
                            Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Subscription will have no expiration date (Lifetime Access).
                        </p>
                    </div>

                    <!-- Payment Proof -->
                    <div>
                        <label for="payment_proof"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Proof (Receipt
                            Image)</label>
                        <input type="file" name="payment_proof" id="payment_proof" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100
                            dark:file:bg-gray-700 dark:file:text-gray-200">
                        @error('payment_proof')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Upload an image of the payment receipt. Max 2MB.</p>
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <a href="{{ route('admin.subscriptions.index') }}"
                        class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-3 hover:bg-gray-300">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Assign
                        Subscription</button>
                </div>
            </form>
        </div>
    </div>
@endsection