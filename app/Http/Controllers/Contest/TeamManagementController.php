<?php

namespace App\Http\Controllers\Contest;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Contest\ContestManagementController;
use App\Models\Team;

class TeamManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contests_teams";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contests.teams";

    /**
     * Display the specified resource.
     *
     * @param  Team     $team
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Team $team) {
        $contest = $team->contest;
        $this->authorize("manage", $contest);

        return view(self::viewPath . ".show")
            ->with("back", route(ContestManagementController::routeNames . ".show", ["contest" => $contest]))
            ->with("team", $team);
    }
}
