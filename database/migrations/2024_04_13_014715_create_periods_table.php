<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeriodsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("periods", function (Blueprint $table) {
            $table->id();
            $table->foreignId("contest_id")->constrained()->cascadeOnDelete();
            $table->foreignId("period_type_id")->constrained();
            $table->dateTime("opened_at")->nullable();
            $table->dateTime("closed_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("periods");
    }
}
