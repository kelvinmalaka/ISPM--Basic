<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AnswerType;

class CreateAnswerTypesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('answer_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId("contest_category_id")->constrained()->cascadeOnDelete();
            $table->string("name", 100);
            $table->text("description");
            $table->enum("file_type", AnswerType::VAILD_FILE_TYPES);
            $table->integer("max_size")->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('answer_types');
    }
}
