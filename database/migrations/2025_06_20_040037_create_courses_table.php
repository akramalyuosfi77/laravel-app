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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المادة
            $table->string('code')->unique(); // رمز المادة (يجب أن يكون فريدًا)
            $table->string('type'); // نوع المادة (مثال: عملي او نظري)
            $table->integer('academic_year'); // السنة الدراسية (مثال: 1، 2، 3)
            $table->integer('semester'); // الترم (مثال: 1، 2)
            $table->foreignId('specialization_id')->constrained()->onDelete('cascade'); // مفتاح خارجي للتخصص
            $table->text('description')->nullable(); // وصف المادة (اختياري)
            $table->boolean('student_replies_enabled')->default(true);
            $table->timestamps();


            // إضافة فهارس لتحسين أداء البحث والفلترة
            $table->index('specialization_id')->nullable()->change();
            $table->index('academic_year')->nullable()->change();
            $table->index('semester')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

