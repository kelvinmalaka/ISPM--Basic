<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId("team_id")->constrained();
            $table->foreignId("committee_id")->nullable()->constrained();
            $table->foreignId("registration_status_id")->constrained();
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
        Schema::dropIfExists('registrations');
    }
}
