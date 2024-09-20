<?php

namespace Database\Seeders\Local;

use App\Models\Answer;
use App\Models\Assessment;
use App\Models\AssessmentComponent;
use App\Models\Judge;
use Illuminate\Database\Seeder;

class AssessmentSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Answer::all()
            ->filter(fn(Answer $answer) => $answer->isVerified())
            ->each(function (Answer $answer) {
                $components = $answer->team->contestCategory->assessmentComponents;

                $components->each(function (AssessmentComponent $component) use ($answer) {

                    $component->judges->each(function (Judge $judge) use ($answer, $component) {
                        Assessment::factory()
                            ->for($answer)
                            ->setJudge($judge)
                            ->setAssessmentComponent($component)
                            ->create();
                    });
                });
            });
    }
}
