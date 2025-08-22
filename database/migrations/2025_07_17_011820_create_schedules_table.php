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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();

        // الربط مع جدول الخطة الدراسية (العقل المدبر)
        $table->foreignId('specialization_course_academic_period_id')
              ->constrained('specialization_course_academic_period')
              ->onDelete('cascade');

        // الربط مع جدول القاعات
        $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');

        // تفاصيل الزمان
        $table->enum('day_of_week', ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday']);
        $table->time('start_time');
        $table->time('end_time');

        $table->timestamps();

        // فهرس لضمان عدم حجز نفس القاعة في نفس الوقت ونفس اليوم
        $table->unique(['location_id', 'day_of_week', 'start_time']);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
