<?php

namespace Database\Factories;

use App\Models\TeamMember;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamMemberFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeamMember::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $team = Team::inRandomOrder()->first();

        return [
            "team_id" => $team->id,
            "name" => $this->faker->name,
            "email" => $this->faker->safeEmail,
            "phone" => $this->faker->phoneNumber,
            "is_leader" => false,
            "national_id" => $this->faker->nik(),
            "student_id" => $this->faker->numerify("##########"),
            "national_id_file_path" => $this->faker->imageUrl(),
            "student_id_file_path" => $this->faker->imageUrl()
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure(): Factory {
        return $this->afterMaking(function (TeamMember $member) {
            $team = $member->team;

            $member->created_at = $team->created_at;
            $member->updated_at = $team->updated_at;

            $member->save();
        });
    }
}
