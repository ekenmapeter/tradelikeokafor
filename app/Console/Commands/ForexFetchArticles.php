<?php

namespace App\Console\Commands;

use App\Services\ForexRssFetcherService;
use Illuminate\Console\Command;

class ForexFetchArticles extends Command
{
    protected $signature = 'forex:fetch-articles
                            {--source= : Fetch from a specific source only (e.g. ForexLive)}';

    protected $description = 'Fetch latest forex news articles from configured RSS feeds';

    public function handle(ForexRssFetcherService $fetcher): int
    {
        $source = $this->option('source');

        if ($source) {
            $this->info("Fetching articles from: {$source}");
            try {
                $stats = $fetcher->fetchSource($source);
                $this->displayStats(['sources' => [$source => $stats]]);
            } catch (\Exception $e) {
                $this->error("Failed: {$e->getMessage()}");
                return self::FAILURE;
            }
        } else {
            $this->info('Fetching articles from all configured RSS feeds...');
            $this->newLine();

            $stats = $fetcher->fetchAll();

            $this->info("✅ Fetch complete!");
            $this->table(
                ['Metric', 'Count'],
                [
                    ['New Articles', $stats['fetched']],
                    ['Duplicates Skipped', $stats['duplicates']],
                    ['Feed Errors', $stats['errors']],
                ]
            );
        }

        return self::SUCCESS;
    }

    protected function displayStats(array $data): void
    {
        foreach ($data['sources'] as $name => $stats) {
            $this->line("  {$name}: {$stats['fetched']} new, {$stats['duplicates']} duplicates");
        }
    }
}
