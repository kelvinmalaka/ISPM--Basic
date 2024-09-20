<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamMembersTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("team_members", function (Blueprint $table) {
            $table->id();
            $table->foreignId("team_id")->constrained();
            $table->string("name", 100);
            $table->string("email");
            $table->string("phone");
            $table->boolean("is_leader")->default(false);
            $table->string("national_id");
            $table->string("student_id");
            $table->string("national_id_file_path");
            $table->string("student_id_file_path");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("team_members");
    }
}
