<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\ServiceProvider;

class UserProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('usuarios.*', function ($view) {
            $view->with('archived', User::archived()->get())
                ->with('rows', User::actives()->get());
        });
    }
}
