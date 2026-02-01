<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSubscriptionPlanController;
use App\Http\Controllers\Admin\AdminUserSubscriptionController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\ImpersonateController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\User\UserSubscriptionController;
use App\Http\Controllers\User\UserTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

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

Route::get('/paystack/callback', [App\Http\Controllers\PaystackController::class, 'handleCallback'])->name('paystack.callback');
Route::post('/paystack/webhook', [App\Http\Controllers\PaystackController::class, 'handleWebhook'])->name('paystack.webhook');

// Redirect /dashboard based on user role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
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

    // Blog Management
    Route::resource('blog', AdminBlogController::class)->parameters([
        'blog' => 'post'
    ]);
    Route::post('blog/upload', [AdminBlogController::class, 'uploadImage'])->name('blog.upload');

    // Impersonation
    Route::get('/users/{user}/impersonate', [ImpersonateController::class, 'impersonate'])->name('users.impersonate');
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
