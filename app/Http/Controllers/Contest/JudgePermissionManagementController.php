<?php

namespace App\Http\Controllers\Contest;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Contest\AssessmentComponentManagementController;
use App\Http\Requests\Contest\StoreJudgePermissionRequest;
use App\Models\AssessmentComponent;
use App\Models\Contest;
use App\Models\ContestCategory;
use App\Models\Judge;
use App\Models\JudgePermission;

class JudgePermissionManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contests_categories_judges";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contests.judges";

    /**
     * Show the form for creating a new resource.
     *
     * @param  Contest          $contest
     * @param  ContestCategory  $category
     * @param  int              $componentId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Contest $contest, ContestCategory $category, int $componentId) {
        $component = AssessmentComponent::with("judges")->findOrFail($componentId);
        $this->authorize("create", [JudgePermission::class, $component]);

        $existedPermissions = $component->judges()->get()->pluck("id");

        $judges = Judge::with("user")
            ->whereNotIn("id", $existedPermissions)
            ->get();

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store", ["contest" => $contest, "category" => $category, "assessment" => $component]))
            ->with("method", "POST")
            ->with(compact("judges"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreJudgePermissionRequest  $request
     * @param  Contest          $contest
     * @param  ContestCategory  $category
     * @param  int              $componentId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreJudgePermissionRequest $request, Contest $contest, ContestCategory $category, int $componentId) {
        $component = AssessmentComponent::query()->findOrFail($componentId);
        $this->authorize("create", [JudgePermission::class, $component]);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $judge = Judge::findOrFail($data["judge"]);

        $component->judges()->attach($judge);

        return redirect()
            ->to($previousURL)
            ->with("message", "Judge permission created!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  JudgePermission  $judge
     * @return \Illuminate\Http\Response
     */
    public function destroy(JudgePermission $judge) {
        $this->authorize("manage", $judge);

        $component = $judge->assessmentComponent;

        try {
            $judge->delete();

            return redirect()
                ->route(AssessmentComponentManagementController::routeNames . ".show", ["assessment" => $component])
                ->with("message", "Judge permission deleted!");
        } catch (\Exception $e) {

            return redirect()
                ->route(AssessmentComponentManagementController::routeNames . ".show", ["assessment" => $component])
                ->with("message", $e->getMessage());
        }
    }
}
