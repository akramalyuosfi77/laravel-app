<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AssignmentController extends Controller
{
    /**
     * دالة index: عرض قائمة بجميع التكليفات مع دعم الفلاتر والبحث.
     */
    public function index(Request $request)
    {
        // نبدأ ببناء الاستعلام مع جلب العلاقات لتحسين الأداء (Eager Loading)
        $query = Assignment::with(['course', 'doctor']);

        // 1. فلتر البحث
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('course', fn($cq) => $cq->where('name', 'like', '%' . $search . '%'))
                  ->orWhereHas('doctor', fn($dq) => $dq->where('name', 'like', '%' . $search . '%'));
            });
        }

        // 2. فلتر حسب المادة
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->input('course_id'));
        }

        // 3. فلتر حسب الدكتور
        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->input('doctor_id'));
        }

        // جلب النتائج مرتبة حسب الأحدث
        $assignments = $query->latest()->get();

        // إرجاع النتائج كـ JSON
        return response()->json($assignments);
    }

    /**
     * دالة store: تخزين تكليف جديد في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'doctor_id' => 'required|exists:doctors,id',
            'deadline' => 'required|date',
        ]);

        try {
            // إنشاء التكليف الجديد
            $assignment = Assignment::create($validatedData);
            // إرجاع التكليف الجديد مع رسالة نجاح
            return response()->json($assignment, 201);
        } catch (\Exception $e) {
            Log::error('Error storing assignment: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء حفظ التكليف.'], 500);
        }
    }

    /**
     * دالة show: عرض بيانات تكليف واحد محدد.
     */
    public function show(Assignment $assignment)
    {
        // إرجاع التكليف مع علاقاته
        return response()->json($assignment->load(['course', 'doctor']));
    }

    /**
     * دالة update: تحديث بيانات تكليف موجود.
     */
    public function update(Request $request, Assignment $assignment)
    {
        // التحقق من صحة البيانات المدخلة
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'course_id' => 'required|exists:courses,id',
            'doctor_id' => 'required|exists:doctors,id',
            'deadline' => 'required|date',
        ]);

        try {
            // تحديث بيانات التكليف
            $assignment->update($validatedData);
            // إرجاع التكليف المحدث
            return response()->json($assignment);
        } catch (\Exception $e) {
            Log::error('Error updating assignment: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء تحديث التكليف.'], 500);
        }
    }

    /**
     * دالة destroy: حذف تكليف من قاعدة البيانات.
     */
    public function destroy(Assignment $assignment)
    {
        try {
            $assignment->delete();
            // إرجاع رسالة نجاح مع رمز 204 (No Content)
            return response()->json(['message' => 'تم حذف التكليف بنجاح'], 200);
        } catch (\Exception $e) {
            Log::error('Error deleting assignment: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء حذف التكليف.'], 500);
        }
    }
}
