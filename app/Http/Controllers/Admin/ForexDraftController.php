<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ForexBlogDraft;
use App\Models\ForexRawArticle;
use App\Models\Post;
use App\Services\ForexRssFetcherService;
use App\Services\HuggingFaceRewriterService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForexDraftController extends Controller
{
    /**
     * List all forex drafts with status filters.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = ForexBlogDraft::with(['rawArticle', 'moderator'])
            ->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $drafts = $query->paginate(15)->appends(['status' => $status]);

        // Stats
        $stats = [
            'total' => ForexBlogDraft::count(),
            'draft' => ForexBlogDraft::drafts()->count(),
            'approved' => ForexBlogDraft::approved()->count(),
            'rejected' => ForexBlogDraft::rejected()->count(),
            'published' => ForexBlogDraft::published()->count(),
            'today' => ForexBlogDraft::whereDate('created_at', today())->count(),
        ];

        return view('admin.forex-drafts.index', compact('drafts', 'status', 'stats'));
    }

    /**
     * Show a single draft with side-by-side comparison.
     */
    public function show(ForexBlogDraft $draft)
    {
        $draft->load(['rawArticle', 'post']);
        return view('admin.forex-drafts.show', compact('draft'));
    }

    /**
     * Edit a draft before approval.
     */
    public function edit(ForexBlogDraft $draft)
    {
        $draft->load('rawArticle');
        return view('admin.forex-drafts.edit', compact('draft'));
    }

    /**
     * Update draft content.
     */
    public function update(Request $request, ForexBlogDraft $draft)
    {
        $request->validate([
            'ai_title' => 'required|string|max:255',
            'ai_content' => 'required|string|min:100',
            'ai_excerpt' => 'nullable|string|max:500',
            'ai_meta_description' => 'nullable|string|max:255',
            'lead_cta' => 'nullable|string|max:500',
            'ai_tags' => 'nullable|string',
        ]);

        $tags = [];
        if ($request->filled('ai_tags')) {
            $tags = array_map('trim', explode(',', $request->ai_tags));
            $tags = array_filter($tags);
        }

        $draft->update([
            'ai_title' => $request->ai_title,
            'ai_content' => $request->ai_content,
            'ai_excerpt' => $request->ai_excerpt,
            'ai_meta_description' => $request->ai_meta_description,
            'lead_cta' => $request->lead_cta,
            'ai_tags' => $tags,
        ]);

        return redirect()->route('admin.forex-drafts.show', $draft)
            ->with('success', 'Draft updated successfully.');
    }

    /**
     * Approve a draft and publish it as a blog post.
     */
    public function approve(ForexBlogDraft $draft)
    {
        if ($draft->status === 'published') {
            return back()->with('error', 'This draft is already published.');
        }

        // Append CTA to content if present
        $content = $draft->ai_content;
        if (!empty($draft->lead_cta)) {
            $content .= "\n\n<div class=\"forex-cta-block\" style=\"background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; padding: 24px; border-radius: 12px; margin-top: 32px; text-align: center;\">"
                . "<p style=\"font-size: 1.1rem; font-weight: 600; margin: 0;\">" . e($draft->lead_cta) . "</p>"
                . "</div>";
        }

        // Create the blog post
        $slug = Str::slug($draft->ai_title);
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $post = Post::create([
            'title' => $draft->ai_title,
            'slug' => $slug,
            'content' => $content,
            'short_description' => $draft->ai_excerpt,
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Update the draft
        $draft->update([
            'status' => 'published',
            'moderator_id' => auth()->id(),
            'reviewed_at' => now(),
            'published_at' => now(),
            'post_id' => $post->id,
        ]);

        return redirect()->route('admin.forex-drafts.index', ['status' => 'draft'])
            ->with('success', "Published: \"{$draft->ai_title}\" is now live on the blog.");
    }

    /**
     * Reject a draft with reason.
     */
    public function reject(Request $request, ForexBlogDraft $draft)
    {
        $request->validate([
            'reject_reason' => 'nullable|string|max:500',
        ]);

        $draft->update([
            'status' => 'rejected',
            'moderator_id' => auth()->id(),
            'reviewed_at' => now(),
            'reject_reason' => $request->reject_reason ?? 'No reason provided',
        ]);

        return redirect()->route('admin.forex-drafts.index', ['status' => 'draft'])
            ->with('success', 'Draft rejected.');
    }

    /**
     * Regenerate AI content for a draft.
     */
    public function regenerate(ForexBlogDraft $draft, HuggingFaceRewriterService $rewriter)
    {
        $result = $rewriter->regenerate($draft);

        if ($result) {
            return back()->with('success', 'Draft regenerated with fresh AI content.');
        }

        return back()->with('error', 'Failed to regenerate. Check your HuggingFace API token and try again.');
    }

    /**
     * Bulk approve multiple drafts.
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'draft_ids' => 'required|array',
            'draft_ids.*' => 'exists:forex_blog_drafts,id',
        ]);

        $count = 0;
        foreach ($request->draft_ids as $id) {
            $draft = ForexBlogDraft::find($id);
            if ($draft && $draft->status === 'draft') {
                // Create post
                $slug = Str::slug($draft->ai_title);
                $originalSlug = $slug;
                $counter = 1;
                while (Post::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $counter++;
                }

                $content = $draft->ai_content;
                if (!empty($draft->lead_cta)) {
                    $content .= "\n\n<div class=\"forex-cta-block\" style=\"background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; padding: 24px; border-radius: 12px; margin-top: 32px; text-align: center;\">"
                        . "<p style=\"font-size: 1.1rem; font-weight: 600; margin: 0;\">" . e($draft->lead_cta) . "</p>"
                        . "</div>";
                }

                $post = Post::create([
                    'title' => $draft->ai_title,
                    'slug' => $slug,
                    'content' => $content,
                    'short_description' => $draft->ai_excerpt,
                    'is_published' => true,
                    'published_at' => now(),
                ]);

                $draft->update([
                    'status' => 'published',
                    'moderator_id' => auth()->id(),
                    'reviewed_at' => now(),
                    'published_at' => now(),
                    'post_id' => $post->id,
                ]);

                $count++;
            }
        }

        return back()->with('success', "{$count} drafts approved and published.");
    }

    /**
     * Pipeline dashboard with stats.
     */
    public function pipeline()
    {
        $stats = [
            'raw_total' => ForexRawArticle::count(),
            'raw_pending' => ForexRawArticle::pending()->count(),
            'raw_used' => ForexRawArticle::used()->count(),
            'raw_today' => ForexRawArticle::today()->count(),
            'drafts_total' => ForexBlogDraft::count(),
            'drafts_pending' => ForexBlogDraft::drafts()->count(),
            'drafts_approved' => ForexBlogDraft::approved()->count(),
            'drafts_rejected' => ForexBlogDraft::rejected()->count(),
            'drafts_published' => ForexBlogDraft::published()->count(),
            'drafts_today' => ForexBlogDraft::whereDate('created_at', today())->count(),
            'published_today' => ForexBlogDraft::published()->whereDate('published_at', today())->count(),
        ];

        // Source breakdown
        $sourceBreakdown = ForexRawArticle::selectRaw('source_name, COUNT(*) as count')
            ->groupBy('source_name')
            ->orderByDesc('count')
            ->get();

        // Daily stats for last 7 days
        $dailyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyStats[] = [
                'date' => $date->format('M d'),
                'fetched' => ForexRawArticle::whereDate('fetched_at', $date)->count(),
                'generated' => ForexBlogDraft::whereDate('created_at', $date)->count(),
                'published' => ForexBlogDraft::published()->whereDate('published_at', $date)->count(),
            ];
        }

        // Recent drafts
        $recentDrafts = ForexBlogDraft::with('rawArticle')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.forex-drafts.pipeline', compact('stats', 'sourceBreakdown', 'dailyStats', 'recentDrafts'));
    }

    /**
     * Manually trigger RSS fetch.
     */
    public function triggerFetch(ForexRssFetcherService $fetcher)
    {
        try {
            $stats = $fetcher->fetchAll();
            return back()->with('success', "RSS Fetch complete: {$stats['fetched']} new articles, {$stats['duplicates']} duplicates, {$stats['errors']} errors.");
        } catch (\Exception $e) {
            return back()->with('error', 'Fetch failed: ' . $e->getMessage());
        }
    }

    /**
     * Manually trigger AI generation.
     */
    public function triggerGenerate(Request $request, HuggingFaceRewriterService $rewriter)
    {
        $limit = $request->input('count', config('forex.posts_per_day', 10));
        $count = max(1, min((int)$limit, 50)); // Ensure bounds between 1 and 50

        $articles = ForexRawArticle::topCandidates($count)->get();

        if ($articles->isEmpty()) {
            return back()->with('error', 'No pending articles. Fetch RSS feeds first.');
        }

        $success = 0;
        $failed = 0;

        foreach ($articles as $article) {
            $draft = $rewriter->rewrite($article);
            if ($draft) {
                $success++;
            } else {
                $failed++;
                $article->update(['status' => 'skipped']);
            }
        }

        return back()->with('success', "AI Generation complete: {$success} drafts created, {$failed} failed.");
    }
    /**
     * List raw articles (pending) with stats.
     */
    public function listRawArticles()
    {
        $articles = ForexRawArticle::where('status', 'pending')
            ->orderByDesc('relevance_score')
            ->orderByDesc('published_at')
            ->paginate(15);

        $stats = [
            'total' => ForexRawArticle::count(),
            'pending' => ForexRawArticle::pending()->count(),
            'used' => ForexRawArticle::used()->count(),
            'today' => ForexRawArticle::whereDate('fetched_at', today())->count(),
        ];

        return view('admin.forex-raw.index', compact('articles', 'stats'));
    }

    /**
     * Preview a raw article before any rewrite.
     */
    public function previewRaw(ForexRawArticle $article)
    {
        return view('admin.forex-raw.preview', compact('article'));
    }

    /**
     * Publish a raw article directly without AI rewrite.
     */
    public function publishWithoutRewrite(ForexRawArticle $article)
    {
        // Create slug
        $slug = Str::slug($article->raw_title);
        $originalSlug = $slug;
        $counter = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        // Parse raw plain text content to beautiful HTML paragraphs and headings
        $paragraphs = explode("\n", $article->raw_content);
        $formattedContent = '';
        foreach ($paragraphs as $para) {
            $para = trim($para);
            if (empty($para)) continue;

            // If the line is short and doesn't end with typical punctuation, treat as heading
            if (strlen($para) < 90 && !str_ends_with($para, '.') && !str_ends_with($para, '?') && !str_ends_with($para, '!')) {
                $formattedContent .= "<h3>" . e($para) . "</h3>\n";
            } else {
                $formattedContent .= "<p>" . e($para) . "</p>\n";
            }
        }

        $post = Post::create([
            'title' => $article->raw_title,
            'slug' => $slug,
            'content' => $formattedContent,
            'short_description' => mb_substr(strip_tags($article->raw_content), 0, 500),
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Mark raw article as used
        $article->update(['status' => 'used']);

        return back()->with('success', "Raw article \"{$article->raw_title}\" published successfully with beautiful formatting.");
    }

    /**
     * Rewrite a specific raw article using AI.
     */
    public function rewriteSingle(Request $request, ForexRawArticle $article, HuggingFaceRewriterService $rewriter)
    {
        if ($article->status !== 'pending') {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This article has already been processed.'
                ], 422);
            }
            return back()->with('error', 'This article has already been processed.');
        }

        try {
            $draft = $rewriter->rewrite($article);

            if ($draft) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'AI rewrite completed successfully!',
                        'redirect_url' => route('admin.forex-drafts.show', $draft)
                    ]);
                }
                return redirect()->route('admin.forex-drafts.show', $draft)
                    ->with('success', 'AI rewrite completed successfully! You can now review and publish the draft.');
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate AI rewrite. Please check the rewriter integration.'
                ], 422);
            }
            return back()->with('error', 'Failed to generate AI rewrite. Please check the rewriter integration.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI rewrite failed: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'AI rewrite failed: ' . $e->getMessage());
        }
    }

}

