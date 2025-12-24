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
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'supervision_status')) {
                // 💡 هذا هو العمود الذي سيحل المشكلة
                // سيتم إضافته بعد عمود doctor_id ليكون الكود منظماً
                $table->enum('supervision_status', ['pending', 'approved', 'rejected'])
                      ->nullable() // مهم لكي لا يسبب مشاكل مع المشاريع التي ليس لها مشرف
                      ->after('doctor_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // هذا الكود سيحذف العمود إذا أردنا التراجع عن الهجرة
            $table->dropColumn('supervision_status');
        });
    }
};
