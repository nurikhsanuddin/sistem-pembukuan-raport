<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHomeroomTeacherIdToClasses extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only add the column if it doesn't exist yet
        if (!Schema::hasColumn('classes', 'homeroom_teacher_id')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->unsignedBigInteger('homeroom_teacher_id')->nullable();
                $table->foreign('homeroom_teacher_id')
                    ->references('id')
                    ->on('homeroom_teachers')
                    ->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only remove the column if it exists
        if (Schema::hasColumn('classes', 'homeroom_teacher_id')) {
            Schema::table('classes', function (Blueprint $table) {
                $table->dropForeign(['homeroom_teacher_id']);
                $table->dropColumn('homeroom_teacher_id');
            });
        }
    }
}
