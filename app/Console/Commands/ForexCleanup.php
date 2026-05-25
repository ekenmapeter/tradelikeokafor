<?php

namespace App\Console\Commands;

use App\Models\ForexBlogDraft;
use App\Models\ForexRawArticle;
use Illuminate\Console\Command;

class ForexCleanup extends Command
{
    protected $signature = 'forex:cleanup
                            {--dry-run : Show what would be cleaned without deleting}';

    protected $description = 'Clean up old forex raw articles and rejected drafts';

    public function handle(): int
    {
        $rawRetention = config('forex.raw_article_retention_days', 30);
        $draftRetention = config('forex.rejected_draft_retention_days', 14);
        $dryRun = $this->option('dry-run');

        $this->info($dryRun ? '🔍 DRY RUN — No data will be deleted' : '🧹 Running cleanup...');
        $this->newLine();

        // 1. Archive old raw articles (used/skipped, older than retention period)
        $oldArticles = ForexRawArticle::whereIn('status', ['used', 'skipped'])
            ->where('created_at', '<', now()->subDays($rawRetention))
            ->whereDoesntHave('drafts', function ($q) {
                $q->whereIn('status', ['draft', 'approved']);
            });

        $oldArticleCount = $oldArticles->count();

        if (!$dryRun && $oldArticleCount > 0) {
            $oldArticles->delete();
        }

        $this->line("  Raw articles (>{$rawRetention} days, used/skipped): {$oldArticleCount}");

        // 2. Remove rejected drafts older than retention period
        $oldDrafts = ForexBlogDraft::rejected()
            ->where('reviewed_at', '<', now()->subDays($draftRetention));

        $oldDraftCount = $oldDrafts->count();

        if (!$dryRun && $oldDraftCount > 0) {
            $oldDrafts->delete();
        }

        $this->line("  Rejected drafts (>{$draftRetention} days): {$oldDraftCount}");

        $this->newLine();
        $total = $oldArticleCount + $oldDraftCount;
        $this->info($dryRun
            ? "Would clean up {$total} records."
            : "✅ Cleaned up {$total} records."
        );

        return self::SUCCESS;
    }
}
