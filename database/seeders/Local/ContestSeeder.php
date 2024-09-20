<?php

namespace Database\Seeders\Local;

use Illuminate\Database\Seeder;
use App\Models\Contest;
use App\Models\Period;
use App\Models\PeriodType;
use App\Models\ContestCategory;
use App\Models\AnswerType;
use App\Models\AssessmentComponent;

class ContestSeeder extends Seeder {
    /**
     * Run the contest seeds.
     *
     * @return void
     */
    public function run(): void {
        $periods = Period::factory()->all();
        $categories = ContestCategory::factory()->count(3)
            ->has(AssessmentComponent::factory()->setCount(2))
            ->has(AnswerType::factory()->count(2));

        Contest::factory()
            ->count(4)
            ->has($periods)
            ->has($categories, "categories")
            ->create();
    }
}
