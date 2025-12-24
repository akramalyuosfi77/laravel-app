<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // ◀️ الخطوة 1: استيراد موديل User

class NotificationController extends Controller
{
    /**
     * [GET] جلب جميع إشعارات المدير الحالي.
     */
  public function index()
{

    /** @var \App\Models\User $admin */
    $admin = Auth::user();

        $notifications = $admin->notifications()->paginate(20);
        return response()->json($notifications);
    }

    /**
     * [POST] تحديد جميع الإشعارات غير المقروءة للمدير على أنها مقروءة.
     */
    public function store()
    {
        /** @var \App\Models\User $admin */ // ◀️ توضيح نوع المتغير
        $admin = Auth::user();

        $admin->unreadNotifications->markAsRead();
        return response()->json(['message' => 'تم تحديد جميع الإشعارات كمقروءة بنجاح.']);
    }

    /**
     * [DELETE] حذف جميع إشعارات المدير.
     */
    public function destroy()
    {
        /** @var \App\Models\User $admin */ // ◀️ توضيح نوع المتغير
        $admin = Auth::user();

        $admin->notifications()->delete();
        return response()->json(['message' => 'تم حذف جميع الإشعارات بنجاح.']);
    }
}
