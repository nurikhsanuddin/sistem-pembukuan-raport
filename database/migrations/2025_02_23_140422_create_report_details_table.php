<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('report_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_card_id');
            $table->unsignedBigInteger('subject_id');
            $table->decimal('score_knowledge', 5, 2)->nullable(); // Nilai pengetahuan
            $table->decimal('score_skill', 5, 2)->nullable(); // Nilai keterampilan
            $table->timestamps();

            $table->foreign('report_card_id')
                ->references('id')
                ->on('report_cards')
                ->onDelete('cascade');

            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_details');
    }
};
