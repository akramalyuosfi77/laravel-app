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
        Schema::table('users', function (Blueprint $table) {
            // ▼▼▼ السطر الذي سنضيفه ▼▼▼
            // نضيف حقل نصي طويل لتخزين التوكن، ونجعله قابلاً لأن يكون فارغاً (nullable)
            $table->text('fcm_token')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ▼▼▼ السطر الذي سنضيفه ▼▼▼
            // هذا يخبر لارافيل كيف يقوم بحذف الحقل إذا أردنا التراجع عن الـ migration
            $table->dropColumn('fcm_token');
        });
    }
};
