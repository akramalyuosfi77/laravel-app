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
        Schema::create('discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // المادة التي يرتبط بها النقاش
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade'); // الطالب الذي بدأ النقاش
            $table->string('title'); // عنوان النقاش/السؤال
            $table->text('content'); // المحتوى الكامل للسؤال
            $table->enum('status', ['open', 'closed', 'resolved'])->default('open'); // حالة النقاش
            $table->unsignedBigInteger('best_reply_id')->nullable(); // معرّف أفضل إجابة (اختياري)
            $table->timestamps();

            // فهارس لتحسين أداء الاستعلامات
            $table->index('course_id');
            $table->index('student_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussions');
    }
};
