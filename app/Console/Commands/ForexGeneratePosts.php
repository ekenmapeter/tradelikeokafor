<?php

namespace App\Console\Commands;

use App\Models\ForexRawArticle;
use App\Services\HuggingFaceRewriterService;
use Illuminate\Console\Command;

class ForexGeneratePosts extends Command
{
    protected $signature = 'forex:generate-posts
                            {--count= : Number of posts to generate (default from config)}';

    protected $description = 'Generate AI-rewritten forex blog drafts from pending raw articles';

    public function handle(HuggingFaceRewriterService $rewriter): int
    {
        $count = $this->option('count') ?? config('forex.posts_per_day', 10);

        $this->info("Generating {$count} AI forex blog drafts...");
        $this->newLine();

        // Get top pending articles by relevance
        $articles = ForexRawArticle::topCandidates($count)->get();

        if ($articles->isEmpty()) {
            $this->warn('No pending articles found. Run forex:fetch-articles first.');
            return self::SUCCESS;
        }

        $this->info("Found {$articles->count()} candidate articles.");
        $this->newLine();

        $bar = $this->output->createProgressBar($articles->count());
        $bar->start();

        $success = 0;
        $failed = 0;

        foreach ($articles as $article) {
            $this->newLine();
            $this->line("  📝 Processing: " . mb_substr($article->raw_title, 0, 60) . '...');

            $draft = $rewriter->rewrite($article);

            if ($draft) {
                $success++;
                $this->line("  ✅ Generated: {$draft->ai_title}");
            } else {
                $failed++;
                $article->update(['status' => 'skipped']);
                $this->line("  ❌ Failed to generate draft");
            }

            $bar->advance();

            // Small delay between API calls to respect rate limits
            if ($articles->count() > 1) {
                sleep(2);
            }
        }

        $bar->finish();
        $this->newLine(2);

        $this->info('Generation complete!');
        $this->table(
            ['Metric', 'Count'],
            [
                ['Drafts Created', $success],
                ['Failed/Skipped', $failed],
                ['Total Processed', $articles->count()],
            ]
        );

        if ($success > 0) {
            $this->info("→ {$success} drafts ready for moderator review in the dashboard.");
        }

        return self::SUCCESS;
    }
}
