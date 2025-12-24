<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class MobileAuthController extends Controller
{
    /**
     * جلب معلومات الدفعة عند مسح الباركود
     */
    public function getBatchInfo($batchId)
    {
        $batch = Batch::with(['specialization.department'])->find($batchId);

        if (!$batch) {
            return response()->json([
                'status'  => false,
                'message' => 'الدفعة غير موجودة أو الرابط غير صالح'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => [
                'id'                => $batch->id,
                'name'              => $batch->name,
                'specialization'    => $batch->specialization->name,
                'department'        => $batch->specialization->department->name,
                'current_year'      => $batch->current_academic_year,
                'current_semester'  => $batch->current_semester,
            ]
        ]);
    }

    /**
     * تسجيل طالب جديد والانضمام للدفعة (عبر التطبيق)
     */
    public function registerWithBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_id'           => 'required|exists:batches,id',
            'name'               => 'required|string|max:255',
            'email'              => 'required|string|email|max:255|unique:users,email',
            'student_id_number'  => 'required|string|max:255|unique:students,student_id_number',
            'password'           => 'required|string|min:8',
        ], [
            'name.required'               => 'حقل الاسم مطلوب.',
            'email.required'              => 'حقل البريد الإلكتروني مطلوب.',
            'email.email'                 => 'الرجاء إدخال بريد إلكتروني صالح.',
            'email.unique'                => 'هذا البريد مسجل بالفعل.',
            'student_id_number.required'  => 'حقل الرقم الجامعي مطلوب.',
            'student_id_number.unique'    => 'هذا الرقم الجامعي مسجل بالفعل.',
            'password.required'           => 'حقل كلمة المرور مطلوب.',
            'password.min'                => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($request) {
                $batch = Batch::with('specialization.department')->find($request->batch_id);

                // 1. إنشاء المستخدم (✅ مفعّل تلقائياً)
                $user = User::create([
                    'name'      => $request->name,
                    'email'     => $request->email,
                    'password'  => Hash::make($request->password),
                    'role'      => 'student',
                    'is_active' => true, // ✅ الحساب مفعّل تلقائياً
                ]);

                // 2. إنشاء ملف الطالب (✅ مع كل البيانات من الدفعة)
                $student = Student::create([
                    'user_id'               => $user->id,
                    'name'                  => $request->name,
                    'student_id_number'     => $request->student_id_number,
                    'email'                 => $request->email,
                    'batch_id'              => $batch->id,
                    'specialization_id'     => $batch->specialization_id, // ✅ إضافة التخصص
                    'current_academic_year' => $batch->current_academic_year ?? 1,
                    'current_semester'      => $batch->current_semester ?? 1,
                    'status'                => 'نشط', // ✅ الحالة نشطة تلقائياً
                ]);

                // 3. إنشاء توكن للدخول المباشر
                $token = $user->createToken('mobile-app-token')->plainTextToken;

                // 4. إرجاع البيانات مع معلومات الدفعة الكاملة
                return [
                    'user'    => $user,
                    'student' => $student->load('batch.specialization.department'),
                    'token'   => $token,
                    'batch'   => [
                        'id'             => $batch->id,
                        'name'           => $batch->name,
                        'specialization' => $batch->specialization->name,
                        'department'     => $batch->specialization->department->name,
                    ],
                ];
            });

            return response()->json([
                'status'  => true,
                'message' => 'تم التسجيل والتفعيل بنجاح ✅',
                'data'    => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ غير متوقع أثناء التسجيل',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🆕 تسجيل طالب جديد عبر Google OAuth + مسح الباركود
     * التدفق: مسح باركود → Google OAuth → إدخال الرقم الأكاديمي + كلمة المرور → تسجيل ودخول فوري
     */
    public function registerWithGoogleAndBatch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_id'           => 'required|exists:batches,id',
            'google_id'          => 'required|string',
            'google_name'        => 'required|string|max:255',
            'google_email'       => 'required|string|email|max:255',
            'student_id_number'  => 'required|string|max:255|unique:students,student_id_number',
            'password'           => 'required|string|min:8',
        ], [
            'batch_id.required'           => 'معلومات الدفعة مفقودة (امسح الباركود مرة أخرى).',
            'google_id.required'          => 'حساب Google غير صالح.',
            'google_name.required'        => 'لم نتمكن من جلب الاسم من Google.',
            'google_email.required'       => 'لم نتمكن من جلب البريد من Google.',
            'student_id_number.required'  => 'حقل الرقم الأكاديمي مطلوب.',
            'student_id_number.unique'    => 'هذا الرقم الأكاديمي مسجل بالفعل.',
            'password.required'           => 'حقل كلمة المرور مطلوب.',
            'password.min'                => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            $result = DB::transaction(function () use ($request) {
                $batch = Batch::with('specialization.department')->find($request->batch_id);

                // التحقق من وجود المستخدم بنفس البريد
                $existingUser = User::where('email', $request->google_email)->first();
                
                if ($existingUser) {
                    // إذا كان موجود، نرجع خطأ (أو يمكن تسجيل الدخول مباشرة)
                    throw new \Exception('هذا البريد الإلكتروني مسجل بالفعل. يرجى تسجيل الدخول.');
                }

                // 1. إنشاء المستخدم (✅ مفعّل تلقائياً + ربط Google)
                $user = User::create([
                    'name'      => $request->google_name,
                    'email'     => $request->google_email,
                    'password'  => Hash::make($request->password),
                    'role'      => 'student',
                    'is_active' => true,
                ]);

                // 2. إنشاء ملف الطالب (✅ مع كل البيانات من الدفعة)
                $student = Student::create([
                    'user_id'               => $user->id,
                    'name'                  => $request->google_name,
                    'student_id_number'     => $request->student_id_number,
                    'email'                 => $request->google_email,
                    'batch_id'              => $batch->id,
                    'specialization_id'     => $batch->specialization_id,
                    'current_academic_year' => $batch->current_academic_year ?? 1,
                    'current_semester'      => $batch->current_semester ?? 1,
                    'status'                => 'نشط',
                ]);

                // 3. إنشاء توكن للدخول المباشر
                $token = $user->createToken('mobile-app-token')->plainTextToken;

                // 4. إرجاع البيانات مع معلومات الدفعة الكاملة
                return [
                    'user'    => $user,
                    'student' => $student->load('batch.specialization.department'),
                    'token'   => $token,
                    'batch'   => [
                        'id'             => $batch->id,
                        'name'           => $batch->name,
                        'specialization' => $batch->specialization->name,
                        'department'     => $batch->specialization->department->name,
                    ],
                ];
            });

            return response()->json([
                'status'  => true,
                'message' => '🎉 مرحباً بك! تم التسجيل والدخول بنجاح',
                'data'    => $result
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * تسجيل الدخول للطالب (باستخدام البريد + كلمة المرور)
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required'    => 'البريد الإلكتروني مطلوب.',
            'email.email'       => 'الرجاء إدخال بريد إلكتروني صالح.',
            'password.required' => 'كلمة المرور مطلوبة.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
            ], 401);
        }

        if ($user->role !== 'student') {
            return response()->json([
                'status'  => false,
                'message' => 'هذا الحساب غير مصرح له بالدخول من التطبيق.',
            ], 403);
        }

        // حذف التوكنات القديمة وإنشاء توكن جديد
        $user->tokens()->delete();
        $token = $user->createToken('mobile-app-token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'data'    => [
                'token'   => $token,
                'user'    => $user,
                'student' => $user->student,
            ],
        ]);
    }

    /**
     * جلب بيانات الطالب الحالي (باستخدام التوكن - بدون middleware)
     */
    public function getStudentInfo(Request $request)
    {
        // 🔐 التحقق من التوكن يدوياً (بدون middleware)
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json([
                'status'  => false,
                'message' => 'غير مصدق عليه - لم يتم إرسال التوكن',
            ], 401);
        }

        // البحث عن التوكن في قاعدة البيانات
        $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
        
        if (!$accessToken) {
            return response()->json([
                'status'  => false,
                'message' => 'التوكن غير صالح أو منتهي الصلاحية',
            ], 401);
        }

        // جلب المستخدم من التوكن
        $user = $accessToken->tokenable;
        
        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'المستخدم غير موجود',
            ], 404);
        }

        $student = $user->student;
        if (!$student) {
            return response()->json([
                'status'  => false,
                'message' => 'لا توجد بيانات طالب',
            ], 404);
        }

        // جلب معلومات الدفعة مع التخصص والقسم
        $batch = $student->batch()->with(['specialization.department'])->first();

        if (!$batch || !$batch->specialization || !$batch->specialization->department) {
            return response()->json([
                'status'  => false,
                'message' => 'بيانات الدفعة غير مكتملة',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => [
                'user'    => $user,
                'student' => [
                    'id'                => $student->id,
                    'name'              => $student->name,
                    'email'             => $student->email,
                    'student_id_number' => $student->student_id_number,
                ],
                'batch'   => [
                    'id'               => $batch->id,
                    'name'             => $batch->name,
                    'specialization'   => $batch->specialization->name,
                    'department'       => $batch->specialization->department->name,
                    'current_year'     => $batch->current_academic_year,
                    'current_semester' => $batch->current_semester,
                ],
            ],
        ]);
    }
}