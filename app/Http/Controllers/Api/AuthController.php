<?php

namespace App\Http\Controllers\Api;

// Core Laravel & Controller
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;

// Facades for Authentication, Logging, Rate Limiting, etc.
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

// Exceptions & Notifications
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Lockout;

class AuthController extends Controller
{
    /**
     * يتعامل مع طلب تسجيل الدخول للمدير (admin).
     * الآن يستقبل fcm_token ويقوم بتحديثه مباشرة.
     */
    public function managerLogin(Request $request)
    {
        Log::info('--- LOGIN REQUEST RECEIVED (MANUAL FIX METHOD) ---');
        Log::info('Request Data:', $request->all());

        // ⭐ 1. تعديل التحقق ليشمل fcm_token (اختياري)
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'fcm_token' => 'nullable|string', // <-- تم إضافة هذا
        ]);

        $this->ensureIsNotRateLimited($request);

        if (! Auth::attempt($request->only('email', 'password'))) {
            Log::warning('Authentication failed for email: ' . $request->input('email'));
            RateLimiter::hit($this->throttleKey($request));
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        Log::info('Authentication successful for user:', $user->toArray());

        if ($user->role !== 'admin') {
            Log::warning('Login attempt by non-admin user:', $user->toArray());
            Auth::guard('web')->logout();
            return response()->json(['message' => 'فشل تسجيل الدخول. هذا المسار مخصص للمدراء فقط.'], 403);
        }

        // ⭐ 2. تحديث FCM TOKEN مباشرة هنا!
        if ($request->filled('fcm_token')) {
            $user->fcm_token = $request->input('fcm_token');
            $user->save();
            Log::info('FCM Token updated directly during login for user: ' . $user->id);
        }

        RateLimiter::clear($this->throttleKey($request));

        $token = $user->createToken('manager-auth-token')->plainTextToken;
        Log::info('Token created successfully for user: ' . $user->id);

        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح كمدير',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    /**
     * هذه الدالة لم نعد نستخدمها في الحل اليدوي، ولكن سنبقيها موجودة.
     */
    public function updateFcmToken(Request $request)
    {
        Log::warning('--- UPDATE FCM TOKEN (OLD METHOD) WAS CALLED ---');
        // هذا الكود لن يتم تنفيذه في الحل الجديد، ولكنه موجود كمرجع
        $request->validate(['fcm_token' => 'required|string']);
        $user = $request->user();
        if ($user) {
            $user->fcm_token = $request->fcm_token;
            $user->save();
            return response()->json(['message' => 'FCM token updated successfully (old method).']);
        }
        return response()->json(['message' => 'Unauthenticated (old method).'], 401);
    }

    /**
     * التأكد من أن طلب المصادقة ليس محدود المحاولات.
     * (تم إرجاع الكود الأصلي بالكامل)
     */
    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));
        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * الحصول على مفتاح تحديد معدل المحاولات للمصادقة.
     * (تم إرجاع الكود الأصلي بالكامل)
     */
    protected function throttleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')).'|'.$request->ip());
    }
}
