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
        Schema::create('lecture_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lecture_id')->constrained('lectures')->onDelete('cascade'); // ربط الملف بالمحاضرة
            $table->string('file_path'); // مسار الملف في التخزين
            $table->string('file_name'); // اسم الملف الأصلي
            $table->string('file_type'); // نوع الملف (MIME type)
            $table->unsignedBigInteger('file_size'); // حجم الملف بالبايت
            $table->string('type'); // نوع المحتوى (pdf, presentation, video, image, other)
            $table->text('description')->nullable(); // وصف قصير للملف
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_files');
    }
};
