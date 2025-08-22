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
        Schema::create('specialization_course_academic_period', function (Blueprint $table) {
            $table->id();

            // مفتاح خارجي للتخصص
            $table->foreignId('specialization_id')->constrained('specializations')->onDelete('cascade');

            // مفتاح خارجي للمادة
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');

            // السنة الدراسية التي تُعطى فيها المادة لهذا التخصص
            $table->integer('academic_year');

            // الترم الذي تُعطى فيه المادة لهذه السنة والتخصص
            $table->integer('semester');

            $table->timestamps();

            // إضافة فهرس فريد لضمان عدم تكرار نفس المادة في نفس التخصص والسنة والترم
            $table->unique(['specialization_id', 'course_id', 'academic_year', 'semester'], 'unique_course_period');

            // إضافة فهارس لتحسين أداء الاستعلامات
            $table->index('academic_year');
            $table->index('semester');

                        // إضافة المفتاح الخارجي لـ doctor_id
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            // جعلها nullable لأن المادة قد لا يكون لها دكتور معين في البداية
            // onDelete('set null') يعني إذا تم حذف الدكتور، يتم تعيين doctor_id في هذا الجدول إلى NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialization_course_academic_period');
    }
};
