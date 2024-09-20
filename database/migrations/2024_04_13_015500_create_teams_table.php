<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("teams", function (Blueprint $table) {
            $table->id();
            $table->foreignId("contestant_id")->constrained();
            $table->foreignId("contest_category_id")->constrained();
            $table->string("name", 254);
            $table->string("university", 100);
            $table->decimal("overall_score", 5, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("teams");
    }
}
