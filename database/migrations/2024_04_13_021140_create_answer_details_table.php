<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswerDetailsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("answer_details", function (Blueprint $table) {
            $table->id();
            $table->foreignId("answer_id")->constrained();
            $table->foreignId("answer_type_id")->constrained();
            $table->string("file_path", 254);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("answer_details");
    }
}
