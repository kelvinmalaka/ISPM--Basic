<?php

namespace App\Http\Controllers\Validate;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Validate\StoreRegistrationRequest;
use App\Models\Team;
use App\Models\Registration;
use App\Models\RegistrationStatus;

class RegistrationController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "validate_registrations";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "validate.registrations";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $committee = auth()->user()->userable("committee");

        return view(self::viewPath . ".index")
            ->with("committee", $committee);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $teamId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(int $teamId) {
        $team = Team::with(["contestCategory.contest", "registration", "members"])->findOrFail($teamId);
        $statuses = RegistrationStatus::query()->whereIn("usid", [RegistrationStatus::REJECTED, RegistrationStatus::APPROVED])->get();

        $this->authorize("validate", $team);

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store"))
            ->with("method", "POST")
            ->with("team", $team)
            ->with("statuses", $statuses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRegistrationRequest $request) {
        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $team = Team::findOrFail($data["team"]);
        $this->authorize("validate", $team);

        $status = RegistrationStatus::findOrFail($data["status"]);
        $committee = $team->contestCategory->committees()->find(auth()->user()->userable("committee")->id);

        $validation = new Registration();

        $validation->description = $data["description"];
        $validation->committee_permission_id = $committee->pivot->id;

        $validation->team()->associate($team);
        $validation->status()->associate($status);

        $validation->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Validation submitted!");
    }
}
