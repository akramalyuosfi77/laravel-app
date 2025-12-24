<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BatchController extends Controller
{
    /**
     * 1. جلب كل الدفعات (Read)
     * GET /api/batches
     */
    public function index()
    {
        // استخدام with لتحميل العلاقات مسبقاً (Eager Loading)
        $batches = Batch::with(['specialization.department'])->latest()->get();
        return response()->json($batches);
    }

    /**
     * عرض تفاصيل دفعة واحدة مع كل البيانات المرتبطة بها.
     * GET /api/batches/{batch}
     */
    public function show(Batch $batch)
    {
        // ✅✅✅ --- [الاستدعاء السحري والنهائي هنا] --- ✅✅✅
        // هذا الاستدعاء سيقوم بتحميل كل شيء نحتاجه
        $batch->load([
            'specialization.department', // 1. التخصص والقسم
            'students.user',             // 2. الطلاب وبيانات المستخدم الخاصة بهم
            'courses' => function ($query) {
                // 3. المواد، ومع كل مادة، قم بتحميل الدكاترة المرتبطين بها
                $query->with('doctors');
            }
        ]);

        return response()->json([
            'success' => true,
            'data'    => $batch,
        ]);
    }

    /**
     * 2. إضافة دفعة جديدة (Create)
     * POST /api/batches
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2100',
            'specialization_id' => 'required|exists:specializations,id',
            'academic_year' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:2',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $batch = Batch::create($validator->validated());

        // تحميل العلاقات بعد الإنشاء لإرجاع بيانات كاملة
        $batch->load(['specialization.department']);

        return response()->json([
            'message' => 'تم إضافة الدفعة بنجاح',
            'batch' => $batch
        ], 201);
    }

    /**
     * 3. تحديث دفعة موجودة (Update)
     * PUT /api/batches/{id}
     */
    public function update(Request $request, $id)
    {
        $batch = Batch::find($id);
        if (!$batch) {
            return response()->json(['message' => 'الدفعة غير موجودة'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'start_year' => 'required|integer|min:1900|max:2100',
            'specialization_id' => 'required|exists:specializations,id',
            'academic_year' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:2',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $batch->update($validator->validated());

        // تحميل العلاقات بعد التحديث لإرجاع بيانات كاملة
        $batch->load(['specialization.department']);

        return response()->json([
            'message' => 'تم تحديث الدفعة بنجاح',
            'batch' => $batch
        ]);
    }

    /**
     * 4. حذف دفعة (Delete)
     * DELETE /api/batches/{id}
     */
    public function destroy($id)
    {
        $batch = Batch::find($id);
        if (!$batch) {
            return response()->json(['message' => 'الدفعة غير موجودة'], 404);
        }

        $batch->delete();

        return response()->json(['message' => 'تم حذف الدفعة بنجاح']);
    }
}
