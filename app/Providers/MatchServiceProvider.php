<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MatchService;

class MatchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('MatchService', MatchService::class);
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
