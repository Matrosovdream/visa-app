<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isUser;
use App\Http\Middleware\isUserOrder;
use App\Http\Middleware\hasRole;
use App\Http\Middleware\isOrderPaid;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'isAdmin' => isAdmin::class,
            'isUser' => isUser::class,
            'hasRole' => hasRole::class,
            'isUserOrder' => isUserOrder::class,
            'isOrderPaid' => isOrderPaid::class,
        ]);

        // Send unauthenticated visitors of admin-only paths to the Blade
        // login (session auth). The public SPA /login only issues Sanctum
        // tokens, so landing there wouldn't give them access to /dashboard.
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('dashboard', 'dashboard/*', 'admin', 'admin/*',
                             'admin-panel', 'admin-panel/*', 'api/v1/admin/*')) {
                return route('backend.login');
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
