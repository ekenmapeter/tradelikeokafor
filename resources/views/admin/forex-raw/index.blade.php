@extends('admin.layout')

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Pending Forex Feeds</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Review raw articles from your RSS sources before
                    generation or direct publishing</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.forex-drafts.pipeline') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    AI Pipeline
                </a>
                <a href="{{ route('admin.forex-drafts.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50 transition shadow-sm">
                    Back to Drafts
                </a>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm transition-all duration-200 hover:shadow">
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</div>
                <div class="text-xs text-gray-500 mt-1">Total Pulled Articles</div>
            </div>
            <div
                class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 border border-blue-200 dark:border-blue-800 shadow-sm transition-all duration-200 hover:shadow">
                <div class="text-2xl font-bold text-blue-700 dark:text-blue-400">{{ $stats['pending'] }}</div>
                <div class="text-xs text-blue-600 dark:text-blue-400 mt-1">Pending Processing</div>
            </div>
            <div
                class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-800 shadow-sm transition-all duration-200 hover:shadow">
                <div class="text-2xl font-bold text-green-700 dark:text-green-400">{{ $stats['used'] }}</div>
                <div class="text-xs text-green-600 dark:text-green-400 mt-1">Published/Converted</div>
            </div>
            <div
                class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800 shadow-sm transition-all duration-200 hover:shadow">
                <div class="text-2xl font-bold text-purple-700 dark:text-purple-400">{{ $stats['today'] }}</div>
                <div class="text-xs text-purple-600 dark:text-purple-400 mt-1">Fetched Today</div>
            </div>
        </div>

        {{-- Articles List --}}
        <div
            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400 border-b dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4">Article Details</th>
                            <th class="px-6 py-4">Source</th>
                            <th class="px-6 py-4">Relevance</th>
                            <th class="px-6 py-4">Fetched Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($articles as $article)
                            <tr class="hover:bg-gray-50  transition-colors ">
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white ">
                                    <a href="{{ route('admin.forex-raw.preview', $article) }}"
                                        class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors line-clamp-2 leading-relaxed"
                                        title="{{ $article->raw_title }}">
                                        {{ $article->raw_title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-gray-750 ">
                                        {{ $article->source_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-1.5">
                                        <span
                                            class="text-xs font-bold {{ $article->relevance_score >= 80 ? 'text-green-600 dark:text-green-400' : ($article->relevance_score >= 50 ? 'text-yellow-600 dark:text-yellow-450' : 'text-gray-500') }}">
                                            {{ $article->relevance_score ?? 'N/A' }}%
                                        </span>
                                        <div class="w-12 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                                            <div class="h-1.5 rounded-full {{ $article->relevance_score >= 80 ? 'bg-green-500' : ($article->relevance_score >= 50 ? 'bg-yellow-500' : 'bg-gray-400') }}"
                                                style="width: {{ $article->relevance_score ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400">
                                    {{ $article->published_at?->diffForHumans() ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                                    <a href="{{ route('admin.forex-raw.preview', $article) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg text-xs font-semibold hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Preview
                                    </a>
                                    <form action="{{ route('admin.forex-raw.rewrite', $article) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                            AI Rewrite
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.forex-raw.publish', $article) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition"
                                            onclick="return confirm('Publish this article raw without rewriting?')">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                            Publish As-Is
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 text-gray-500 dark:text-gray-400">
                                    <svg class="w-12 h-12 mx-auto text-gray-350 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    <h4 class="text-base font-semibold">No pending articles found</h4>
                                    <p class="text-xs text-gray-400 mt-1 mt-1">Check the <a
                                            href="{{ route('admin.forex-drafts.pipeline') }}"
                                            class="text-indigo-650 dark:text-indigo-400 hover:underline">Pipeline</a> to
                                        fetch new feeds.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $articles->links() }}
        </div>
    </div>

    {{-- Toast Notification System --}}
    <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-3 max-w-sm w-full pointer-events-none"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toastContainer = document.getElementById('toast-container');

            function showToast(message, type = 'success', link = null, linkText = 'View') {
                const toast = document.createElement('div');
                toast.className = `p-4 rounded-xl shadow-lg border text-sm transition-all duration-300 transform translate-y-5 opacity-0 flex flex-col gap-2 pointer-events-auto backdrop-blur-md ` +
                    (type === 'success' 
                        ? 'bg-green-600 text-white border-green-500' 
                        : (type === 'error' 
                            ? 'bg-red-600 text-white border-red-500' 
                            : 'bg-indigo-600 text-white border-indigo-500'));

                let content = `<div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        ${type === 'loading' ? '<svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>' : ''}
                        <span class="font-medium">${message}</span>
                    </div>
                    <button class="text-white/70 hover:text-white text-base font-bold focus:outline-none close-toast">&times;</button>
                </div>`;

                if (link) {
                    content += `<div class="flex justify-end">
                        <a href="${link}" class="px-3 py-1 bg-white/20 hover:bg-white/30 text-white rounded-lg text-xs font-bold transition inline-flex items-center gap-1">
                            ${linkText}
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>`;
                }

                toast.innerHTML = content;
                toastContainer.appendChild(toast);

                // Animation entry
                setTimeout(() => {
                    toast.classList.remove('translate-y-5', 'opacity-0');
                }, 10);

                // Auto dismiss (if not loading)
                let autoDismiss;
                if (type !== 'loading') {
                    autoDismiss = setTimeout(() => {
                        dismissToast(toast);
                    }, 8000);
                }

                toast.querySelector('.close-toast').addEventListener('click', () => {
                    if (autoDismiss) clearTimeout(autoDismiss);
                    dismissToast(toast);
                });

                return toast;
            }

            function dismissToast(toast) {
                toast.classList.add('translate-y-5', 'opacity-0');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }

            // Bind single rewrite forms
            document.querySelectorAll('form[action*="/forex-raw/"][action$="/rewrite"]').forEach(form => {
                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    
                    const button = form.querySelector('button[type="submit"]');
                    const originalHtml = button.innerHTML;
                    
                    // Set loading button state
                    button.disabled = true;
                    button.innerHTML = `<svg class="animate-spin h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating...`;
                    button.classList.add('opacity-75');

                    // Show active background toast
                    const linkEl = form.closest('tr').querySelector('a[title]');
                    const articleTitle = linkEl ? linkEl.getAttribute('title') : 'Article';
                    const loadingToast = showToast(`AI rewrite started in background for "${articleTitle.substring(0, 30)}..."`, 'loading');

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json'
                            }
                        });

                        const result = await response.json();
                        dismissToast(loadingToast);

                        if (response.ok && result.success) {
                            showToast(`Success! "${articleTitle.substring(0, 30)}..." rewritten.`, 'success', result.redirect_url, 'Review Draft');
                            
                            // Visual indication of row completion
                            const row = form.closest('tr');
                            row.classList.add('bg-green-500/10', 'transition-all', 'duration-500');
                            button.innerHTML = `<svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Rewritten`;
                            button.classList.remove('bg-indigo-600', 'hover:bg-indigo-700');
                            button.classList.add('bg-green-600');
                            
                            // Remove row after delay
                            setTimeout(() => {
                                row.style.transition = 'all 0.5s ease';
                                row.style.height = '0';
                                row.style.opacity = '0';
                                row.style.padding = '0';
                                setTimeout(() => {
                                    row.remove();
                                    if (document.querySelectorAll('tbody tr').length === 0) {
                                        window.location.reload();
                                    }
                                }, 500);
                            }, 3000);
                        } else {
                            showToast(result.message || 'AI rewrite generation failed. Check connection.', 'error');
                            button.disabled = false;
                            button.innerHTML = originalHtml;
                            button.classList.remove('opacity-75');
                        }
                    } catch (error) {
                        dismissToast(loadingToast);
                        showToast('Network error: Unable to connect to rewriter service.', 'error');
                        button.disabled = false;
                        button.innerHTML = originalHtml;
                        button.classList.remove('opacity-75');
                    }
                });
            });
        });
    </script>
@endsection
