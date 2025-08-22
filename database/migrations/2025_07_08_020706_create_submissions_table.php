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
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade'); // التكليف الذي تم تسليمه
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // الطالب الذي قام بالتسليم
            $table->string('title')->nullable(); // عنوان التسليم (اختياري، قد يكون نفس عنوان التكليف)
            $table->text('description')->nullable(); // وصف التسليم من الطالب
            $table->string('status')->default('pending'); // حالة التسليم (مثال: pending, submitted, graded, rejected)
            $table->integer('grade')->nullable(); // الدرجة (إذا تم تقييمه)
            $table->text('feedback')->nullable(); // ملاحظات الدكتور على التسليم
            $table->timestamps();

            // إضافة فهرس فريد لضمان أن الطالب يسلم مرة واحدة فقط لكل تكليف
            $table->unique(['assignment_id', 'student_id']);

            // إضافة فهارس لتحسين الأداء
            $table->index('status');
            $table->index('grade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
