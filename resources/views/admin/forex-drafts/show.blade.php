@extends('admin.layout')

@section('content')
<div class="space-y-6">
    {{-- Back + Title --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.forex-drafts.index') }}" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 transition">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="flex-1">
            <h1 class="text-xl font-bold text-gray-900 dark:text-white line-clamp-1">{{ $draft->ai_title }}</h1>
            <div class="flex items-center gap-2 mt-1">
                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $draft->status_badge }}">{{ ucfirst($draft->status) }}</span>
                <span class="text-xs text-gray-400">Generated {{ $draft->created_at->format('M d, Y h:ia') }}</span>
                @if($draft->generation_model)
                <span class="text-xs text-gray-400">• Model: {{ $draft->generation_model }}</span>
                @endif
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    @if($draft->status === 'draft')
    <div class="flex flex-wrap gap-2">
        <form action="{{ route('admin.forex-drafts.approve', $draft) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-green-600 text-white rounded-lg text-sm font-semibold hover:bg-green-700 transition shadow-sm" onclick="return confirm('Approve and publish this draft?')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Approve & Publish
            </button>
        </form>
        <a href="{{ route('admin.forex-drafts.edit', $draft) }}" class="inline-flex items-center px-5 py-2.5 bg-yellow-500 text-white rounded-lg text-sm font-semibold hover:bg-yellow-600 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit Draft
        </a>
        <button type="button" onclick="document.getElementById('rejectModal').classList.remove('hidden')" class="inline-flex items-center px-5 py-2.5 bg-red-600 text-white rounded-lg text-sm font-semibold hover:bg-red-700 transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            Reject
        </button>
        <form action="{{ route('admin.forex-drafts.regenerate', $draft) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition shadow-sm" onclick="return confirm('Regenerate with fresh AI content?')">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Regenerate
            </button>
        </form>
    </div>
    @endif

    @if($draft->status === 'published' && $draft->post)
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span class="text-green-700 dark:text-green-400 font-semibold">Published</span>
            <a href="{{ route('blog.show', $draft->post->slug) }}" target="_blank" class="text-green-600 hover:underline text-sm ml-2">View on blog →</a>
        </div>
    </div>
    @endif

    {{-- Side by Side: Source vs AI --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- LEFT: Original Source --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-5 py-3 bg-gray-50 dark:bg-gray-750 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Original Source</h2>
            </div>
            <div class="p-5 space-y-4">
                @if($draft->rawArticle)
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Source</span>
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $draft->rawArticle->source_name }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Original URL</span>
                    <a href="{{ $draft->rawArticle->source_url }}" target="_blank" class="text-sm text-blue-600 hover:underline break-all block">{{ Str::limit($draft->rawArticle->source_url, 60) }}</a>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Original Title</span>
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $draft->rawArticle->raw_title }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Published</span>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $draft->rawArticle->published_at?->format('M d, Y h:ia') ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Raw Content</span>
                    <div class="mt-1 p-3 bg-gray-50 dark:bg-gray-900 rounded-lg text-sm text-gray-600 dark:text-gray-400 max-h-96 overflow-y-auto leading-relaxed whitespace-pre-wrap">{{ $draft->rawArticle->raw_content }}</div>
                </div>
                @else
                <p class="text-gray-400 italic">Source article no longer available.</p>
                @endif
            </div>
        </div>

        {{-- RIGHT: AI Rewrite --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-green-200 dark:border-green-800 overflow-hidden">
            <div class="px-5 py-3 bg-green-50 dark:bg-green-900/30 border-b border-green-200 dark:border-green-800">
                <h2 class="text-sm font-bold text-green-700 dark:text-green-400 uppercase tracking-wider">AI Rewrite</h2>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Title</span>
                    <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $draft->ai_title }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Excerpt</span>
                    <p class="text-sm text-gray-600 dark:text-gray-400 italic">{{ $draft->ai_excerpt }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Meta Description</span>
                    <p class="text-sm text-gray-500">{{ $draft->ai_meta_description }}</p>
                </div>
                @if($draft->parsed_tags)
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Tags</span>
                    <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($draft->parsed_tags as $tag)
                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">Article Content</span>
                    <div class="mt-1 prose prose-sm dark:prose-invert max-w-none max-h-96 overflow-y-auto p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">{!! $draft->ai_content !!}</div>
                </div>

                {{-- CTA Preview --}}
                @if($draft->lead_cta)
                <div>
                    <span class="text-xs text-gray-400 uppercase tracking-wider">CTA Block Preview</span>
                    <div class="mt-1 p-4 rounded-xl text-white text-center font-semibold" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                        {{ $draft->lead_cta }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 w-full max-w-md mx-4 shadow-2xl">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Reject Draft</h3>
        <form action="{{ route('admin.forex-drafts.reject', $draft) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Reason (optional)</label>
                <textarea name="reject_reason" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-red-500 focus:border-red-500" placeholder="Why is this draft not suitable?"></textarea>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Reject Draft</button>
            </div>
        </form>
    </div>
</div>
@endsection
