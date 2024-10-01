<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Questo è il path della tua homepage.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Definisci le rotte per l'applicazione.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            // Caricamento delle rotte API
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            // Caricamento delle rotte web
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }
}
