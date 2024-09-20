<?php

namespace App\Http\Controllers\Contestant;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Contestant\ScoreController;
use App\Http\Requests\Contestant\StoreAnswerRequest;
use App\Models\Answer;
use App\Models\AnswerDetail;
use App\Models\AnswerType;
use App\Models\Contest;
use App\Models\PeriodType;
use GuzzleHttp\Psr7\MimeType;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contestant_answer";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contestant.answer";

    /**
     * Display a listing of the resource.
     *
     * @param  Contest  $contest
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Contest $contest) {
        $contest->load("periods.type");
        $team = $contest->getContestantTeam();

        Gate::allowIf(fn() => $contest->period(PeriodType::SUBMISSION)->hasPassedOpeningDate());
        Gate::allowIf(fn() => $team->isRegistrationVerified());

        $isSubmissionOpen = $contest->period(PeriodType::SUBMISSION)->isActive();
        $isAnnouncementOpen = $contest->period(PeriodType::ANNOUNCEMENT)->isActive();

        $caseDistributionPeriod = $contest->period(PeriodType::CASE_DISTRIBUTION);
        $isCaseDistributionOpen = $caseDistributionPeriod->isActive();
        $closeCaseDistributionPeriod = Carbon::toLocale($caseDistributionPeriod->closed_at);

        $team->load(["answers", "category"]);
        $category = $team->category;

        return view(self::viewPath . ".index")
            ->with("next", route(ScoreController::routeNames . ".index", ["contest" => $contest]))
            ->with("action", route(self::routeNames . ".create", ["contest" => $contest]))
            ->with("case", route(FileController::routeNames . ".case", ["case" => $category->id]))
            ->with("contest", $contest)
            ->with("category", $category)
            ->with("team", $team)
            ->with("isCaseDistributionOpen", $isCaseDistributionOpen)
            ->with("isSubmissionOpen", $isSubmissionOpen)
            ->with("isAnnouncementOpen", $isAnnouncementOpen)
            ->with("closeCaseDistributionPeriod", $closeCaseDistributionPeriod);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Contest  $contest
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Contest $contest) {
        $team = $contest->getContestantTeam();

        Gate::allowIf(fn() => !is_null($team));
        $this->authorize("create", [Answer::class, $team]);

        $team->load("category.answerTypes");
        $answerTypes = $team->category->answerTypes;
        $answerTypes->map(function ($type) {
            $type->mimetype = MimeType::fromExtension($type->file_type);
            return $type;
        });

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store", ["contest" => $contest]))
            ->with("method", "POST")
            ->with("contest", $contest)
            ->with("answerTypes", $answerTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAnswerRequest   $request
     * @param  Contest  $contest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAnswerRequest $request, Contest $contest) {
        $team = $contest->getContestantTeam();

        Gate::allowIf(fn() => !is_null($team));
        $this->authorize("create", [Answer::class, $team]);

        $team->load("category.answerTypes");
        $answerTypes = $team->category->answerTypes;

        $rules = ['description' => ['string', 'nullable']];
        $answerTypes->each(function (AnswerType $type, int $index) use (&$rules) {
            $sizeMB = $type->max_size * 1000;

            $rules["answers." . $index . ".id"] = ['required', 'numeric'];
            $rules["answers." . $index . ".file"] = ['required', 'mimes:' . $type->file_type, 'max:' . $sizeMB];
        });

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $answer = new Answer();
        $answer->description = array_key_exists("description", $data) ?  $data["description"] : "";

        $answer->team()->associate($team);
        $answer->save();

        $details = [];
        foreach ($data["answers"] as $inputAnswer) {
            $detail = new AnswerDetail();

            $type = AnswerType::find($inputAnswer["id"]);
            $detail->type()->associate($type);

            $file_path = $inputAnswer["file"]->store("answers");
            $detail->file_path = $file_path;

            $details[] = $detail;
        }

        $answer->details()->saveMany($details);

        return redirect()
            ->to($previousURL)
            ->with("message", "Answer uploaded!");
    }
}
