<?php

namespace Database\Seeders\Local;

use App\Models\AnswerValidation;
use App\Models\Team;
use Illuminate\Database\Seeder;

class AnswerValidationSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Team::query()
            ->whereHas("answers")
            ->get()
            ->each(function (Team $team) {
                $answer = $team->answers()->latest()->limit(1)->first();
                AnswerValidation::factory()->for($answer)->create();
            });
    }
}
