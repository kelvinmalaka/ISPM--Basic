<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Assessment;
use App\Models\AssessmentComponent;
use App\Models\Judge;
use App\Models\PeriodType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssessmentFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assessment::class;

    /**
     * Calculate creation datetime.
     * 
     * @param  Answer     $answer
     * @return \Datetime
     */
    private function calculateCreatedAt(Answer $answer): \DateTime {
        $contest = $answer->team->contestCategory->contest;
        $assessmentPeriod = $contest->period(PeriodType::ASSESSMENT);

        return $this->faker->dateTimeBetween($assessmentPeriod->created_at, $assessmentPeriod->closed_at);
    }

    /**
     * Set judge.
     * 
     * @param  Judge    $judge
     * @return Factory
     */
    public function setJudge(Judge $judge): Factory {
        return $this->state(["judge_id" => $judge->id]);
    }

    /**
     * Set assessment component.
     * 
     * @param  Judge    $judge
     * @return Factory
     */
    public function setAssessmentComponent(AssessmentComponent $component): Factory {
        return $this->state(["assessment_component_id" => $component->id]);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $answer = Answer::all()->filter(fn(Answer $answer) => $answer->isVerified())->random();

        return [
            "answer_id" => $answer->id,
            "score" => $this->faker->numberBetween(1, 100),
            "feedback" => $this->faker->sentence,
            "created_at" => now(),
            "updated_at" => now()
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure(): Factory {
        return $this->afterMaking(function (Assessment $assessment) {
            $answer = $assessment->answer;
            $assessment->created_at = $this->calculateCreatedAt($answer);

            $assessment->save();
        });
    }
}
