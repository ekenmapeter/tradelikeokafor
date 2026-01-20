@extends('admin.layout')

@section('content')
<div class="container mx-auto max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">General Settings</h1>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 md:p-8">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Branding</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_logo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Site Logo</label>
                        <input type="file" name="site_logo" id="site_logo" accept="image/*" class="w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-green-50 file:text-green-700
                            hover:file:bg-green-100
                        ">
                        <p class="mt-1 text-xs text-gray-500">Recommended: PNG or JPG, max 2MB.</p>
                    </div>
                    @if(isset($settings['site_logo']))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Logo</label>
                        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg border border-gray-200 dark:border-gray-600 inline-block">
                            <img src="{{ Storage::url($settings['site_logo']) }}" alt="Site Logo" class="h-12 w-auto object-contain">
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Contact Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="support_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Support Email</label>
                        <input type="email" name="support_email" id="support_email" value="{{ $settings['support_email'] ?? 'support@tradelikeokafor.com' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="support_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Support Phone</label>
                        <input type="text" name="support_phone" id="support_phone" value="{{ $settings['support_phone'] ?? '+2348157841450' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div class="md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Office Address</label>
                        <textarea name="address" id="address" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">{{ $settings['address'] ?? "Block 1 plot 8 Memunat ayodeji crescent,\nEtal Ave, Ikeja Lagos NG, Oregun, Ikeja 100271, Lagos, Nigeria." }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Social Media Links</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="telegram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telegram Channel URL</label>
                        <input type="url" name="telegram_url" id="telegram_url" value="{{ $settings['telegram_url'] ?? '#' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="instagram_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Instagram URL</label>
                        <input type="url" name="instagram_url" id="instagram_url" value="{{ $settings['instagram_url'] ?? '#' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="youtube_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">YouTube Channel URL</label>
                        <input type="url" name="youtube_url" id="youtube_url" value="{{ $settings['youtube_url'] ?? '#' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                         <label for="tradingview_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">TradingView URL</label>
                        <input type="url" name="tradingview_url" id="tradingview_url" value="{{ $settings['tradingview_url'] ?? '#' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>
            </div>

            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-100 dark:border-gray-700 pb-2">Manual Payment Details (Bank Transfer)</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="bank_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" id="bank_name" value="{{ $settings['bank_name'] ?? '' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="account_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Name</label>
                        <input type="text" name="account_name" id="account_name" value="{{ $settings['account_name'] ?? '' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div class="md:col-span-2">
                        <label for="account_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Account Number</label>
                        <input type="text" name="account_number" id="account_number" value="{{ $settings['account_number'] ?? '' }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-sm transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
