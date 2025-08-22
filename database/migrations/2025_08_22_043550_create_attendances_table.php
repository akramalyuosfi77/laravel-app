<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            // 1. الربط مع جدول المحاضرات
            // إذا حُذفت المحاضرة، يتم حذف سجلات الحضور المرتبطة بها
            $table->foreignId('lecture_id')->constrained('lectures')->onDelete('cascade');

            // 2. الربط مع جدول الطلاب
            // إذا حُذف الطالب، يتم حذف سجلات حضوره
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            // 3. حالة الحضور
            // enum لتقييد القيم المدخلة وتحسين الأداء
            $table->enum('status', ['present', 'absent', 'excused_absence'])->default('absent');

            // 4. ملاحظات إضافية (اختياري)
            // لتسجيل سبب الغياب بعذر مثلاً
            $table->text('notes')->nullable();

            $table->timestamps();

            // فهرس فريد لمنع تسجيل حضور نفس الطالب في نفس المحاضرة أكثر من مرة
            $table->unique(['lecture_id', 'student_id']);

            // فهارس إضافية لتحسين أداء الاستعلامات والتقارير
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
