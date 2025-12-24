<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * 1. جلب كل الأقسام (Read)
     * GET /api/departments
     */
    public function index()
    {
        $departments = Department::latest()->get();
        return response()->json($departments);
    }

    /**
     * 2. إضافة قسم جديد (Create)
     * POST /api/departments
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments,name',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department = Department::create($validator->validated());

        return response()->json([
            'message' => 'تم إضافة القسم بنجاح',
            'department' => $department
        ], 201);
    }

    /**
     * 3. جلب قسم واحد (للتعديل مثلاً)
     * GET /api/departments/{id}
     */
    public function show($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'القسم غير موجود'], 404);
        }
        return response()->json($department);
    }

    /**
     * 4. تحديث قسم موجود (Update)
     * PUT /api/departments/{id}
     */
    public function update(Request $request, $id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'القسم غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:departments,name,' . $id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department->update($validator->validated());

        return response()->json([
            'message' => 'تم تحديث القسم بنجاح',
            'department' => $department
        ]);
    }

    /**
     * 5. حذف قسم (Delete)
     * DELETE /api/departments/{id}
     */
    public function destroy($id)
    {
        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'القسم غير موجود'], 404);
        }

        $department->delete();

        return response()->json(['message' => 'تم حذف القسم بنجاح']);
    }
}
