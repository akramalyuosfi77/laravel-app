<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use Illuminate\Support\Facades\View; // تأكد من استدعاء الكلاس
use Illuminate\Support\Facades\Auth; // تأكد من استدعاء الكلاس


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // public function register(): void
    // {
    //     //
    // }

    /**
     * Bootstrap any application services.
     */

// public function boot(): void
// {
//     // ... أي كود آخر موجود هنا ...

//     // 🔥 مشاركة بيانات المستخدم مع كل الـ Views بكفاءة عالية
//     View::composer('*', function ($view) {
//         if (Auth::check()) {
//             $user = Auth::user();
//             $view->with('currentUser', (object) [
//                 'name' => $user->name,
//                 'email' => $user->email,
//                 'role' => $user->role,
//                 // افترض أن لديك دالة initials() في مودل User
//                 'initials' => $user->initials(),
//             ]);
//         }
//     });
// }
}
