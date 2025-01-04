<?php

use App\Http\Controllers\Backend\BackendController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\MagicLinkController;
use App\Http\Controllers\SocialAuth\AppleController;
use App\Http\Controllers\SocialAuth\GoogleController;
use App\Http\Controllers\Subscription\SubscriptionController;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'can:admin_view',
    'checkSiteMode'
])->controller(BackendController::class)
->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/dashboard/payments', 'payments')->name('admin.payments');
    Route::get('/dashboard/links', 'links')->name('admin.links');
    Route::get('/dashboard/staf-roles', 'stafRoles')->name('admin.stafroles');
    Route::get('/dashboard/plans', 'plans')->name('admin.plans');
    Route::get('/dashboard/users', 'users')->name('admin.users');
    Route::get('/dashboard/settings', 'settings')->name('admin.settings');
});


Route::middleware(['checkSiteMode'])->controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/plans-subscription', 'plans_subscription')->name('plans');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'checkSiteMode'
])->controller(FrontendController::class)
->group(function () {
    Route::get('/plans-subscription/{slug}', 'plans_subscription_show')->name('plans.show');
    Route::get('/profile', 'profile')->name('profile.index');
    Route::get('/profile/settings', 'profile_settings')->name('profile.settings');
    //Route::post('/orders', 'store');
});

Route::middleware(['checkSiteMode'])->controller(SubscriptionController::class)->group(function () {
    Route::get('/subscription', 'show')->middleware('auth')->name('subscription.show');
    Route::post('/subscription', 'store')->middleware('auth')->name('subscription.store');
    Route::get('/subscription/success', 'success')->middleware('auth')->name('subscription.success');
    Route::get('/subscription/failure', 'failure')->middleware('auth')->name('subscription.failure');
    
});

Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);


Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('auth/apple', [AppleController::class, 'redirectToApple'])->name('apple.login');
Route::get('auth/apple/callback', [AppleController::class, 'handleAppleCallback']);

Route::controller(DropzoneController::class)->group(function(){

    //Route::get('dropzone', 'index');

    Route::post('dropzone/store', 'store')->name('dropzone.store');

});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'can:admin_view',
    'checkSiteMode'
])->group(function () {
    Route::post('/generate-magic-link', [MagicLinkController::class, 'generate'])->name('generate.magic.link');
    // Route::get('/magic-login/{token}', [MagicLinkController::class, 'login'])->name('magic.login');
});