<?php

namespace Database\Seeders\Local;

use App\Models\ContestCategory;
use App\Models\AssessmentComponent;
use App\Models\Committee;
use App\Models\Judge;
use Illuminate\Database\Seeder;

class ContestPermissionSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        ContestCategory::all()->each(function (ContestCategory $category) {
            $committees = Committee::inRandomOrder()->take(2)->get();
            $category->committees()->attach($committees);

            $category->assessmentComponents->each(function (AssessmentComponent $component) {
                $judges = Judge::inRandomOrder()->take(2)->get();
                $component->judges()->attach($judges);
            });
        });
    }
}
