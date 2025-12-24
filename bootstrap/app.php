<?php

use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\CheckUserIsActive;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            RateLimiter::for('forms', function (Request $request) {
                return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
            });
        }
    )
    ->withMiddleware(function (Middleware $middleware) {

        // ==========================================================
        // ⭐⭐⭐ هذا هو الإصلاح الحاسم والنهائي ⭐⭐⭐
        // ==========================================================
        // هذا السطر يخبر Laravel أن يستخدم Sanctum لمصادقة طلبات الـ API
        // وهو يحل مشكلة أن المستخدم يكون null في الطلبات المصادقة.
        $middleware->statefulApi();


        // الكود الخاص بك يبقى كما هو بدون تغيير
        $middleware->appendToGroup('web', [
            CheckUserIsActive::class,
        ]);

        $middleware->alias([
            'auth' => Authenticate::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
