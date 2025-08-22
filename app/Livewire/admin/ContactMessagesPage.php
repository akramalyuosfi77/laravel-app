<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log; // <-- [إضافة] لتسجيل الأخطاء

class ContactMessagesPage extends Component
{
    use WithPagination;

    // --- خصائص البحث والفلاتر ---
    public $search = '';
    public $filter_subject = '';

    // --- خصائص لعرض التفاصيل والحذف ---
    public $viewedMessage = null;
    public $delete_id = null;

    /**
     * دالة updating() تُستدعى تلقائياً عند تغيير قيمة أي خاصية.
     * نستخدمها هنا لإعادة الترقيم إلى الصفحة الأولى عند البحث أو الفلترة.
     */
    public function updating($property)
    {
        if (in_array($property, ['search', 'filter_subject'])) {
            $this->resetPage();
        }
    }

    /**
     * دالة viewMessage() تقوم بجلب تفاصيل رسالة معينة لعرضها في نافذة منبثقة.
     * تم تحصينها بـ try-catch للتعامل مع حالة عدم وجود الرسالة.
     */
    public function viewMessage($id)
    {
        try {
            $this->viewedMessage = ContactMessage::findOrFail($id);
        } catch (\Exception $e) {
            Log::error('Error viewing contact message: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'لا يمكن العثور على الرسالة المطلوبة.', type: 'error');
        }
    }

    /**
     * دالة closeViewModal() تقوم بإغلاق نافذة عرض التفاصيل.
     */
    public function closeViewModal()
    {
        $this->viewedMessage = null;
    }

    /**
     * دالة confirmDelete() تقوم بتخزين ID الرسالة لفتح نافذة تأكيد الحذف.
     */
    public function confirmDelete($id)
    {
        $this->delete_id = $id;
    }

    /**
     * دالة delete() تقوم بالحذف الفعلي للرسالة.
     * تم تحصينها بـ try-catch لمعالجة الأخطاء.
     */
    public function delete()
    {
        try {
            ContactMessage::findOrFail($this->delete_id)->delete();
            $this->delete_id = null; // إخفاء نافذة التأكيد
            $this->dispatch('showToast', message: 'تم حذف الرسالة بنجاح.', type: 'success');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // هذا الخطأ يحدث إذا حاول المستخدم حذف رسالة تم حذفها بالفعل
            $this->dispatch('showToast', message: 'الرسالة غير موجودة أو تم حذفها بالفعل.', type: 'error');
        } catch (\Exception $e) {
            // لأي خطأ آخر محتمل
            Log::error('Error deleting contact message: ' . $e->getMessage());
            $this->dispatch('showToast', message: 'حدث خطأ أثناء حذف الرسالة.', type: 'error');
        }
    }

    /**
     * دالة render() هي المسؤولة عن عرض الواجهة وتمرير البيانات إليها.
     */
    public function render()
    {
        // بناء استعلام جلب الرسائل مع تطبيق الفلاتر والبحث
        $messages = ContactMessage::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('message', 'like', '%' . $this->search . '%');
            })
            ->when($this->filter_subject, function ($query) {
                $query->where('subject', $this->filter_subject);
            })
            ->latest() // عرض الأحدث أولاً
            ->paginate(10);

        return view('livewire.admin.contact-messages-page', [
            'messages' => $messages,
        ]);
    }
}
