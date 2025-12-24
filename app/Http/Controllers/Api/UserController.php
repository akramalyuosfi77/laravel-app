<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * جلب كل المستخدمين مع الفلترة والتحميل المسبق.
     */
    public function index(Request $request)
    {
        // ابدأ ببناء الاستعلام
        $query = User::query()->with(['student.batch', 'student.specialization', 'doctor']);

        // فلترة بناءً على البحث
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // جلب النتائج مع الترتيب
        $users = $query->latest()->get();

        return response()->json($users);
    }

    /**
     * إضافة مستخدم جديد (مدير، دكتور، أو طالب).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,doctor,student',
            'is_active' => 'required|boolean',
            // حقول الطالب (اختيارية)
            'student_id_number' => 'required_if:role,student|nullable|string|unique:students,student_id_number',
            'batch_id' => 'required_if:role,student|nullable|exists:batches,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // إنشاء المستخدم الأساسي
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

        // إذا كان المستخدم طالباً، قم بإنشاء سجل الطالب
        if ($user->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'name' => $user->name, // يمكن استخدام اسم المستخدم كاسم افتراضي للطالب
                'email' => $user->email,
                'student_id_number' => $request->student_id_number,
                'batch_id' => $request->batch_id,
            ]);
        }
        // يمكنك إضافة منطق مشابه لإنشاء سجل الدكتور إذا لزم الأمر

        // تحميل العلاقات لإرجاع بيانات كاملة
        $user->load(['student.batch', 'student.specialization', 'doctor']);

        return response()->json(['message' => 'تم إضافة المستخدم بنجاح', 'user' => $user], 201);
    }

    /**
     * تحديث بيانات مستخدم موجود.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|in:admin,doctor,student',
            'is_active' => 'required|boolean',
            // حقول الطالب
            'student_id_number' => 'required_if:role,student|nullable|string|unique:students,student_id_number,' . ($user->student->id ?? 'NULL') . ',id',
            'batch_id' => 'required_if:role,student|nullable|exists:batches,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // تحديث بيانات المستخدم الأساسية
        $userData = $request->only(['name', 'email', 'role', 'is_active']);
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        $user->update($userData);

        // ✅✅✅ --- [الحل الرئيسي هنا] --- ✅✅✅
        // تحديث أو إنشاء بيانات الطالب
        if ($user->role === 'student') {
            // ابحث عن الطالب المرتبط، أو قم بإنشاء كائن جديد إذا لم يكن موجوداً
            $student = $user->student ?? new Student();

            $student->user_id = $user->id;
            $student->name = $user->name;
            $student->email = $user->email;
            $student->student_id_number = $request->student_id_number;
            $student->batch_id = $request->batch_id;
            $student->save();

        } else {
            // إذا تم تغيير دور المستخدم من طالب إلى شيء آخر، قم بحذف سجل الطالب
            if ($user->student) {
                $user->student->delete();
            }
        }

        // يمكنك إضافة منطق مشابه لتحديث بيانات الدكتور

        // تحميل العلاقات لإرجاع بيانات كاملة
        $user->load(['student.batch', 'student.specialization', 'doctor']);

        return response()->json(['message' => 'تم تحديث المستخدم بنجاح', 'user' => $user]);
    }

    /**
     * حذف مستخدم.
     */
    public function destroy(User $user)
    {
        // سيتم حذف سجلات الطالب والدكتور تلقائياً إذا قمت بتعريف
        // علاقات onCascadeDelete في ملفات الـ migration
        $user->delete();

        return response()->json(['message' => 'تم حذف المستخدم بنجاح']);
    }

    /**
     * تبديل حالة تفعيل المستخدم.
     */
    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json([
            'message' => 'تم تغيير حالة المستخدم بنجاح',
            'is_active' => $user->is_active
        ]);
    }
}
