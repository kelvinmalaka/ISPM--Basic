<?php

namespace App\Http\Controllers\Contestant;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\PeriodType;
use Illuminate\Support\Facades\Gate;

class ScoreController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contestant_score";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contestant.score";

    /**
     * Display a listing of the resource.
     *
     * @param  Contest  $contest
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Contest $contest) {
        $team = $contest->getContestantTeam();

        Gate::allowIf(fn () => !is_null($team));
        Gate::allowIf(fn () => $contest->period(PeriodType::ANNOUNCEMENT)->isActive());
        Gate::allowIf(fn () => $team->hasVerifiedAnswer());

        $team->load("answer.assessments.judge");

        return view(self::viewPath . ".index")
            ->with("contest", $contest)
            ->with("team", $team);
    }
}
