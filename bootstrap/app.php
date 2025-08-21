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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'admin.type' => \App\Http\Middleware\AdminTypeMiddleware::class,
            'redirect.role' => \App\Http\Middleware\RedirectAccordingToRole::class,
            'verified.email' => \App\Http\Middleware\EnsureEmailIsVerified::class,
            'conditional.email.verification' => \App\Http\Middleware\ConditionalEmailVerification::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
