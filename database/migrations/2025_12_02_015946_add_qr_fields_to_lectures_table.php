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
        Schema::table('lectures', function (Blueprint $table) {
            // QR Token للمحاضرة (فريد)
            $table->string('qr_token')->nullable()->unique()->after('lecture_date');
            
            // تاريخ انتهاء صلاحية QR
            $table->dateTime('qr_expires_at')->nullable()->after('qr_token');
            
            // تفعيل/تعطيل تسجيل الحضور
            $table->boolean('attendance_enabled')->default(false)->after('qr_expires_at');
            
            // إضافة index للبحث السريع
            $table->index('qr_token');
            $table->index('attendance_enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lectures', function (Blueprint $table) {
            $table->dropIndex(['qr_token']);
            $table->dropIndex(['attendance_enabled']);
            $table->dropColumn(['qr_token', 'qr_expires_at', 'attendance_enabled']);
        });
    }
};
