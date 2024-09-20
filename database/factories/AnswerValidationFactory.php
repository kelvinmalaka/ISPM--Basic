<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\AnswerValidation;
use App\Models\AnswerStatus;
use App\Models\PeriodType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerValidationFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnswerValidation::class;

    /**
     * Calculate creation datetime.
     * 
     * @param  Answer     $answer
     * @return \Datetime
     */
    private function calculateCreatedAt(Answer $answer): \DateTime {
        $contest = $answer->team->category->contest;
        $validationPeriod = $contest->period(PeriodType::ANSWER_VALIDATION);

        return $this->faker->dateTimeBetween($validationPeriod->created_at, $validationPeriod->closed_at);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $answer = Answer::inRandomOrder()->first();
        $status = AnswerStatus::inRandomOrder()->first();

        return [
            "answer_id" => $answer->id,
            "answer_status_id" => $status->id,
            "description" => $this->faker->sentence,
            "created_at" => now()
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure(): Factory {
        return $this->afterMaking(function (AnswerValidation $validation) {
            $answer = $validation->answer;
            $committee = $answer->team->category->committees()->inRandomOrder()->take(1)->first();

            $validation->created_at = $this->calculateCreatedAt($answer);

            $validation->committee()->associate($committee);
            $validation->save();
        });
    }
}
