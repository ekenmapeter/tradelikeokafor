@extends('admin.layout')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">AI Forex Pipeline Dashboard</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monitor RSS fetching and AI generation processes</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.forex-raw.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                View Pending Raw Articles
            </a>
            <a href="{{ route('admin.forex-drafts.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
                Back to Drafts
            </a>
        </div>
    </div>

    {{-- System Status & Manual Triggers --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- RSS Pipeline --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 5c7.18 0 13 5.82 13 13M6 11a7 7 0 017 7m-6 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg>
                        RSS Feed Pipeline
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Pulls raw articles from top forex sites</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['raw_today'] }}</div>
                    <div class="text-xs text-gray-500">Fetched Today</div>
                </div>
                <a href="{{ route('admin.forex-raw.index') }}" class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg text-center hover:bg-gray-100 dark:hover:bg-gray-650 transition block">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['raw_pending'] }}</div>
                    <div class="text-xs text-blue-600 dark:text-blue-400 font-medium hover:underline">Pending AI Rewrite →</div>
                </a>
            </div>

            <form action="{{ route('admin.forex-drafts.trigger-fetch') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm" onclick="return confirm('This will manually fetch new articles from all RSS sources. Proceed?')">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Manual Fetch Now
                </button>
            </form>
        </div>

        {{-- AI Generation Pipeline --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        AI Generation Pipeline
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">Rewrites raw content using HuggingFace</p>
                </div>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
            </div>
            
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['drafts_today'] }}</div>
                    <div class="text-xs text-gray-500">Generated Today</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 p-3 rounded-lg text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['published_today'] }}</div>
                    <div class="text-xs text-gray-500">Published Today</div>
                </div>
            </div>

            <form action="{{ route('admin.forex-drafts.trigger-generate') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition shadow-sm" {{ $stats['raw_pending'] === 0 ? 'disabled' : '' }} onclick="return confirm('This will consume API tokens to generate new drafts. Proceed?')">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    Generate AI Drafts Now
                </button>
            </form>
        </div>
    </div>

    {{-- Details Section --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Source Breakdown --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Raw Article Sources</h3>
            <div class="space-y-3">
                @foreach($sourceBreakdown as $source)
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $source->source_name }}</span>
                    <span class="text-sm text-gray-500">{{ $source->count }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ min(100, ($source->count / max(1, $stats['raw_total'])) * 100) }}%"></div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- 7 Day Activity --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-5 lg:col-span-2">
            <h3 class="font-bold text-gray-900 dark:text-white mb-4">7-Day Activity</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b dark:border-gray-600">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3 text-center">RSS Fetched</th>
                            <th class="px-4 py-3 text-center">AI Generated</th>
                            <th class="px-4 py-3 text-center">Published</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyStats as $day)
                        <tr class="border-b dark:border-gray-700">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $day['date'] }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex px-2 py-1 bg-blue-50 text-blue-700 rounded-md">{{ $day['fetched'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex px-2 py-1 bg-purple-50 text-purple-700 rounded-md">{{ $day['generated'] }}</span>
                            </td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex px-2 py-1 bg-green-50 text-green-700 rounded-md">{{ $day['published'] }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
