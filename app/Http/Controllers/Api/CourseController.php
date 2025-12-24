<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\SpecializationCourseAcademicPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * عرض قائمة المواد مع العلاقات والفلترة.
     */
    public function index(Request $request)
    {
        $query = Course::query()
            ->with([
                'specializationCourseAcademicPeriods.specialization.department',
                'specializationCourseAcademicPeriods.doctor'
            ]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%')
                  ->orWhereHas('specializationCourseAcademicPeriods.specialization', fn($sq) => $sq->where('name', 'like', '%' . $search . '%'))
                  ->orWhereHas('specializationCourseAcademicPeriods.doctor', fn($dq) => $dq->where('name', 'like', '%' . $search . '%'));
            });
        }

        if ($request->filled('department_id')) {
            $query->whereHas('specializationCourseAcademicPeriods.specialization.department', fn($q) => $q->where('id', $request->input('department_id')));
        }
        if ($request->filled('specialization_id')) {
            $query->whereHas('specializationCourseAcademicPeriods', fn($q) => $q->where('specialization_id', $request->input('specialization_id')));
        }
        if ($request->filled('academic_year')) {
            $query->whereHas('specializationCourseAcademicPeriods', fn($q) => $q->where('academic_year', $request->input('academic_year')));
        }
        if ($request->filled('semester')) {
            $query->whereHas('specializationCourseAcademicPeriods', fn($q) => $q->where('semester', $request->input('semester')));
        }

        $courses = $query->latest()->get();

        return response()->json($courses);
    }

    /**
     * ✅✅✅ --- دالة الإضافة الجديدة --- ✅✅✅
     * تخزين مادة جديدة في قاعدة البيانات.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:courses,code',
            'type' => 'required|string|in:نظرى,عملى',
            'academic_year' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:2',
            'specialization_id' => 'required|exists:specializations,id',
            'description' => 'nullable|string',
            'doctor_id' => 'nullable|exists:doctors,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData) {
                $course = Course::create([
                    'name' => $validatedData['name'],
                    'code' => $validatedData['code'],
                    'type' => $validatedData['type'],
                    'description' => $validatedData['description'],
                ]);

                SpecializationCourseAcademicPeriod::create([
                    'course_id' => $course->id,
                    'specialization_id' => $validatedData['specialization_id'],
                    'academic_year' => $validatedData['academic_year'],
                    'semester' => $validatedData['semester'],
                    'doctor_id' => $validatedData['doctor_id'],
                ]);
            });

            return response()->json(['message' => 'تم إضافة المادة بنجاح'], 201);

        } catch (\Exception $e) {
            Log::error('Error storing course: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء حفظ المادة.'], 500);
        }
    }

    /**
     * ✅✅✅ --- دالة التعديل الجديدة --- ✅✅✅
     * تحديث بيانات مادة موجودة.
     */
    public function update(Request $request, Course $course)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:255', Rule::unique('courses')->ignore($course->id)],
            'type' => 'required|string|in:نظرى,عملى',
            'academic_year' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:2',
            'specialization_id' => 'required|exists:specializations,id',
            'description' => 'nullable|string',
            'doctor_id' => 'nullable|exists:doctors,id',
        ]);

        try {
            DB::transaction(function () use ($validatedData, $course) {
                $course->update([
                    'name' => $validatedData['name'],
                    'code' => $validatedData['code'],
                    'type' => $validatedData['type'],
                    'description' => $validatedData['description'],
                ]);

                // تحديث أو إنشاء السجل في الجدول الوسيط
                SpecializationCourseAcademicPeriod::updateOrCreate(
                    ['course_id' => $course->id], // البحث بناءً على المادة
                    [
                        'specialization_id' => $validatedData['specialization_id'],
                        'academic_year' => $validatedData['academic_year'],
                        'semester' => $validatedData['semester'],
                        'doctor_id' => $validatedData['doctor_id'],
                    ]
                );
            });

            return response()->json(['message' => 'تم تحديث المادة بنجاح']);

        } catch (\Exception $e) {
            Log::error('Error updating course: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء تحديث المادة.'], 500);
        }
    }

    /**
     * ✅✅✅ --- دالة الحذف الجديدة --- ✅✅✅
     * حذف مادة من قاعدة البيانات.
     */
    public function destroy(Course $course)
    {
        try {
            // بفضل onDelete('cascade') في الـ migration،
            // سيتم حذف السجلات المرتبطة في الجدول الوسيط تلقائياً.
            $course->delete();
            return response()->json(['message' => 'تم حذف المادة بنجاح']);
        } catch (\Exception $e) {
            Log::error('Error deleting course: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ أثناء حذف المادة.'], 500);
        }
    }
}
