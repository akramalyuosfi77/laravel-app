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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان التكليف
            $table->text('description')->nullable(); // وصف التكليف
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // المادة التي ينتمي إليها التكليف
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // الدكتور الذي عين التكليف
            $table->dateTime('deadline'); // تاريخ ووقت التسليم النهائي
            $table->timestamps();

            // إضافة فهارس لتحسين الأداء
            $table->index('course_id');
            $table->index('doctor_id');
            $table->index('deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
