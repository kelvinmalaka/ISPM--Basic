<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Answer;
use App\Models\AnswerDetail;
use Illuminate\Http\UploadedFile;

class AnswerDetailFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnswerDetail::class;

    /**
     * Construct file path.
     * 
     * @return string
     */
    private function constructFilePath(): string {
        return UploadedFile::fake()
            ->create("dummyanswer.pdf", 300, "application/pdf")
            ->store("seeders/comtest/answers");
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $answer = Answer::inRandomOrder()->first();
        $type = $answer->team->contestCategory->answerTypes()->inRandomOrder()->first();

        return [
            "answer_id" => $answer->id,
            "answer_type_id" => $type->id,
            "file_path" => $this->constructFilePath(),
        ];
    }
}
