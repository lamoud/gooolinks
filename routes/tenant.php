<?php

declare(strict_types=1);

use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\MagicLinkController;
use App\Http\Controllers\Tenant\Backend\BackendController;
use App\Http\Controllers\Tenant\Frontend\FrontendController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    'universal',
    'auth:sanctum',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'can:admin_view',
    'checkSiteMode'
])->controller(BackendController::class)
->group(function () {
    Route::get('/dashboard', 'dashboard')->name('te.dashboard');
});

Route::middleware([
    'web',
    'universal',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->controller(MagicLinkController::class)
->group(function () {
    Route::get('/magic-login/{token}', 'login')->name('magic.login');
});

Route::controller(DropzoneController::class)->group(function(){

    //Route::get('dropzone', 'index');

    Route::post('dropzone/store', 'store')->name('te.dropzone.store');

});

Route::middleware([
    'web',
    'universal',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'checkSiteMode'
])->controller(FrontendController::class)->group(function () {
    Route::get('/', 'home')->name('te.home');
    // Route::get('/', function () {
    //     return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    // });
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'web',
    'universal',
    'checkSiteMode',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->controller(FrontendController::class)->group(function () {
    Route::get('/profile', 'profile')->name('te.profile.index');
    Route::get('/profile/settings', 'profile_settings')->name('te.profile.settings');
});
