<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\ForexDraftController;
use App\Services\HuggingFaceRewriterService;

// Create a request with count parameter
$request = Request::create('/admin/forex-drafts/trigger-generate', 'POST', ['count' => 3]);

$controller = $app->make(ForexDraftController::class);
$hfService = $app->make(HuggingFaceRewriterService::class);

$response = $controller->triggerGenerate($request, $hfService);

// Output response content
if (method_exists($response, 'getContent')) {
    echo $response->getContent();
} else {
    var_dump($response);
}
?>
