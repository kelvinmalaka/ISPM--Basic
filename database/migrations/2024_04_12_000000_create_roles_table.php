<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("name")->unique();
            $table->string("title");
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId("current_role_id")->after("password")->nullable()->constrained("roles")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId("current_role_id");
        });

        Schema::dropIfExists('roles');
    }
}
