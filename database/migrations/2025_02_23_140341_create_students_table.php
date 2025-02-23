<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_no'); // Nomor induk siswa (NIS)
            $table->string('name'); // Nama lengkap siswa
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
