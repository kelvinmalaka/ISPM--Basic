<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerValidationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('answer_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("answer_id")->constrained();
            $table->foreignId("committee_id")->constrained();
            $table->foreignId("answer_status_id")->constrained();
            $table->text("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('answer_validations');
    }
}
