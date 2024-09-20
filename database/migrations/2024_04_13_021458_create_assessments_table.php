<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("assessments", function (Blueprint $table) {
            $table->foreignId("judge_id")->constrained();
            $table->foreignId("answer_id")->constrained();
            $table->foreignId("assessment_component_id")->constrained();
            $table->text("feedback");
            $table->unsignedInteger("score");
            $table->timestamps();
            $table->primary(["judge_id", "answer_id", "assessment_component_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("assessments");
    }
}
