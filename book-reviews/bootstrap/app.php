<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // ✅ Cuando cualquier rate limiter se dispara (HTTP 429),
        // redirige al usuario a la página anterior con un mensaje amigable
        // en lugar de mostrar la pantalla de error genérica de Laravel.
        $exceptions->render(function (ThrottleRequestsException $e) {
            return back()
                ->withErrors(['throttle' => 'Too many requests. Please slow down and try again shortly.'])
                ->withInput();
        });
    })->create();
