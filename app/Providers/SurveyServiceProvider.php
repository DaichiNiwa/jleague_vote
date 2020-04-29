<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SurveyService;

class SurveyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('SurveyService', SurveyService::class);
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
