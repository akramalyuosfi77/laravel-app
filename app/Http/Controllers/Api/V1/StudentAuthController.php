<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // مهم لتتبع الطلبات
use Illuminate\Validation\ValidationException;

class StudentAuthController extends Controller
{
    /**
     * يتعامل مع طلب تسجيل الدخول الخاص بالطلاب فقط.
     * هذا الكود مطابق لمنطق المدير مع تغيير بسيط.
     */
    public function login(Request $request)
    {
        Log::info('--- STUDENT LOGIN REQUEST RECEIVED ---');
        Log::info('Request Data:', $request->all());

        // 1. التحقق من صحة البيانات
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // 2. محاولة المصادقة (نفس منطق المدير)
        if (!Auth::attempt($request->only('email', 'password'))) {
            Log::warning('Student authentication failed for email: ' . $request->input('email'));
            throw ValidationException::withMessages([
                'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
            ]);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        Log::info('Authentication successful for user ID: ' . $user->id);

        // 3. ⭐⭐⭐ التحقق الحاسم: هل المستخدم طالب؟ ⭐⭐⭐
        // هذا هو التعديل الوحيد والمهم عن كنترولر المدير
        if ($user->role !== 'student') {
            Log::warning('Login attempt by non-student user:', ['id' => $user->id, 'role' => $user->role]);
            Auth::guard('web')->logout(); // تسجيل الخروج من الجلسة المؤقتة
            return response()->json(['message' => 'فشل تسجيل الدخول. هذا المسار مخصص للطلاب فقط.'], 403);
        }

        // 4. إنشاء التوكن (نفس منطق المدير)
        $token = $user->createToken('student-app-token')->plainTextToken;
        Log::info('Token created successfully for student: ' . $user->id);

        // 5. إرجاع الرد الناجح (نفس منطق المدير)
        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح كطالب',
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    /**
     * يقوم بتسجيل خروج الطالب.
     * هذا المسار يجب أن يكون محمياً.
     */
    public function logout(Request $request)
    {
        // هذا الكود يفترض أن المسار محمي بـ 'auth:sanctum'
        // سيقوم بحذف التوكن الذي تم استخدامه لإجراء هذا الطلب
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'تم تسجيل الخروج بنجاح']);
    }
}
