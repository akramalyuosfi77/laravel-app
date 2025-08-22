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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الدفعة (مثال: دفعة 2025)
            $table->integer('start_year'); // السنة التي بدأت فيها الدفعة
            $table->foreignId('specialization_id')->constrained()->onDelete('cascade'); // مفتاح خارجي للتخصص

            // إضافة الحقول الجديدة لتتبع السنة والترم الحالي للدفعة
            $table->integer('current_academic_year')->default(1); // السنة الدراسية الحالية للدفعة (تبدأ من 1)
            $table->integer('current_semester')->default(1);     // الترم الحالي للدفعة (تبدأ من 1)

            $table->timestamps();

            // إضافة فهارس لتحسين أداء البحث والفلترة
            $table->index('start_year');
            $table->index('specialization_id');
            $table->index('current_academic_year'); // فهرس جديد
            $table->index('current_semester');     // فهرس جديد
            $table->integer('academic_year')->nullable(); // أو بدون nullable حسب حاجتك
            $table->integer('semester')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
