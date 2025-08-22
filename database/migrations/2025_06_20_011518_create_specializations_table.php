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
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم التخصص
            $table->text('description')->nullable(); // وصف التخصص
            $table->string('duration')->nullable(); // تم إضافة هذا السطر: مدة التخصص
            $table->foreignId('department_id')->constrained()->onDelete('cascade'); // مفتاح خارجي للقسم
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specializations');
    }
};

