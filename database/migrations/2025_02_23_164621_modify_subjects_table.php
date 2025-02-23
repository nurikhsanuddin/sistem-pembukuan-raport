<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('subjects', function (Blueprint $table) {
            // Drop existing category column
            $table->dropColumn('category');
            // Add new categories column as JSON
            $table->json('categories')->nullable();
        });
    }

    public function down()
    {
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropColumn('categories');
            $table->string('category')->nullable();
        });
    }
};
