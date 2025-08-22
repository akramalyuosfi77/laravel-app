<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            // إضافة عمود user_id وربطه بجدول المستخدمين
            // nullable() لأنه قد يكون هناك طلاب موجودون بالفعل بدون user_id في البداية (إذا كنت ستقوم بترحيل بيانات قديمة)
            // onDelete('cascade') يعني إذا تم حذف المستخدم، يتم حذف سجل الطالب المرتبط به تلقائيًا
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('name'); // اسم الطالب
            $table->string('student_id_number')->unique(); // رقم الطالب الجامعي (فريد)
            $table->string('email')->unique()->nullable(); // البريد الإلكتروني (اختياري وفريد)
            $table->string('phone')->nullable(); // رقم الهاتف (اختياري)
            $table->string('gender')->nullable(); // الجنس (ذكر/أنثى)
            $table->date('date_of_birth')->nullable(); // تاريخ الميلاد
            $table->string('address')->nullable(); // العنوان
            $table->string('profile_image')->nullable(); // مسار الصورة الشخصية (اختياري)

            // ربط الطالب بالدفعة التي ينتمي إليها
            $table->foreignId('batch_id')->nullable()->constrained('batches')->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->change();
            $table->foreignId('specialization_id')->nullable()->change();


            // السنة الدراسية الحالية للطالب (يمكن أن تختلف عن سنة الدفعة إذا رسب)
            $table->integer('current_academic_year')->default(1);
            // الترم الحالي للطالب (يمكن أن يختلف عن ترم الدفعة إذا رسب)
            $table->integer('current_semester')->default(1);

            // حالة الطالب (مثال: نشط، متخرج، موقوف، منسحب)
            $table->string('status')->default('نشط');

            $table->timestamps();

            // إضافة فهارس لتحسين أداء البحث والفلترة
            $table->index('batch_id');
            $table->index('current_academic_year');
            $table->index('current_semester');
            $table->index('status');

            // إضافة فهرس فريد لضمان أن كل مستخدم مرتبط بطالب واحد فقط
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
