<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Contestant\TeamController;
use App\Http\Controllers\FileController;
use App\Models\Contest;
use App\Models\PeriodType;
use Illuminate\Support\Carbon;

class ContestController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "public_contests";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "public.contests";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index() {
        return view(self::viewPath . ".index");
    }

    /**
     * Display the specified resource.
     *
     * @param  Contest  $contest
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Contest $contest) {
        $contest->load(["categories", "periods"]);
        $guide = route(FileController::routeNames . ".contest", [$contest->id]);

        $registrationPeriod = $contest->period(PeriodType::REGISTRATION);
        $isRegistrationOpen = $registrationPeriod->isActive();
        $openRegistrationDate = Carbon::toDateLocale($registrationPeriod->opened_at);
        $closeRegistrationDate =  Carbon::toDateLocale($registrationPeriod->closed_at);

        $team = $contest->getContestantTeam();
        $hasRegistered = boolval($team);
        $nextRoute = $hasRegistered ?
            route(TeamController::routeNames . ".show", ["team" => $team]) :
            route(TeamController::routeNames . ".create", ["contest" => $contest]);

        return view(self::viewPath . ".show")
            ->with("back", route(self::routeNames . ".index"))
            ->with("contest", $contest)
            ->with("guide", $guide)
            ->with("hasRegistered", $hasRegistered)
            ->with("isRegistrationOpen", $isRegistrationOpen)
            ->with("openRegistrationDate", $openRegistrationDate)
            ->with("closeRegistrationDate", $closeRegistrationDate)
            ->with("nextRoute", $nextRoute);
    }
}
