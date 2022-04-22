<?php

namespace App\Providers;

use App\Materia;
use Illuminate\Support\ServiceProvider;

class MateriasProvider extends ServiceProvider
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

        view()->composer('materias.*', function ($view) {
            $view->with('archived', Materia::archived()->get())
                ->with('rows', Materia::actives()->get());
        });
    }
}
