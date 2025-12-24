<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/contact-messages",
     *      operationId="getContactMessages",
     *      tags={"Contact Messages"},
     *      summary="Get list of contact messages",
     *      description="Returns a paginated list of contact messages, with filtering and searching capabilities.",
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          description="Search term for name, email, or message content.",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="subject",
     *          in="query",
     *          description="Filter messages by subject.",
     *          required=false,
     *          @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page number for pagination.",
     *          required=false,
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="data", type="object", ref="#/components/schemas/ContactMessage"),
     *              @OA\Property(property="message", type="string", example="Messages retrieved successfully.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     * )
     */
    public function index(Request $request)
    {
        try {
            // استلام متغيرات البحث والفلترة من الـ Request
            $search = $request->query('search');
            $subject = $request->query('subject');

            // بناء الاستعلام بنفس الطريقة السابقة
            $messages = ContactMessage::query()
                ->when($search, function ($query, $search) {
                    $query->where('name', 'like', '%' . $search . '%')
                          ->orWhere('email', 'like', '%' . $search . '%')
                          ->orWhere('message', 'like', '%' . $search . '%');
                })
                ->when($subject, function ($query, $subject) {
                    $query->where('subject', $subject);
                })
                ->latest() // عرض الأحدث أولاً
                ->paginate(10); // ترقيم الصفحات (يمكن تغيير الرقم 10)

            // إرجاع استجابة JSON ناجحة تحتوي على البيانات
            return response()->json([
                'success' => true,
                'data' => $messages,
                'message' => 'تم جلب الرسائل بنجاح.'
            ], 200);

        } catch (\Exception $e) {
            // في حالة حدوث أي خطأ غير متوقع
            Log::error('API Error fetching contact messages: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في الخادم أثناء جلب البيانات.'
            ], 500); // 500 Internal Server Error
        }
    }

    // يمكنك إضافة دوال أخرى هنا مثل show, store, destroy بنفس الطريقة
    // مثال لدالة الحذف:
    public function destroy($id)
    {
        try {
            $message = ContactMessage::findOrFail($id);
            $message->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الرسالة بنجاح.'
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'الرسالة غير موجودة.'
            ], 404); // 404 Not Found
        } catch (\Exception $e) {
            Log::error('API Error deleting contact message: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الرسالة.'
            ], 500);
        }
    }
}
