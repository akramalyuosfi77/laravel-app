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
        Schema::create('submission_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->onDelete('cascade'); // التسليم الذي ينتمي إليه الملف
            $table->string('file_path'); // مسار الملف في التخزين
            $table->string('file_name')->nullable(); // اسم الملف الأصلي
            $table->string('file_type')->nullable(); // نوع الملف (مثال: image, video, document, presentation)
            $table->text('description')->nullable(); // وصف للملف (اختياري)
            $table->timestamps();

            // إضافة فهارس لتحسين الأداء
            $table->index('file_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submission_files');
    }
};
