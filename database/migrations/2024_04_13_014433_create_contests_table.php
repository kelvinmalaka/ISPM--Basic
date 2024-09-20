<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("contests", function (Blueprint $table) {
            $table->id();
            $table->foreignId("administrator_id")->constrained();
            $table->string("title", 200);
            $table->text("description");
            $table->string("guide_file_path", 254)->nullable();
            $table->string("banner_img_path", 254)->nullable();
            $table->timestamp("published_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("contests");
    }
}
