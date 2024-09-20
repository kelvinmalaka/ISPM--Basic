<?php

namespace App\Http\Controllers\Validate;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Answer;
use App\Models\AnswerValidation;
use App\Models\AnswerStatus;
use App\Helpers\URLHelper;
use App\Http\Requests\Validate\StoreAnswerRequest;

class AnswerController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "validate_answers";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "validate.answers";

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
        $team = Team::with("answer")->findOrFail($teamId);
        $this->authorize("validate", $team);

        $answer = $team->answer;

        $statuses = AnswerStatus::all();
        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store"))
            ->with("method", "POST")
            ->with("team", $team)
            ->with("answer", $answer)
            ->with("statuses", $statuses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAnswerRequest   $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAnswerRequest $request) {
        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $answer = Answer::findOrFail($data["answer"]);
        $status = AnswerStatus::findOrFail($data["status"]);
        $committee = $answer->team->contestCategory->committees()->find(auth()->user()->userable("committee")->id);

        $validation = new AnswerValidation();

        $validation->description = $data["description"];
        $validation->committee_permission_id = $committee->pivot->id;

        $validation->answer()->associate($answer);
        $validation->status()->associate($status);

        $validation->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Validation submitted!");
    }
}
