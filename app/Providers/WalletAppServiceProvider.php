<?php

namespace App\Providers;

use App\Services\RecordService;
use App\Services\WalletService;
use Illuminate\Support\ServiceProvider;

class WalletAppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WalletService::class, function ($app) {
            return new WalletService();
        });
        $this->app->singleton(RecordService::class, function ($app) {
            return new RecordService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
