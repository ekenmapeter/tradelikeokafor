@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Assign Subscription</h1>
        <p class="text-gray-600 dark:text-gray-400">Manually assign a subscription plan to a user. This will create a completed transaction record.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 gap-6">
                <!-- User Selection -->
                <div>
                     <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select User</label>
                    <select name="user_id" id="user_id" required 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Select a User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                     @error('user_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Plan Selection -->
                <div>
                     <label for="subscription_plan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Plan</label>
                    <select name="subscription_plan_id" id="subscription_plan_id" required 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="">-- Select a Plan --</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('subscription_plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - ${{ $plan->price }} ({{ $plan->duration_days }} days)
                            </option>
                        @endforeach
                    </select>
                     @error('subscription_plan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Date -->
                <div>
                     <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     @error('start_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">End date will be automatically calculated based on the plan duration.</p>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.subscriptions.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-3 hover:bg-gray-300">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Assign Subscription</button>
            </div>
        </form>
    </div>
</div>
@endsection
