<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\DB;

echo "=== فحص وإصلاح بيانات الدكاترة ===\n\n";

// 1. فحص جدول الدكاترة الحالي
$doctorsCount = Doctor::count();
echo "عدد الدكاترة في جدول 'doctors' حالياً: " . $doctorsCount . "\n";

// 2. فحص المستخدمين بصلاحية 'doctor'
$doctorUsers = User::where('role', 'doctor')->get();
echo "عدد المستخدمين بصلاحية 'doctor' في جدول 'users': " . $doctorUsers->count() . "\n\n";

if ($doctorUsers->count() > 0) {
    echo "جاري التحقق من المزامنة...\n";
    $syncedCount = 0;
    
    foreach ($doctorUsers as $user) {
        // هل هذا المستخدم موجود في جدول الدكاترة؟
        $exists = Doctor::where('user_id', $user->id)->exists();
        
        if (!$exists) {
            echo " - تم العثور على مستخدم دكتور غير مسجل (ID: {$user->id}, Name: {$user->name})... ";
            
            // إنشاء سجل جديد في جدول الدكاترة
            Doctor::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => null, // يمكن تحديثه لاحقاً
            ]);
            
            echo "تمت إضافته بنجاح! ✅\n";
            $syncedCount++;
        } else {
            // echo " - المستخدم (ID: {$user->id}) موجود بالفعل.\n";
        }
    }
    
    if ($syncedCount > 0) {
        echo "\nتم إصلاح وإضافة $syncedCount دكتور إلى القائمة! 🎉\n";
        echo "الآن يجب أن يظهروا في القائمة المنسدلة.\n";
    } else {
        echo "\nجميع دكاترة النظام متزامنون بشكل صحيح. 👍\n";
        if ($doctorsCount == 0) {
             echo "تنبيه: لا يوجد دكاترة في النظام أصلاً! قم بإضافة مستخدم جديد بصلاحية 'doctor'.\n";
        }
    }
    
} else {
    echo "لا يوجد أي مستخدم بصلاحية 'doctor' في جدول المستخدمين!\n";
}
