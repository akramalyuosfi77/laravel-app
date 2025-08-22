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
        Schema::create('discussion_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion_id')->constrained('discussions')->onDelete('cascade'); // النقاش الذي ينتمي إليه الرد
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // المستخدم الذي قام بالرد (طالب أو دكتور)
            $table->text('content'); // نص الرد
            $table->timestamps();

            // فهارس لتحسين أداء الاستعلامات
            $table->index('discussion_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discussion_replies');
    }
};
