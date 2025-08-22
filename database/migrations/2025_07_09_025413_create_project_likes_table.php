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
        Schema::create('project_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); // المشروع الذي تم الإعجاب به
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // المستخدم الذي قام بالإعجاب (طالب، دكتور، مدير)
            $table->timestamps();

            // ضمان أن المستخدم لا يمكنه الإعجاب بنفس المشروع أكثر من مرة
            $table->unique(['project_id', 'user_id']);

            // فهارس لتحسين الأداء
            $table->index('project_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_likes');
    }
};
