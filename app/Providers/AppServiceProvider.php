<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
        Schema::defaultStringLength(125);

        /* 
        * view components
        */
        Blade::component('components.datatable', 'datatable');
        Blade::component('components.datatable-actions', 'dtactions');
        Blade::component('components.datatable-link', 'dtlink');
        Blade::component('components.status-switch', 'statusswitch');
    }
}
