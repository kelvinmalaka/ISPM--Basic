<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\PeriodType;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Calculate creation datetime.
     * 
     * @param  Team     $team
     * @return \Datetime
     */
    private function calculateCreatedAt(Team $team): \DateTime {
        $contest = $team->contestCategory->contest;
        $submissionPeriod = $contest->period(PeriodType::SUBMISSION);

        return $this->faker->dateTimeBetween($submissionPeriod->opened_at, $submissionPeriod->closed_at);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $team = Team::inRandomOrder()->first();

        return [
            "team_id" => $team->id,
            "created_at" => now(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure(): Factory {
        return $this->afterMaking(function (Answer $answer) {
            $answer->created_at = $this->calculateCreatedAt($answer->team);
            $answer->save();
        });
    }
}
