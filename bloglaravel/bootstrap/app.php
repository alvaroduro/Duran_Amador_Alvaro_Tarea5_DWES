<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // Rutas admin
            Route::middleware(['web', 'auth']) // Token CSRF + autenticación
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));

            // Rutas usuario
            Route::middleware(['web', 'auth']) // Puedes agregar middleware adicional como 'role:user' si tienes roles
                ->prefix('user')
                ->name('user.')
                ->group(base_path('routes/user.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
            'is_user' => \App\Http\Middleware\IsUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
