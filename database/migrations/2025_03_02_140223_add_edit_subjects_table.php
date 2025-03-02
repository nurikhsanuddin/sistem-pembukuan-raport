<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->text('pengetahuan_A')->nullable()->after('description');
            $table->text('pengetahuan_B')->nullable();
            $table->text('pengetahuan_C')->nullable();
            $table->text('pengetahuan_D')->nullable();

            $table->text('keterampilan_A')->nullable()->after('pengetahuan_D');
            $table->text('keterampilan_B')->nullable();
            $table->text('keterampilan_C')->nullable();
            $table->text('keterampilan_D')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('pengetahuan_A');
            $table->dropColumn('pengetahuan_B');
            $table->dropColumn('pengetahuan_C');
            $table->dropColumn('pengetahuan_D');

            $table->dropColumn('keterampilan_A');
            $table->dropColumn('keterampilan_B');
            $table->dropColumn('keterampilan_C');
            $table->dropColumn('keterampilan_D');
        });
    }
};
