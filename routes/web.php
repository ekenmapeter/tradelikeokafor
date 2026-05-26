<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSubscriptionPlanController;
use App\Http\Controllers\Admin\AdminUserSubscriptionController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\AdminEbookController;
use App\Http\Controllers\Admin\ImpersonateController;
use App\Http\Controllers\Admin\ForexDraftController;
use App\Http\Controllers\EbookController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserSubscriptionController;
use App\Http\Controllers\User\UserTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::redirect('/admin/login', '/login');

Route::get('mentorship-payment', function () {
    return view('mentorship-payment');
})->name('mentorship-payment');

Route::get('signals', function () {
    return view('signals');
})->name('signals');

Route::get('mentorship-payment-online', function () {
    return view('mentorship-payment-online');
})->name('mentorship-payment-online');

Route::get('premium-payment', function () {
    return view('premium-payment');
})->name('premium-payment');

Route::get('mentorship', function () {
    return view('mentorship');
})->name('mentorship');

Route::get('mentorship-exclusive', function () {
    return view('mentorship-exclusive');
})->name('mentorship-exclusive');

Route::get('blog', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Ebook Routes (Public)
Route::get('ebooks', [EbookController::class, 'index'])->name('ebooks.index');
Route::get('ebooks/{slug}', [EbookController::class, 'show'])->name('ebooks.show');
Route::post('ebooks/{slug}/purchase', [EbookController::class, 'purchase'])->name('ebooks.purchase');
Route::get('ebooks/order/{orderNumber}/thankyou', [EbookController::class, 'thankyou'])->name('ebooks.thankyou');

Route::get('/paystack/callback', [App\Http\Controllers\PaystackController::class, 'handleCallback'])->name('paystack.callback');
Route::post('/paystack/webhook', [App\Http\Controllers\PaystackController::class, 'handleWebhook'])->name('paystack.webhook');

// Redirect /dashboard based on user role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    if (auth()->user()->isModerator()) {
        return redirect()->route('admin.blog.index');
    }
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes (Full Admin only)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/activate', [AdminUserController::class, 'activate'])->name('users.activate');
    
    // Subscription Plans
    Route::resource('subscription-plans', AdminSubscriptionPlanController::class);
    Route::post('/subscription-plans/{subscriptionPlan}/toggle', [AdminSubscriptionPlanController::class, 'toggleStatus'])->name('subscription-plans.toggle');
    
    // User Subscriptions
    Route::get('/subscriptions', [AdminUserSubscriptionController::class, 'index'])->name('subscriptions.index');
    Route::get('/subscriptions/create', [AdminUserSubscriptionController::class, 'create'])->name('subscriptions.create');
    Route::post('/subscriptions', [AdminUserSubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::post('/subscriptions/{subscription}/cancel', [AdminUserSubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
    
    // Transactions
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/{transaction}/approve', [AdminTransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');

    // Settings
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Ebook Management
    Route::resource('ebooks', AdminEbookController::class);
    Route::get('/ebook-orders', [AdminEbookController::class, 'orders'])->name('ebook-orders.index');
    Route::post('/ebook-orders/{order}/approve', [AdminEbookController::class, 'approveOrder'])->name('ebook-orders.approve');
    Route::post('/ebook-orders/{order}/decline', [AdminEbookController::class, 'declineOrder'])->name('ebook-orders.decline');

    // Impersonation
    Route::get('/users/{user}/impersonate', [ImpersonateController::class, 'impersonate'])->name('users.impersonate');

    // Profit Records
    Route::resource('profit-records', \App\Http\Controllers\Admin\AdminProfitRecordController::class);
});

// Blog Moderator Routes (Admin + Moderator)
Route::middleware(['auth', 'moderator'])->prefix('admin')->name('admin.')->group(function () {
    // Blog Management
    Route::get('blog/analytics', [AdminBlogController::class, 'analytics'])->name('blog.analytics');
    Route::resource('blog', AdminBlogController::class)->parameters([
        'blog' => 'post'
    ]);
    Route::get('blog/{post}/views', [AdminBlogController::class, 'views'])->name('blog.views');
    Route::post('blog/upload', [AdminBlogController::class, 'uploadImage'])->name('blog.upload');

    // Forex Pipeline & Drafts
    Route::get('forex-drafts/pipeline', [ForexDraftController::class, 'pipeline'])->name('forex-drafts.pipeline');
    Route::post('forex-drafts/trigger-fetch', [ForexDraftController::class, 'triggerFetch'])->name('forex-drafts.trigger-fetch');
    Route::post('forex-drafts/trigger-generate', [ForexDraftController::class, 'triggerGenerate'])->name('forex-drafts.trigger-generate');
    Route::post('forex-drafts/{draft}/approve', [ForexDraftController::class, 'approve'])->name('forex-drafts.approve');
    Route::post('forex-drafts/{draft}/reject', [ForexDraftController::class, 'reject'])->name('forex-drafts.reject');
    Route::post('forex-drafts/{draft}/regenerate', [ForexDraftController::class, 'regenerate'])->name('forex-drafts.regenerate');
    Route::post('forex-drafts/bulk-approve', [ForexDraftController::class, 'bulkApprove'])->name('forex-drafts.bulk-approve');
    Route::resource('forex-drafts', ForexDraftController::class)->parameters([
        'forex-drafts' => 'draft'
    ])->except(['create', 'store', 'destroy']);

    // Forex Raw Articles
    Route::get('forex-raw', [ForexDraftController::class, 'listRawArticles'])->name('forex-raw.index');
    Route::get('forex-raw/{article}/preview', [ForexDraftController::class, 'previewRaw'])->name('forex-raw.preview');
    Route::post('forex-raw/{article}/publish', [ForexDraftController::class, 'publishWithoutRewrite'])->name('forex-raw.publish');
    Route::post('forex-raw/{article}/rewrite', [ForexDraftController::class, 'rewriteSingle'])->name('forex-raw.rewrite');
    // Delete raw article
    Route::delete('forex-raw/{article}', [ForexDraftController::class, 'deleteRawArticle'])->name('forex-raw.delete');
    // Bulk delete raw articles
    Route::post('forex-raw/bulk-delete', [ForexDraftController::class, 'bulkDeleteRawArticles'])->name('forex-raw.bulk-delete');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/leave-impersonation', [ImpersonateController::class, 'leave'])->name('impersonate.leave');
});

/*
// User Routes
Route::middleware(['auth', 'check.user.status', 'impersonate'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/subscriptions', [UserSubscriptionController::class, 'index'])->name('subscriptions');
    Route::get('/subscriptions/{plan}/manual-payment', [UserSubscriptionController::class, 'manualPayment'])->name('subscriptions.manual-payment');
    Route::post('/subscriptions/{plan}/manual-payment', [UserSubscriptionController::class, 'submitManualPayment'])->name('subscriptions.submit-manual-payment');
    Route::get('/transactions', [UserTransactionController::class, 'index'])->name('transactions');
});
*/

Route::middleware(['auth', 'check.user.status'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
