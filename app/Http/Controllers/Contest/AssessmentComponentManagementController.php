<?php

namespace App\Http\Controllers\Contest;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Contest\CategoryManagementController;
use App\Http\Requests\Contest\StoreAssessmentComponentRequest;
use App\Http\Requests\Contest\UpdateAssessmentComponentRequest;
use App\Models\AssessmentComponent;
use App\Models\Contest;
use App\Models\ContestCategory;

class AssessmentComponentManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contests_categories_assessments";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contests.assessment_components";

    /**
     * Show the form for creating a new resource.
     *
     * @param  Contest          $contest
     * @param  ContestCategory  $category
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Contest $contest, ContestCategory $category) {
        $this->authorize("create", [AssessmentComponent::class, $category]);

        $assessmentComponent = new AssessmentComponent();
        $title = "Create Assessment Component";

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store", ["contest" => $contest, "category" => $category]))
            ->with("method", "POST")
            ->with("title", $title)
            ->with("assessmentComponent", $assessmentComponent);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAssessmentComponentRequest  $request
     * @param  Contest          $contest
     * @param  ContestCategory  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAssessmentComponentRequest $request, Contest $contest, ContestCategory $category) {
        $this->authorize("create", [AssessmentComponent::class, $category]);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $component = new AssessmentComponent();

        $component->name = $data["name"];
        $component->description = $data["description"];
        $component->weight = $data["weight"];

        $component->contestCategory()->associate($category);
        $component->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Assessment Component created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  AssessmentComponent  $assessment
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(AssessmentComponent $assessment) {
        $this->authorize("manage", $assessment);

        $category = $assessment->contestCategory;

        return view(self::viewPath . ".show")
            ->with("back", route(CategoryManagementController::routeNames . ".show", ["category" => $category]))
            ->with("assessmentComponent", $assessment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AssessmentComponent  $assessment
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(AssessmentComponent $assessment) {
        $this->authorize("manage", $assessment);

        $title = "Edit Assessment Component";
        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".update", ["assessment" => $assessment]))
            ->with("method", "PUT")
            ->with("title", $title)
            ->with("assessmentComponent", $assessment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAssessmentComponentRequest $request
     * @param  AssessmentComponent  $assessment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAssessmentComponentRequest $request, AssessmentComponent $assessment) {
        $this->authorize("manage", $assessment);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $assessment->name = $data["name"];
        $assessment->description = $data["description"];
        $assessment->weight = $data["weight"];

        $assessment->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Assessment Component updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AssessmentComponent  $assessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AssessmentComponent $assessment) {
        $this->authorize("manage", $assessment);

        $category = $assessment->contestCategory;

        try {
            $assessment->delete();

            return redirect()
                ->route(CategoryManagementController::routeNames . ".show", ["category" => $category])
                ->with("message", "Assessment Component deleted!");
        } catch (\Exception $e) {

            return redirect()
                ->route(CategoryManagementController::routeNames . ".show", ["category" => $category])
                ->with("message", $e->getMessage());
        }
    }
}
