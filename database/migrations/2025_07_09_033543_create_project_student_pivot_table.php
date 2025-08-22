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
        Schema::create('project_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->boolean('is_main_creator')->default(false); // لتحديد الطالب الرئيسي إذا لزم الأمر
            // 💡 إضافة العمود الجديد لتتبع حالة العضوية
            $table->enum('membership_status', ['pending', 'approved', 'rejected'])->default('pending')->after('student_id'); // نضعه بعد عمود student_id ليكون منظماً
            $table->timestamps();

            // ضمان عدم تكرار نفس الزوج (مشروع، طالب)
            $table->unique(['project_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_student');
    }
};
