<?php

namespace App\Http\Controllers\Contestant;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Contestant\AnswerController;
use App\Http\Requests\Contestant\StoreTeamRequest;
use App\Http\Requests\Contestant\UpdateTeamRequest;
use App\Models\Contest;
use App\Models\ContestCategory;
use App\Models\Team;
use App\Models\Registration;
use App\Models\RegistrationStatus;
use App\Models\Role;
use Illuminate\Http\Request;

class TeamController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contestant_team";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contestant.team";

    /**
     * Display the specified resource.
     *
     * @param  Team $team
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Team $team) {
        $team->load(["category", "contest", "registration"]);
        $this->authorize("view", $team);

        $actions = [
            "register" => route(self::routeNames . ".register", ["team" => $team]),
            "edit" => route(self::routeNames . ".edit", ["team" => $team]),
            "answer" => route(AnswerController::routeNames . ".index", ["contest" => $team->contest])
        ];

        return view(self::viewPath . ".show")
            ->with("team", $team)
            ->with("actions", $actions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Contest  $contest
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Contest $contest) {
        $contest->load(["categories"]);
        $this->authorize("create", [Team::class, $contest]);

        $team = new Team();
        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("method", "POST")
            ->with("action", route(self::routeNames . ".store", ["contest" => $contest]))
            ->with("contest", $contest)
            ->with("team", $team);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreTeamRequest $request
     * @param  Contest  $contest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreTeamRequest $request, Contest $contest) {
        $this->authorize("create", [Team::class, $contest]);

        $data = $request->safe()->all();
        $categoryId = $data["category"];
        $category = ContestCategory::findOrFail($categoryId);

        $contestant = auth()->user()->userable(Role::CONTESTANT);

        $team = new Team();

        $team->name = $data["name"];
        $team->university = $data["university"];
        $team->overall_score = 0;
        $team->category()->associate($category);
        $team->contestant()->associate($contestant);
        $team->save();

        $status = RegistrationStatus::findByUSID(RegistrationStatus::CREATED);
        $registration = new Registration();
        $registration->description = "Created new team";
        $registration->team()->associate($team);
        $registration->status()->associate($status);
        $registration->save();

        return redirect()
            ->route(self::routeNames . ".show", ["team" => $team]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Team $team
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Team $team) {
        $team->load(["contest.categories"]);
        $this->authorize("update", $team);

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("method", "PUT")
            ->with("action", route(self::routeNames . ".update", ["team" => $team]))
            ->with("contest", $team->contest)
            ->with("team", $team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTeamRequest    $request
     * @param  Team $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTeamRequest $request, Team $team) {
        $this->authorize("update", $team);

        $data = $request->safe()->all();

        $categoryId = $data["category"];
        $category = ContestCategory::findOrFail($categoryId);

        $team->name = $data["name"];
        $team->university = $data["university"];

        $team->category()->associate($category);
        $team->save();

        return redirect()
            ->route(self::routeNames . ".show", ["team" => $team]);
    }

    /**
     * Submit team registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Team $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request, Team $team) {
        $team->load(["registration"]);
        $this->authorize("register", $team);

        if ($team->registration->status->usid === RegistrationStatus::REJECTED) {
            $status = RegistrationStatus::REVISED;
            $description = "Revised team registration";
        } else {
            $status = RegistrationStatus::SUBMITTED;
            $description = "Submitted team registration";
        }

        $status = RegistrationStatus::findByUSID($status);
        $registration = new Registration();

        $registration->description = $description;
        $registration->team()->associate($team);
        $registration->status()->associate($status);

        $registration->save();

        return redirect()
            ->route(self::routeNames . ".show", ["team" => $team])
            ->with("message", "Registration submitted!");
    }
}
