<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentComponentsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('assessment_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId("contest_category_id")->constrained()->cascadeOnDelete();
            $table->string("name", 100);
            $table->text("description");
            $table->tinyInteger("weight")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('assessment_components');
    }
}
