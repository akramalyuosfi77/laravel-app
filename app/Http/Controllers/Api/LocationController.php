<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LocationController extends Controller
{
    /**
     * جلب قائمة المواقع (القاعات والمعامل)
     * GET /api/locations
     */
    public function index(Request $request)
    {
        try {
            $query = Location::query();

            if ($request->has('search')) {
                $search = $request->search;
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            }

            $locations = $query->latest()->get();

            return response()->json(['data' => $locations]);

        } catch (\Throwable $e) {
            Log::error('API Error in LocationController@index: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ في الخادم'], 500);
        }
    }

    /**
     * إضافة موقع جديد
     * POST /api/locations
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:locations,name',
            'type' => 'required|in:hall,lab',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $location = Location::create($validator->validated());

        return response()->json([
            'message' => 'تم إضافة الموقع بنجاح',
            'data' => $location
        ], 201);
    }

    /**
     * تحديث موقع
     * PUT /api/locations/{id}
     */
    public function update(Request $request, $id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'الموقع غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:locations,name,' . $id,
            'type' => 'required|in:hall,lab',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $location->update($validator->validated());

        return response()->json([
            'message' => 'تم تحديث الموقع بنجاح',
            'data' => $location
        ]);
    }

    /**
     * حذف موقع
     * DELETE /api/locations/{id}
     */
    public function destroy($id)
    {
        $location = Location::find($id);
        if (!$location) {
            return response()->json(['message' => 'الموقع غير موجود'], 404);
        }

        $location->delete();

        return response()->json(['message' => 'تم حذف الموقع بنجاح']);
    }
}
