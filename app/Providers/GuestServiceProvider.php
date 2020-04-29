<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GuestService;

class GuestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('GuestService', GuestService::class);
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
