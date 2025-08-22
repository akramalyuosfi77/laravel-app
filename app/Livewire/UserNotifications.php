<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UserNotifications extends Component
{
    // 💡 خاصية لتخزين عدد الإشعارات غير المقروءة
    public $unreadNotificationsCount;

    // 💡 خاصية لتخزين الإشعارات التي سيتم عرضها في القائمة
    public $notifications;

    /**
     * دالة mount تُنفذ مرة واحدة عند تحميل المكون لأول مرة.
     * نستخدمها لجلب البيانات الأولية.
     */
    public function mount()
    {
        $this->loadNotifications();
    }

    /**
     * دالة مخصصة لجلب الإشعارات وتحديث العدد.
     * يمكننا استدعاؤها في أي وقت لتحديث البيانات.
     */
    public function loadNotifications()
    {
        // نتأكد من وجود مستخدم مسجل دخوله
        if (Auth::check()) {
            $user = Auth::user();
            // جلب آخر 10 إشعارات (يمكنك تغيير العدد)
            $this->notifications = $user->notifications()->take(10)->get();
            // جلب عدد الإشعارات غير المقروءة فقط
            $this->unreadNotificationsCount = $user->unreadNotifications->count();
        } else {
            // إذا لم يكن هناك مستخدم، نجعل كل شيء فارغًا
            $this->notifications = collect();
            $this->unreadNotificationsCount = 0;
        }
    }
 /**
     * دالة لتمييز إشعار معين كمقروء وتوجيه المستخدم.
     * سيتم استدعاؤها عند الضغط على إشعار في القائمة.
     * @param string $notificationId
     */
    public function markAsRead(string $notificationId)
    {
        if (Auth::check()) {
            $notification = Auth::user()->notifications()->find($notificationId);

            if ($notification) {
                // الخطوة 1: تمييز الإشعار كمقروء
                $notification->markAsRead();

                // 💡 الخطوة 2 (الجديدة والمهمة): التحقق من وجود رابط وتوجيه المستخدم
                if (isset($notification->data['url'])) {
                    // استخدام redirect() لتوجيه المستخدم إلى الرابط المحدد
                    return $this->redirect($notification->data['url'], navigate: true);
                }
            }
            // في حال عدم وجود رابط، فقط قم بتحديث قائمة الإشعارات
            $this->loadNotifications();
        }
    }

    /**
     * دالة لتمييز جميع الإشعارات كمقروءة.
     * سيتم استدعاؤها عند الضغط على زر "تمييز الكل كمقروء".
     */
    public function markAllAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            // إعادة تحميل الإشعارات بعد التغيير لتحديث الواجهة
            $this->loadNotifications();
        }
    }

    /**
     * دالة render هي المسؤولة عن عرض الواجهة.
     * 💡 سنضيف wire:poll هنا لجعل المكون يقوم بتحديث نفسه تلقائيًا.
     * سيقوم باستدعاء دالة loadNotifications() كل 15 ثانية.
     */
    public function render()
    {
        // استدعاء دالة loadNotifications قبل عرض الواجهة لضمان أن البيانات محدثة
        // هذا مفيد بشكل خاص مع wire:poll
        $this->loadNotifications();

        return view('livewire.user-notifications');
    }
}

// **شرح بسيط للكود:**
// *   `mount()`: تجهز البيانات عند أول تحميل.
// *   `loadNotifications()`: هي دالتنا الرئيسية لجلب البيانات.
// *   `markAsRead()` و `markAllAsRead()`: هما الدالتان اللتان ستتفاعلان مع المستخدم.
// *   `render()`: تعرض الواجهة وتستخدم `wire:poll` (سنضيفها في ملف الـ view) لتظل حية ومحدثة.

// بعد استبدال الكود، تكون قد أنجزت الخطوة السادسة. أصبح لدينا الآن "عقل" المكون جاهزاً.

// **الخطوة التالية هي تصميم "جسم" المكون، أي الواجهة التي سيراها المستخدم. هل أنت مستعد للخطوة 7؟**
