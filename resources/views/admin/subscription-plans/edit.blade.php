@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-2xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Subscription Plan</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <form action="{{ route('admin.subscription-plans.update', $subscriptionPlan) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Plan Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $subscriptionPlan->name) }}" required 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                     <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $subscriptionPlan->description) }}</textarea>
                     @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price & Duration -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                         <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price ($)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $subscriptionPlan->price) }}" step="0.01" min="0" required 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                         @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                         <label for="duration_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration (Days)</label>
                        <input type="number" name="duration_days" id="duration_days" value="{{ old('duration_days', $subscriptionPlan->duration_days) }}" min="1" required 
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                         @error('duration_days')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Payment Link -->
                <div>
                     <label for="payment_link" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Payment Link</label>
                    <input type="url" name="payment_link" id="payment_link" value="{{ old('payment_link', $subscriptionPlan->payment_link) }}" placeholder="https://..."
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                     @error('payment_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $subscriptionPlan->is_active) ? 'checked' : '' }}
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                        Active (Visible to users)
                    </label>
                </div>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.subscription-plans.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mr-3 hover:bg-gray-300">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Plan</button>
            </div>
        </form>
    </div>
</div>
@endsection
