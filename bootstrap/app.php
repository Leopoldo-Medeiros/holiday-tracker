<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Only keep essential middleware for API routes
        $middleware->api([
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);
        
        // Remove all authentication middleware from API routes
        $middleware->removeFromGroup('api', \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class);
        $middleware->removeFromGroup('api', \Illuminate\Auth\Middleware\Authenticate::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
