<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Settings\Setting;
use App\Settings\SettingService;
use Illuminate\Contracts\Cache\Repository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();

        $this->app->singleton(SettingService::class, function ($app) {
            return new SettingService($app->make(Setting::class), $app->make(Repository::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
