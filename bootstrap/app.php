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
        $middleware->append(\ikepu_tp\ActivityLog\app\Http\Middleware\ActivityLogMiddleware::class);
        $middleware->web(append: [
            \ikepu_tp\AccessLogger\app\Http\Middleware\AccessLoggerMiddleware::class.':web',
        ]);
        $middleware->api(append: [
            \ikepu_tp\AccessLogger\app\Http\Middleware\AccessLoggerMiddleware::class.':api',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
