@extends('user.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
        <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full uppercase">
            {{ Auth::user()->role }}
        </span>
    </div>

    <div class="max-w-7xl mx-auto space-y-6">
        <!-- Membership Status Card -->
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg border-l-4 border-blue-500">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Account Status</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your membership and personal details.</p>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-6">
                    <div class="text-center">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Status</p>
                        <p class="font-bold {{ Auth::user()->isActive() ? 'text-green-600' : 'text-red-600' }}">
                            {{ ucfirst(Auth::user()->status) }}
                        </p>
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Plan</p>
                        <p class="font-bold text-gray-900 dark:text-white">
                            {{ Auth::user()->activeSubscription ? Auth::user()->activeSubscription->plan->name : 'No Active Plan' }}
                        </p>
                    </div>
                    <div class="text-center border-l border-gray-200 dark:border-gray-700 pl-6">
                        <p class="text-xs text-gray-500 uppercase font-semibold">Member Since</p>
                        <p class="font-bold text-gray-900 dark:text-white">
                            {{ Auth::user()->created_at->format('M Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
