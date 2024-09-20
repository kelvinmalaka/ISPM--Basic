<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestCategoriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("contest_categories", function (Blueprint $table) {
            $table->id();
            $table->foreignId("contest_id")->constrained()->cascadeOnDelete();
            $table->string("title", 100);
            $table->text("description");
            $table->unsignedInteger("max_team_member");
            $table->unsignedInteger("max_answer_uploads");
            $table->string("guide_file_path", 254)->nullable();
            $table->string("case_file_path", 254)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("contest_categories");
    }
}
