<?php

namespace Database\Factories;

use App\Models\PeriodType;
use App\Models\Team;
use App\Models\Registration;
use App\Models\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Illuminate\Support\Carbon;

class RegistrationFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Registration::class;

    /**
     * Calculate creation datetime.
     * 
     * @param  Team     $team
     * @return \Datetime
     */
    private function calculateCreatedAt(Team $team): \DateTime {
        $contest = $team->contestCategory->contest;
        $registrationPeriod = $contest->period(PeriodType::REGISTRATION);

        return $this->faker->dateTimeBetween($team->created_at, $registrationPeriod->closed_at);
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $team = Team::inRandomOrder()->first();
        $status = RegistrationStatus::inRandomOrder()->first();

        return [
            "team_id" => $team->id,
            "registration_status_id" => $status->id,
            "description" => $this->faker->sentence,
            "created_at" => now()
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure(): Factory {
        return $this->afterMaking(function (Registration $registration) {
            $team = $registration->team;
            $committee = $team->contestCategory->committees()->inRandomOrder()->take(1)->first();

            $registration->created_at = $this->calculateCreatedAt($team);

            $registration->committee()->associate($committee);
            $registration->save();
        });
    }
}
