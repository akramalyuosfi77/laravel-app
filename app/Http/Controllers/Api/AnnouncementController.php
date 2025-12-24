<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Course;
use App\Models\User; // ◀️ استيراد موديل المستخدم
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AnnouncementController extends Controller
{
    /**
     * 1. جلب كل الإعلانات
     */
    public function index()
    {
        try {
            $announcements = Announcement::with('user')->latest()->get();

            $formattedAnnouncements = $announcements->map(function ($announcement) {

                $targetName = null;
                if ($announcement->target_id) {
                    switch ($announcement->target_type) {
                        case 'department':
                            $targetName = Department::find($announcement->target_id)?->name;
                            break;
                        case 'specialization':
                            $targetName = Specialization::find($announcement->target_id)?->name;
                            break;
                        case 'course':
                            $targetName = Course::find($announcement->target_id)?->name;
                            break;
                    }
                }

                return [
                    'id' => $announcement->id,
                    'title' => $announcement->title,
                    'content' => $announcement->content,
                    'level' => $announcement->level,
                    'target_type' => $announcement->target_type,
                    'target_id' => $announcement->target_id,
                    'target_name' => $targetName,
                    // ✅✅✅ --- [التصحيح الرئيسي هنا] --- ✅✅✅
                    // التأكد من وجود مستخدم قبل محاولة الوصول إلى اسمه
                    'author' => $announcement->user ? $announcement->user->name : 'مستخدم محذوف',
                    'created_at' => $announcement->created_at->format('Y/m/d'),
                    'expires_at' => $announcement->expires_at ? $announcement->expires_at->format('Y/m/d') : null,
                ];
            });

            return response()->json($formattedAnnouncements);

        } catch (\Throwable $e) {
            Log::error('Error in AnnouncementController@index: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ في الخادم'], 500);
        }
    }

    /**
     * 2. إضافة إعلان جديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'level' => 'required|in:info,success,warning,danger',
            'expires_at' => 'nullable|date',
            'target_type' => 'required|string',
            'target_id' => 'nullable|integer|required_if:target_type,department,specialization,course',
            'user_id' => 'required|integer|exists:users,id' // ◀️ نتوقع الآن user_id من التطبيق
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $announcement = Announcement::create($validator->validated());

        return response()->json([
            'message' => 'تم إضافة الإعلان بنجاح',
            'announcement' => $announcement
        ], 201);
    }

    /**
     * 3. تحديث إعلان موجود
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return response()->json(['message' => 'الإعلان غير موجود'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'level' => 'required|in:info,success,warning,danger',
            'expires_at' => 'nullable|date',
            'target_type' => 'required|string',
            'target_id' => 'nullable|integer|required_if:target_type,department,specialization,course',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $announcement->update($validator->validated());

        return response()->json([
            'message' => 'تم تحديث الإعلان بنجاح',
            'announcement' => $announcement
        ]);
    }

    /**
     * 4. حذف إعلان
     */
    public function destroy($id)
    {
        $announcement = Announcement::find($id);
        if (!$announcement) {
            return response()->json(['message' => 'الإعلان غير موجود'], 404);
        }

        $announcement->delete();

        return response()->json(['message' => 'تم حذف الإعلان بنجاح']);
    }
}
