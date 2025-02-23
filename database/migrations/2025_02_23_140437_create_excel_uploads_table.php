<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('excel_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('file_name'); // Nama file Excel
            $table->dateTime('uploaded_at');
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->string('status')->nullable(); // Contoh: "sukses" atau "gagal"
            $table->timestamps();

            $table->foreign('class_id')
                ->references('id')
                ->on('classes')
                ->onDelete('set null');

            $table->foreign('semester_id')
                ->references('id')
                ->on('semesters')
                ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('excel_uploads');
    }
};
