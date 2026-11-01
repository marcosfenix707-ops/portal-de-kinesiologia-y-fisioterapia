<?php

namespace App\Providers;

use App\Models\Contenido;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // Secciones de "La carrera" para el menú del portal público.
        View::composer('layouts.public', function ($view) {
            $orden = Contenido::orden();
            $view->with('menuSecciones', Contenido::whereIn('clave', $orden)->get()
                ->sortBy(fn ($c) => array_search($c->clave, $orden))->values());
        });
    }
}
