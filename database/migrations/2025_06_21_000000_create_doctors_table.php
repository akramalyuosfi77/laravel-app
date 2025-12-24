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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name'); // اسم الدكتور
            $table->string('email')->unique(); // البريد الإلكتروني للدكتور (يجب أن يكون فريدًا)
            $table->string('phone')->nullable(); // رقم الهاتف (اختياري)
            $table->string('profile_image')->nullable(); // مسار الصورة الشخصية (اختياري)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
