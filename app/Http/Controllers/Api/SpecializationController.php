<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpecializationController extends Controller
{
    /**
     * 1. جلب كل التخصصات مع الفلترة والبحث
     */
    public function index(Request $request)
    {
        $specializations = Specialization::with('department') // مهم لجلب اسم القسم
            ->when($request->search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhereHas('department', fn($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15);

        // إرجاع البيانات مباشرة كما هي
        return response()->json($specializations);
    }

    /**
     * 2. إضافة تخصص جديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:specializations,name',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'duration' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $specialization = Specialization::create($validator->validated());

        // إرجاع رسالة نجاح مع بيانات التخصص الجديد
        return response()->json([
            'message' => 'تم إضافة التخصص بنجاح',
            'specialization' => $specialization->load('department') // تحميل بيانات القسم معه
        ], 201);
    }

    /**
     * 3. جلب تخصص واحد
     */
    public function show($id)
    {
        $specialization = Specialization::with('department')->find($id);

        if (!$specialization) {
            return response()->json(['message' => 'التخصص غير موجود'], 404);
        }

        return response()->json($specialization);
    }

    /**
     * 4. تحديث تخصص موجود
     */
    public function update(Request $request, $id)
    {
        $specialization = Specialization::find($id);
        if (!$specialization) {
            return response()->json(['message' => 'التخصص غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:specializations,name,' . $id,
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'duration' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $specialization->update($validator->validated());

        return response()->json([
            'message' => 'تم تحديث التخصص بنجاح',
            'specialization' => $specialization->load('department') // تحميل بيانات القسم المحدثة
        ]);
    }

    /**
     * 5. حذف تخصص
     */
    public function destroy($id)
    {
        $specialization = Specialization::find($id);
        if (!$specialization) {
            return response()->json(['message' => 'التخصص غير موجود'], 404);
        }

        // يمكنك إضافة منطق التحقق هنا
        if ($specialization->batches()->exists()) {
            return response()->json(['message' => 'لا يمكن حذف التخصص لأنه مرتبط بدفعات طلاب.'], 409);
        }

        $specialization->delete();

        return response()->json(['message' => 'تم حذف التخصص بنجاح']);
    }
}
