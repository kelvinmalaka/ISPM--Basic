<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Administrator;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Http\UploadedFile;

class ContestFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contest::class;

    /**
     * Set contest administrator.
     * 
     * @param  Administrator    $administrator
     * @return Factory
     */
    public function setAdministrator(Administrator $administrator): Factory {
        return $this->state(["administrator_id" => $administrator->id]);
    }

    /**
     * Set contest title.
     * 
     * @param  string   $title
     * @return Factory
     */
    public function setTitle(string $title): Factory {
        return $this->state(["title" => $title]);
    }

    /**
     * Set contest description.
     * 
     * @param  string   $description
     * @return Factory
     */
    public function setDescription(string $description): Factory {
        return $this->state(["description" => $description]);
    }

    /**
     * Set contest guide file path.
     * 
     * @param  string   $filePath
     * @return Factory
     */
    public function setGuideFilePath(string $filePath): Factory {
        return $this->state(["guide_file_path" => $filePath]);
    }

    /**
     * Set contest banner image path.
     * 
     * @param  string   $filePath
     * @return Factory
     */
    public function setBannerImagePath(string $imgPath): Factory {
        return $this->state(["banner_img_path" => $imgPath]);
    }

    /**
     * Set contest published datetime.
     * 
     * @param  \DateTime   $publishedAt
     * @return Factory
     */
    public function setPublishedAt(\DateTime $publishedAt): Factory {
        $publishedAt = Carbon::parse($publishedAt);
        $createdAt = $this->calculateCreatedAt($publishedAt);

        return $this->state([
            "published_at" => $publishedAt,
            "created_at" => $createdAt,
            "updated_at" => $createdAt
        ]);
    }

    /**
     * Construct guide file path.
     * 
     * @param  Contest  $contest
     * @return string
     */
    private function constructGuideFilePath(Contest $contest): string {
        $id = $contest->id;
        $title = $contest->title;

        return UploadedFile::fake()
            ->create($title . ".pdf", 300, "application/pdf")
            ->storeAs("seeders/contest/" . $id, $title . "_guide.pdf");
    }

    /**
     * Construct contest creation datetime based on published datetime.
     * 
     * @param  \DateTime   $publishedAt
     * @return Carbon
     */
    private function calculateCreatedAt(\DateTime $publishedAt): Carbon {
        return Carbon::parse($publishedAt)
            ->subMonths(rand(2, 4))
            ->subDays(rand(5, 10));
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array {
        $administrator = Administrator::inRandomOrder()->first();
        $contest = $this->faker->unique()->contest;
        $title = $contest["title"];
        $description = $contest["description"];
        $bannerImagePath = $this->faker->imageUrl();
        $publishedAt = Carbon::now()->subMonths(rand(1, 3));
        $createdAt = $this->calculateCreatedAt($publishedAt);

        return [
            "administrator_id" => $administrator->id,
            "title" => $title,
            "description" => $description,
            "guide_file_path" => null,
            "banner_img_path" => $bannerImagePath,
            "published_at" => $publishedAt,
            "created_at" => $createdAt,
            "updated_at" => $createdAt
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure(): Factory {
        return $this->afterCreating(function (Contest $contest) {
            $contest->guide_file_path = $this->constructGuideFilePath($contest);
            $contest->save();
        });
    }
}
