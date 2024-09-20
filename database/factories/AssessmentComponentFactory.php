<?php

namespace Database\Factories;

use App\Models\AssessmentComponent;
use App\Models\ContestCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssessmentComponentFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AssessmentComponent::class;

    /**
     * Set count to calculate weight.
     * 
     * @param  int  $count
     * @return Factory
     */
    public function setCount(int $count): Factory {
        $weight = 100 / $count;

        return $this
            ->count($count)
            ->state(["weight" => $weight]);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $category = ContestCategory::inRandomOrder()->first();

        return [
            "contest_category_id" => $category->id,
            "name" => $this->faker->domainWord,
            "description" => $this->faker->sentence,
            "weight" => 1
        ];
    }
}
