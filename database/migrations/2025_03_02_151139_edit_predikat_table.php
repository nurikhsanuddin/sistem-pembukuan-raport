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
        // remove the column 'nilai' from the 'predikats' table and change with nilai_min and nilai_max
        Schema::table('predikats', function (Blueprint $table) {
            $table->dropColumn('nilai');
            $table->integer('nilai_min')->after('predikat');
            $table->integer('nilai_max')->after('nilai_min');
            //deskripsi
            $table->text('deskripsi')->after('nilai_max');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('predikats', function (Blueprint $table) {
            $table->integer('nilai')->after('predikat');
            $table->dropColumn('nilai_min');
            $table->dropColumn('nilai_max');
            $table->dropColumn('deskripsi');
        });
    }
};
