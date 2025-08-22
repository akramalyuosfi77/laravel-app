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
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); // المشروع الذي ينتمي إليه الملف
            $table->string('file_path'); // مسار الملف في التخزين
            $table->string('file_name'); // اسم الملف الأصلي
            $table->string('file_type'); // نوع الملف (mime type)
            $table->unsignedBigInteger('file_size'); // حجم الملف بالبايت
            $table->text('description')->nullable(); // وصف للملف (مثلاً: وصف للصورة، أو ملخص للفيديو)
            $table->enum('type', ['image', 'video', 'presentation', 'document', 'other']); // نوع الملف (لتصنيف أسهل)
            $table->timestamps();

            // فهارس لتحسين الأداء
            $table->index('project_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_files');
    }
};
