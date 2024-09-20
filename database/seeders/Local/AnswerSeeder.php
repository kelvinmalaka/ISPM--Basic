<?php

namespace Database\Seeders\Local;

use App\Models\Team;
use App\Models\Answer;
use App\Models\AnswerDetail;
use App\Models\AnswerType;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Team::all()
            ->filter(fn (Team $team) => $team->isRegistrationVerified())
            ->each(function (Team $team) {
                Answer::factory()->count(2)
                    ->for($team)
                    ->create()
                    ->each(function (Answer $answer) {
                        $answerTypes = $answer->team->contestCategory->answerTypes;

                        $answerTypes->each(function (AnswerType $type) use ($answer) {
                            AnswerDetail::factory()
                                ->for($answer)
                                ->for($type, "type")
                                ->create();
                        });
                    });
            });
    }
}
