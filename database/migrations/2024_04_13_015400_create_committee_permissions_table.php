<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommitteePermissionsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create("committee_permissions", function (Blueprint $table) {
            $table->foreignId("contest_category_id")->constrained()->cascadeOnDelete();
            $table->foreignId("committee_id")->constrained()->cascadeOnDelete();
            $table->primary(["committee_id", "contest_category_id"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists("committee_permissions");
    }
}
