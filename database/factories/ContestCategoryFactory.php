<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\ContestCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;

class ContestCategoryFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContestCategory::class;

    /**
     * Get unique category for each contest.
     * 
     * @param  Contest  $contest
     * @return array
     */
    private function getUniqueCategory(Contest $contest): array {
        $existedCategories = $contest->categories()->get()->pluck("title");
        $category = $this->faker->contestCategoryExcepts($existedCategories);

        return $category;
    }

    /**
     * Construct guide file path.
     * 
     * @param  ContestCategory  $category
     * @return string
     */
    private function constructGuideFilePath(ContestCategory $category): string {
        $contestId = $category->contest->id;
        $title = $category->title;

        return UploadedFile::fake()
            ->create($title . ".pdf", 300, "application/pdf")
            ->storeAs("seeders/contest/" . $contestId . "/categories", $title . "_guide.pdf");
    }

    /**
     * Construct case file path.
     * 
     * @param  ContestCategory  $category
     * @return string
     */
    private function constructCaseFilePath(ContestCategory $category): string {
        $contestId = $category->contest->id;
        $title = $category->title;

        return UploadedFile::fake()
            ->create($title . ".pdf", 300, "application/pdf")
            ->storeAs("seeders/contest/" . $contestId . "/categories", $title . "_case.pdf");
    }

    /**
     * Construct category creation datetime based on contest.
     * 
     * @param  Contest   $contest
     * @return Carbon
     */
    private function calculateCreatedAt(Contest $contest): Carbon {
        return Carbon::parse($contest->published_at)->addHours(2);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $contest = Contest::inRandomOrder()->first();

        return [
            "contest_id" => $contest->id,
            "title" => "",
            "description" => "",
            "guide_file_path" => null,
            "case_file_path" => null,
            "max_team_member" => $this->faker->numberBetween(2, 5),
            "max_answer_uploads" => $this->faker->numberBetween(2, 10)
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure() {
        return $this->afterMaking(function (ContestCategory $category) {
            $contest = $category->contest;
            $fakeCategory =  $this->getUniqueCategory($contest);

            $title = $fakeCategory["title"];
            $description = $fakeCategory["description"];
            $category->title = $title;
            $category->description = $description;

            $guideFilePath = $this->constructGuideFilePath($category);
            $caseFilePath = $this->constructCaseFilePath($category);
            $category->guide_file_path = $guideFilePath;
            $category->case_file_path = $caseFilePath;

            $createdAt = $this->calculateCreatedAt($contest);
            $category->created_at = $createdAt;
            $category->updated_at = $createdAt;

            $category->save();
        });
    }
}
