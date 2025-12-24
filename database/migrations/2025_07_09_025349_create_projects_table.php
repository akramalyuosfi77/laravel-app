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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // الطالب صاحب المشروع
            $table->foreignId('batch_id')->constrained('batches')->onDelete('cascade'); // الدفعة التي ينتمي إليها المشروع
            $table->foreignId('specialization_id')->constrained('specializations')->onDelete('cascade'); // التخصص الذي ينتمي إليه المشروع
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('set null'); // المادة التي ينتمي إليها المشروع
            $table->foreignId('doctor_id')->nullable()->constrained('doctors');
            $table->enum('supervision_status', ['pending', 'approved', 'rejected'])->nullable(); // مهم لكي لا يسبب مشاكل مع المشاريع التي ليس لها مشرف
            $table->string('title'); // عنوان المشروع
            $table->text('description')->nullable(); // وصف المشروع
            $table->string('status')->default('pending'); // حالة المشروع (مثال: pending, approved, rejected, completed)
            $table->integer('academic_year'); // السنة الأكاديمية للمشروع (من دفعة الطالب)
            $table->integer('semester'); // الترم للمشروع (من دفعة الطالب)
            $table->integer('grade')->nullable(); // يمكن أن تكون الدرجة عددًا صحيحًا، وnullable يعني أنها ليست إجبارية في البداية
            $table->text('feedback')->nullable(); // يمكن أن تكون الملاحظات نصًا، وnullable
            $table->timestamps();

            // فهارس لتحسين الأداء
            $table->index('student_id');
            $table->index('batch_id');
            $table->index('specialization_id');
            $table->index('status');
            $table->index('academic_year');
            $table->index('semester');
            $table->index('course_id');
            $table->index('doctor_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
