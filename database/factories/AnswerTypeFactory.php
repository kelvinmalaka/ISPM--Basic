<?php

namespace Database\Factories;

use App\Models\AnswerType;
use App\Models\ContestCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerTypeFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnswerType::class;

    /**
     * The name of the factory's corresponding model.
     *
     * @param  int
     * @return int
     */
    private function convertMbToKb(int $mb) {
        $mbToKb = 1024;
        return $mb * $mbToKb;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $category = ContestCategory::inRandomOrder()->first();
        $sizeOf1Mb = $this->convertMbtoKb(1);
        $sizeOf5Mb = $this->convertMbtoKb(5);

        return [
            "contest_category_id" => $category->id,
            "name" => $this->faker->domainWord,
            "description" => $this->faker->sentence,
            "file_type" => $this->faker->randomElement(AnswerType::VAILD_FILE_TYPES),
            "max_size" => $this->faker->numberBetween($sizeOf1Mb, $sizeOf5Mb)
        ];
    }
}
