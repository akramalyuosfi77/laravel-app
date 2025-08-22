<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 💡 تحقق مما إذا كان هناك مستخدم مسجل دخوله
        if (Auth::check()) {
            // 💡 إذا كان المستخدم غير مفعل
            if (!Auth::user()->is_active) {
                // 💡 قم بتسجيل خروجه
                Auth::logout();

                // 💡 إبطال الجلسة
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // 💡 توجيهه إلى صفحة تسجيل الدخول مع رسالة توضيحية
                return redirect()->route('login')->with('error', 'تم تعطيل حسابك من قبل الإدارة.');
            }
        }

        // 💡 إذا كان المستخدم مفعلًا، اسمح له بالمرور
        return $next($request);
    }
}
