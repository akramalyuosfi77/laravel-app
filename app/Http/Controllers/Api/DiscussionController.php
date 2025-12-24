<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discussion;
use App\Models\DiscussionReply;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class DiscussionController extends Controller
{
    /**
     * 1. جلب كل النقاشات (مع فلترة اختيارية حسب المادة)
     * GET /api/discussions?course_id={id}
     */
    public function index(Request $request)
    {
        try {
            $query = Discussion::with('student.user')->withCount('replies');

            // إذا تم إرسال course_id مع الطلب، قم بالفلترة
            if ($request->has('course_id')) {
                $query->where('course_id', $request->course_id);
            }

            $discussions = $query->latest()->get();

            return response()->json(['data' => $discussions]);

        } catch (\Throwable $e) {
            Log::error('Error in DiscussionController@index: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ في الخادم'], 500);
        }
    }

    /**
     * 2. إضافة نقاش جديد
     * POST /api/discussions
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required|integer|exists:courses,id',
            'student_id' => 'required|integer|exists:students,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $discussion = Discussion::create($validator->validated());
        $newDiscussion = Discussion::with('student.user')->withCount('replies')->find($discussion->id);

        return response()->json([
            'message' => 'تم إضافة النقاش بنجاح',
            'data' => $newDiscussion
        ], 201);
    }

    /**
     * 3. جلب نقاش واحد مع كل ردوده
     * GET /api/discussions/{id}
     */
    public function show($id)
    {
        try {
            $discussion = Discussion::with(['student.user', 'course', 'replies.user.student', 'replies.user.doctor'])->find($id);

            if (!$discussion) {
                return response()->json(['message' => 'النقاش غير موجود'], 404);
            }

            return response()->json(['data' => $discussion]);

        } catch (\Throwable $e) {
            Log::error('Error in DiscussionController@show: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطأ في الخادم'], 500);
        }
    }

    /**
     * 4. تحديث نقاش موجود
     * PUT /api/discussions/{id}
     */
    public function update(Request $request, $id)
    {
        $discussion = Discussion::find($id);
        if (!$discussion) {
            return response()->json(['message' => 'النقاش غير موجود'], 404);
        }

        // لا نسمح إلا لصاحب النقاش بتعديله (حماية إضافية)
        // if ($request->user()->student->id !== $discussion->student_id) {
        //     return response()->json(['message' => 'غير مصرح لك بتعديل هذا النقاش'], 403);
        // }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $discussion->update($validator->validated());

        return response()->json([
            'message' => 'تم تحديث النقاش بنجاح',
            'data' => $discussion
        ]);
    }

    /**
     * 5. حذف نقاش
     * DELETE /api/discussions/{id}
     */
    public function destroy($id)
    {
        $discussion = Discussion::find($id);
        if (!$discussion) {
            return response()->json(['message' => 'النقاش غير موجود'], 404);
        }

        // لا نسمح إلا لصاحب النقاش بحذفه (حماية إضافية)
        // if ($request->user()->student->id !== $discussion->student_id) {
        //     return response()->json(['message' => 'غير مصرح لك بحذف هذا النقاش'], 403);
        // }

        $discussion->delete(); // سيتم حذف الردود تلقائياً بسبب إعدادات الموديل

        return response()->json(['message' => 'تم حذف النقاش بنجاح']);
    }
}
