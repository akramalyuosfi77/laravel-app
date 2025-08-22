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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade'); // ربط المحاضرة بالمادة
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade'); // ربط المحاضرة بالدكتور
            $table->string('title'); // عنوان المحاضرة
            $table->text('description')->nullable(); // وصف المحاضرة
            $table->date('lecture_date')->nullable(); // تاريخ المحاضرة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
