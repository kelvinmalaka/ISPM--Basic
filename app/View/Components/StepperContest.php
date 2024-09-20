<?php

namespace App\View\Components;

use App\Http\Controllers\Contestant\AnswerController;
use App\Http\Controllers\Contestant\ScoreController;
use App\Http\Controllers\Contestant\TeamController;
use App\Models\Contest;
use App\Models\PeriodType;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class StepperContest extends Component {
    /**
     * Store contests.
     *
     * @var array
     */
    public $contest;

    /**
     * Available steps.
     *
     * @var array
     */
    public $steps = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Contest $contest, string $activeStep) {
        $this->contest = $contest;
        $contest->load("periods");

        $team = $contest->getContestantTeam();
        $user = auth()->user();

        $this->addStep([
            "icon" => "person",
            "title" => "Registration",
            "description" => "Team and Members Registration",
            "openedTime" => Carbon::toDateLocale($contest->period(PeriodType::REGISTRATION)->opened_at),
            "closedTime" => Carbon::toDateLocale($contest->period(PeriodType::REGISTRATION)->closed_at),
            "isActive" => $activeStep === "registration",
            "canAccess" => true,
            "route" => route(TeamController::routeNames . ".show", ["team" => $team])
        ]);

        $this->addStep([
            "icon" => "files",
            "title" => "Case and Answers",
            "description" => "Download case and upload answers",
            "openedTime" => Carbon::toDateLocale($contest->period(PeriodType::CASE_DISTRIBUTION)->opened_at),
            "closedTime" => Carbon::toDateLocale($contest->period(PeriodType::CASE_DISTRIBUTION)->closed_at),
            "isActive" => $activeStep === "answers",
            "canAccess" => $user->can("access", [$team, "answer"]),
            "route" => route(AnswerController::routeNames . ".index", ["contest" => $contest])
        ]);

        $this->addStep([
            "icon" => "file-earmark-check",
            "title" => "Assessments",
            "description" => "Final score and assessments result",
            "openedTime" => Carbon::toDateLocale($contest->period(PeriodType::ANNOUNCEMENT)->opened_at),
            "closedTime" => Carbon::toDateLocale($contest->period(PeriodType::ANNOUNCEMENT)->closed_at),
            "isActive" => $activeStep === "assessments",
            "canAccess" => $user->can("access", [$team, "score"]),
            "route" => route(ScoreController::routeNames . ".index", ["contest" => $contest])
        ]);
    }

    private function addStep(array $step) {
        $this->steps[] = $step;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('components.stepper-contest');
    }
}
