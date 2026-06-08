<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\ForexBlogDraft;
use App\Models\ForexRawArticle;

// Count drafts and raw articles status
$draftCount = ForexBlogDraft::count();
$rawPending = ForexRawArticle::where('status', 'pending')->count();
$rawUsed = ForexRawArticle::where('status', 'used')->count();

echo "Drafts total: $draftCount\n";
echo "Raw pending: $rawPending\n";
echo "Raw used: $rawUsed\n";
?>
