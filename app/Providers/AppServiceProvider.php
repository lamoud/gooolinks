<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Livewire::addPersistentMiddleware([
            'web',
            'universal',
            InitializeTenancyByDomain::class,
    
        ]);
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }
}
