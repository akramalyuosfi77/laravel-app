<?php
use \App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use \App\Http\Middleware\Authenticate;
use \App\Http\Middleware\CheckUserIsActive; // 💡 الخطوة 1: استيراد الـ Middleware الجديد
use \Illuminate\Support\Facades\RateLimiter;
use \Illuminate\Cache\RateLimiting\Limit;
use \Illuminate\Http\Request;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        // --- أضف هذا الجزء ---
    then: function () {
        RateLimiter::for('forms', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });
    }
    // --- نهاية الجزء المضاف ---
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 💡 الخطوة 2: إضافة الـ Middleware إلى مجموعة 'web'
        $middleware->appendToGroup('web', [
            CheckUserIsActive::class,
        ]);

        // هذا الجزء يبقى كما هو
        $middleware->alias([
            'auth' => Authenticate::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
