<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Contestant;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\Contest;
use App\Models\ContestCategory;
use App\Models\PeriodType;

class TeamFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Get unique contestant in a contest.
     * 
     * @param  Contest  $contest
     * @return Contestant
     */
    public function getUniqueContestant(Contest $contest): Contestant {
        $registeredContestant = $contest->teams()->get()->pluck("contestant_id");
        $contestant = Contestant::whereNotIn("id", $registeredContestant)->inRandomOrder()->limit(1)->first();

        return $contestant;
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $category = ContestCategory::inRandomOrder()->limit(1)->first();

        return [
            "contest_category_id" => $category->id,
            "name" => "Tim " . $this->faker->company,
            "university" => "Universitas " . $this->faker->company,
            "overall_score" => 0,
            "created_at" => now(),
            "updated_at" => now()
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure() {
        return $this
            ->afterMaking(function (Team $team) {
                $category = $team->contestCategory;
                $contest = $category->contest;

                $contestant = $this->getUniqueContestant($contest);

                $registrationPeriod = $contest->period(PeriodType::REGISTRATION);
                $registeredAt = $this->faker->dateTimeBetween($registrationPeriod->opened_at, $registrationPeriod->closed_at);

                $team->contestant_id = $contestant->id;
                $team->created_at = $registeredAt;
                $team->updated_at = $registeredAt;

                $team->save();
            })
            ->afterCreating(function (Team $team) {
                $member = $team->members()->inRandomOrder()->take(1)->first();

                $member->is_leader = true;
                $member->save();
            });
    }
}
