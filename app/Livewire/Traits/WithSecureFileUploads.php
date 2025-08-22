<?php

namespace App\Livewire\Traits;

use Illuminate\Validation\Rules\File;

trait WithSecureFileUploads
{
    /**
     * [مُصحَّح ومُبسَّط]
     * يُنشئ قاعدة تحقق آمنة للملفات باستخدام كلاس File المدمج في لارافيل.
     *
     * @param int $maxSizeInKb الحجم الأقصى للملف بالكيلوبايت.
     * @return \Illuminate\Validation\Rules\File
     */
    protected function secureFileUploadRules(int $maxSizeInKb = 2048): File
    {
        // نستخدم كلاس File لأنه الطريقة الأحدث والأكثر أماناً للتحقق من الملفات
        return File::types(['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'mp4', 'mov', 'avi', 'zip', 'rar'])
                    ->max($maxSizeInKb);
    }
}
