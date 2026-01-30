<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\XanoAiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register XanoAiService as singleton for performance
        $this->app->singleton(XanoAiService::class, function ($app) {
            return new XanoAiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
