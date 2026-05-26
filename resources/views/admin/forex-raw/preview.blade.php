@extends('admin.layout')

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-green-600 dark:text-green-400 uppercase tracking-wider mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                Raw RSS Feed Source
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Raw Article Preview</h1>
        </div>
        <div>
            <a href="{{ route('admin.forex-raw.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-750 transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Feed List
            </a>
        </div>
    </div>

    {{-- Main Preview Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
        {{-- Metadata Bar --}}
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 leading-relaxed">{{ $article->raw_title }}</h2>
            
            <div class="flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-medium text-gray-400 dark:text-gray-500">Source:</span>
                    <span class="px-2.5 py-0.5 rounded-md bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs font-semibold">
                        {{ $article->source_name }}
                    </span>
                </div>
                <div class="h-4 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Published: {{ $article->published_at?->format('M d, Y H:i') ?? 'N/A' }}</span>
                </div>
                @if($article->relevance_score)
                    <div class="h-4 w-px bg-gray-200 dark:bg-gray-700 hidden sm:block"></div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-medium text-gray-400 dark:text-gray-500">Relevance:</span>
                        <span class="text-xs font-bold {{ $article->relevance_score >= 80 ? 'text-green-600 dark:text-green-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                            {{ $article->relevance_score }}%
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- Raw Content formatted as Blog --}}
        <div class="p-6 sm:p-8 border-b border-gray-150 dark:border-gray-700 bg-white dark:bg-gray-800">
            <div class="prose dark:prose-invert max-w-none space-y-4 leading-relaxed">
                @php
                    $paragraphs = explode("\n", $article->raw_content);
                    foreach ($paragraphs as $para) {
                        $para = trim($para);
                        if (empty($para)) continue;

                        if (strlen($para) < 90 && !str_ends_with($para, '.') && !str_ends_with($para, '?') && !str_ends_with($para, '!')) {
                            echo '<h3 class="text-xl font-bold text-gray-900 dark:text-white mt-6 mb-2 tracking-tight">' . e($para) . '</h3>';
                        } else {
                            echo '<p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed text-base">' . e($para) . '</p>';
                        }
                    }
                @endphp
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/30 flex flex-wrap gap-3 sm:justify-end">
            <a href="{{ route('admin.forex-drafts.pipeline') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-750 dark:text-gray-200 rounded-xl text-sm font-semibold transition">
                Go to Pipeline Dashboard
            </a>
            
            <form action="{{ route('admin.forex-raw.rewrite', $article) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    AI Rewrite (Generate Draft)
                </button>
            </form>
            
            <form action="{{ route('admin.forex-raw.publish', $article) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-xl text-sm font-semibold transition shadow-sm" onclick="return confirm('Are you sure you want to publish this article directly as-is without any AI rewrites?')">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    Publish As-Is (No Rewrite)
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
