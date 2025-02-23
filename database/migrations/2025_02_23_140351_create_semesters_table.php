<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            $table->id();
            $table->integer('number'); // Nomor semester (1 s/d 6)
            $table->string('description')->nullable(); // Deskripsi (opsional)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('semesters');
    }
};
