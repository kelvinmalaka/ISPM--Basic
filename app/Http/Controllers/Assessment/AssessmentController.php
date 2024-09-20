<?php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Assessment;
use App\Helpers\URLHelper;
use App\Http\Requests\Assessment\UpdateAssessmentRequest;

class AssessmentController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "assessment";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "assessment";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $judge = auth()->user()->userable("judge");

        return view(self::viewPath . ".index")
            ->with("judge", $judge);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Answer   $answer
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Answer $answer) {
        $this->authorize("assess", $answer);

        $answer->load(["team.category.assessmentComponents", "team.category.contest", "validation.status"]);

        $judge = auth()->user()->userable("judge");
        $assessments = $answer->assessments()->with("component")->whereRelation("judge", "judge_id", "=", $judge->id)->get();

        $assessmentComponents = $answer->team->category->assessmentComponents()->whereRelation("judges", "judge_id", "=", $judge->id)->get();
        if ($assessments->count() !== $assessmentComponents->count()) {
            $existingAssessmentComponents = $assessments->map(function (Assessment $assessment) {
                return $assessment->component;
            });

            $notExistsComponents = $assessmentComponents->diff($existingAssessmentComponents);

            foreach ($notExistsComponents as $component) {
                $assessment = new Assessment();
                $assessment->component = $component;

                $assessments->add($assessment);
            }
        }

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".update", ["answer" => $answer]))
            ->with("method", "PUT")
            ->with("answer", $answer)
            ->with("assessments", $assessments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAssessmentRequest  $request
     * @param  Answer   $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAssessmentRequest $request, Answer $answer) {
        $this->authorize("assess", $answer);

        $answer->load("team.category.assessmentComponents.judges");
        $judge = auth()->user()->userable("judge");
        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $assessments = [];
        foreach ($data["assessments"] as $inputAssessment) {
            $component = $answer->team->category->assessmentComponents->find($inputAssessment["id"]);

            $assessment = Assessment::query()->whereBelongsTo($judge)->whereBelongsTo($component, "component")->firstOrNew();
            $assessment->score = $inputAssessment["score"];
            $assessment->feedback = $inputAssessment["feedback"];

            $assessment->judge()->associate($judge);
            $assessment->component()->associate($component);
            $assessments[] = $assessment;
        }

        $answer->assessments()->saveMany($assessments);
        $answer->team->updateOverallScore();

        return redirect()
            ->to($previousURL)
            ->with("message", "Assessment updated!");
    }
}
