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
    Schema::create('locations', function (Blueprint $table) {
        $table->id();
        $table->string('name')->unique(); // اسم القاعة أو المعمل (مثال: "قاعة 9", "Lab1")
        $table->string('type')->default('hall'); // نوع المكان (hall, lab)
        $table->text('description')->nullable(); // وصف إضافي
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
