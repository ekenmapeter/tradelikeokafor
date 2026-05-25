@extends('admin.layout')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.forex-drafts.show', $draft) }}" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 transition">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white line-clamp-1">Edit Draft: {{ $draft->ai_title }}</h1>
        </div>
    </div>

    <form action="{{ route('admin.forex-drafts.update', $draft) }}" method="POST" class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 space-y-6">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Headline (SEO Title)</label>
            <input type="text" name="ai_title" value="{{ old('ai_title', $draft->ai_title) }}" required
                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500">
            @error('ai_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Excerpt & Meta --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Excerpt (Short Description)</label>
                <textarea name="ai_excerpt" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500">{{ old('ai_excerpt', $draft->ai_excerpt) }}</textarea>
                @error('ai_excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Description</label>
                <textarea name="ai_meta_description" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500">{{ old('ai_meta_description', $draft->ai_meta_description) }}</textarea>
                @error('ai_meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Content (using CKEditor if available) --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Article Content</label>
            <div class="prose max-w-none">
                <textarea id="ai_content" name="ai_content" rows="15" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500 font-mono text-sm">{{ old('ai_content', $draft->ai_content) }}</textarea>
            </div>
            @error('ai_content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            <p class="text-xs text-gray-500 mt-2">Supports HTML. Make sure to use proper &lt;p&gt; and &lt;h3&gt; tags.</p>
        </div>

        {{-- Tags & CTA --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags (Comma separated)</label>
                <input type="text" name="ai_tags" value="{{ old('ai_tags', is_array($draft->ai_tags) ? implode(', ', $draft->ai_tags) : '') }}"
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500" placeholder="e.g. EUR/USD, Fed, Technical Analysis">
                @error('ai_tags') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lead CTA text (Appended to post)</label>
                <input type="text" name="lead_cta" value="{{ old('lead_cta', $draft->lead_cta) }}"
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-green-500 focus:border-green-500">
                @error('lead_cta') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="pt-4 flex justify-end gap-4 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.forex-drafts.show', $draft) }}" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition shadow-sm">Save Changes</button>
        </div>
    </form>
</div>

<!-- Load CKEditor if we want rich text editing here. We can reuse the one from the blog create page -->
<script src="https://cdn.ckeditor.com/ckeditor5/38.1.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#ai_content'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo']
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
