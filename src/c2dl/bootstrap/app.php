<?php

use App\Http\Middleware\CheckForMaintenanceMode;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\TrustProxies;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Spatie\Csp\AddCspHeaders;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(CheckForMaintenanceMode::class);
        $middleware->append(StartSession::class);
        $middleware->append(EncryptCookies::class);
        $middleware->append(TrustProxies::class);
        $middleware->append(VerifyCsrfToken::class);
        $middleware->append(AddCspHeaders::class);
    })
    ->withExceptions(function (Exceptions $_) {
        // unused
    })
    ->create();
