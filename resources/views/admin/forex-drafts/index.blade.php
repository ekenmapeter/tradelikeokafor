@extends('admin.layout')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">AI Forex Drafts</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Review and manage AI-generated forex articles</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.forex-raw.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    View Pending Raw Articles
                </a>
                <a href="{{ route('admin.forex-drafts.pipeline') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Pipeline
                </a>
            </div>
        </div>

        {{-- Stats --}}
        <div class="flex flex-col md:flex-row w-full gap-3">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 text-center">
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Total</div>
            </div>
            <div
                class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4 border border-yellow-200 dark:border-yellow-800 text-center">
                <div class="text-2xl font-bold text-yellow-700 dark:text-yellow-400">{{ $stats['draft'] }}</div>
                <div class="text-xs text-yellow-600 mt-1">Pending</div>
            </div>
            <div
                class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800 text-center">
                <div class="text-2xl font-bold text-blue-700 dark:text-blue-400">{{ $stats['approved'] }}</div>
                <div class="text-xs text-blue-600 mt-1">Approved</div>
            </div>
            <div
                class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800 text-center">
                <div class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $stats['published'] }}</div>
                <div class="text-xs text-green-600 mt-1">Published</div>
            </div>
            <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border border-red-200 dark:border-red-800 text-center">
                <div class="text-2xl font-bold text-red-700 dark:text-red-400">{{ $stats['rejected'] }}</div>
                <div class="text-xs text-red-600 mt-1">Rejected</div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex flex-wrap gap-2 border-b border-gray-200 dark:border-gray-700 pb-3">
            @foreach (['all' => 'All', 'draft' => 'Pending', 'approved' => 'Approved', 'published' => 'Published', 'rejected' => 'Rejected'] as $key => $label)
                <a href="{{ route('admin.forex-drafts.index', ['status' => $key]) }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status === $key ? 'bg-green-600 text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Bulk Actions --}}
        <form id="bulkForm" action="{{ route('admin.forex-drafts.bulk-approve') }}" method="POST">
            @csrf
            @if ($stats['draft'] > 0 && $status === 'draft')
                <div class="flex items-center gap-3 mb-4">
                    <label class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <input type="checkbox" id="selectAll"
                            class="mr-2 rounded border-gray-300 text-green-600 focus:ring-green-500"> Select All
                    </label>
                    <button type="submit" id="bulkApproveBtn" style="display:none"
                        class="items-center px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-medium hover:bg-green-700"
                        onclick="return confirm('Approve all selected?')">
                        ✓ Bulk Approve
                    </button>
                </div>
            @endif

            <div class="space-y-3">
                @forelse($drafts as $draft)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            @if ($draft->status === 'draft')
                                <input type="checkbox" name="draft_ids[]" value="{{ $draft->id }}"
                                    class="draft-checkbox mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500">
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span
                                        class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $draft->status_badge }}">{{ ucfirst($draft->status) }}</span>
                                    @if ($draft->rawArticle)
                                        <span class="text-xs text-gray-400">from
                                            {{ $draft->rawArticle->source_name }}</span>
                                    @endif
                                    <span class="text-xs text-gray-400">{{ $draft->created_at->diffForHumans() }}</span>
                                </div>
                                <a href="{{ route('admin.forex-drafts.show', $draft) }}"
                                    class="text-lg font-semibold text-gray-900 dark:text-white hover:text-green-600 transition line-clamp-1">{{ $draft->ai_title }}</a>
                                <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                                    {{ $draft->ai_excerpt ?: Str::limit(strip_tags($draft->ai_content), 150) }}</p>
                                @if ($draft->parsed_tags)
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach (array_slice($draft->parsed_tags, 0, 4) as $tag)
                                            <span
                                                class="px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded text-xs">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                @if ($draft->status === 'rejected' && $draft->reject_reason)
                                    <div
                                        class="mt-2 px-3 py-2 bg-red-50 dark:bg-red-900/20 rounded-lg text-xs text-red-600">
                                        <strong>Reason:</strong> {{ $draft->reject_reason }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('admin.forex-drafts.show', $draft) }}"
                                    class="p-2 text-gray-400 hover:text-blue-600 transition" title="Preview">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @if ($draft->status === 'draft')
                                    <a href="{{ route('admin.forex-drafts.edit', $draft) }}"
                                        class="p-2 text-gray-400 hover:text-yellow-600 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.forex-drafts.approve', $draft) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit" class="p-2 text-gray-400 hover:text-green-600 transition"
                                            title="Approve" onclick="return confirm('Approve and publish?')">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="text-center py-16 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-500">No drafts found</h3>
                        <p class="text-sm text-gray-400 mt-1">Go to <a href="{{ route('admin.forex-drafts.pipeline') }}"
                                class="text-green-600 hover:underline">Pipeline</a> to generate new drafts.</p>
                    </div>
                @endforelse
            </div>
        </form>

        <div class="mt-4">{{ $drafts->links() }}</div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sa = document.getElementById('selectAll');
            const btn = document.getElementById('bulkApproveBtn');
            const cbs = document.querySelectorAll('.draft-checkbox');
            if (sa) sa.addEventListener('change', function() {
                cbs.forEach(c => c.checked = this.checked);
                toggle();
            });
            cbs.forEach(c => c.addEventListener('change', toggle));

            function toggle() {
                if (btn) btn.style.display = document.querySelectorAll('.draft-checkbox:checked').length > 0 ?
                    'inline-flex' : 'none';
            }
        });
    </script>
@endsection
