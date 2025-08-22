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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // من أنشأ الإعلان

            $table->string('title');
            $table->text('content');

            // مستوى الأهمية (لتلوين الإعلان)
            $table->enum('level', ['info', 'success', 'warning', 'danger'])->default('info');

            // الجمهور المستهدف
            $table->enum('target_type', [
                'global_all',       // للجميع
                'global_students',  // لجميع الطلاب
                'global_doctors',   // لجميع الدكاترة
                'department',       // لقسم معين
                'specialization',   // لتخصص معين
                'course'            // لمادة معينة
            ]);

            // معرّف الهدف (إذا كان الإعلان يستهدف قسماً أو تخصصاً أو مادة)
            $table->unsignedBigInteger('target_id')->nullable();

            $table->timestamp('expires_at')->nullable(); // تاريخ انتهاء صلاحية الإعلان
            $table->timestamps();

            // فهارس لتحسين أداء الاستعلامات
            $table->index('target_type');
            $table->index('target_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
