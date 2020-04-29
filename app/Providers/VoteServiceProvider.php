<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\VoteService;

class VoteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('VoteService', VoteService::class);
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
