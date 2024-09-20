<?php

namespace Database\Factories;

use App\Models\Period;
use App\Models\PeriodType;
use App\Models\Contest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Carbon;

class PeriodFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Period::class;

    /**
     * Generate all type of periods.
     *
     * @return Factory
     */
    public function all(): Factory {
        $periodTypesCount = PeriodType::all()->count();

        return $this
            ->count($periodTypesCount)
            ->sequence(function (Sequence $sequence) use ($periodTypesCount) {
                $type = $sequence->index % $periodTypesCount + 1;
                return ["period_type_id" => $type];
            });
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() {
        $contest = Contest::inRandomOrder()->first();
        $periodType = PeriodType::inRandomOrder()->first();

        return [
            "contest_id" => $contest->id,
            "period_type_id" => $periodType->id,
            "opened_at" => now(),
            "closed_at" => now()
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return Factory
     */
    public function configure(): Factory {
        return $this->afterCreating(function (Period $period) {
            $contest = $period->contest;
            $periodTypeId = $period->period_type_id;

            if ($periodTypeId === 1) {
                $startDate = $contest->published_at;
            } else {
                $periodBefore = $contest->periods()->where("period_type_id", $periodTypeId - 1)->first();
                $startDate = $periodBefore->closed_at;
            }

            $startDate = Carbon::parse($startDate);
            $periodDays = rand(10, 15);
            $openedAt = $startDate->toImmutable()->addDay()->setTime(0, 0, 0);
            $closedAt = $openedAt->toImmutable()->addDays($periodDays)->setTime(23, 59, 59);

            $period->opened_at = $openedAt;
            $period->closed_at = $closedAt;

            $period->save();
        });
    }
}
