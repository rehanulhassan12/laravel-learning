<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\CheckScreenAccess;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function ($middleware) {
        // Register route middleware alias
        $middleware->alias([
            'screen' => CheckScreenAccess::class,
        ]);
    })
    ->withExceptions(function ($exceptions) {
        //
    })
    ->create();
