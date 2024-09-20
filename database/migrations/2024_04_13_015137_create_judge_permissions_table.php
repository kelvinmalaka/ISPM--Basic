<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJudgePermissionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("judge_permissions", function (Blueprint $table) {
            $table->foreignId("judge_id")->constrained()->cascadeOnDelete();
            $table->foreignId("assessment_component_id")->constrained()->cascadeOnDelete();
            $table->primary(["judge_id", "assessment_component_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("judge_permissions");
    }
}
