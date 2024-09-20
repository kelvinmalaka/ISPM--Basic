<?php

namespace App\Http\Controllers\Contest;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Contest\CategoryManagementController;
use App\Http\Requests\Contest\StoreCommitteePermissionRequest;
use App\Models\Committee;
use App\Models\CommitteePermission;
use App\Models\Contest;
use App\Models\ContestCategory;

class CommitteePermissionManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contests_categories_committees";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contests.committees";

    /**
     * Show the form for creating a new resource.
     *
     * @param  Contest          $contest
     * @param  ContestCategory  $category
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Contest $contest, ContestCategory $category) {
        $this->authorize("create", [CommitteePermission::class, $category]);

        $existedPermissions = $category->committees()->get()->pluck("id");

        $committees = Committee::with("user")
            ->whereNotIn("id", $existedPermissions)
            ->get();

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store", ["contest" => $contest, "category" => $category]))
            ->with("method", "POST")
            ->with("committees", $committees);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCommitteePermissionRequest  $request
     * @param  Contest          $contest
     * @param  ContestCategory  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCommitteePermissionRequest $request, Contest $contest, ContestCategory $category) {
        $this->authorize("create", [CommitteePermission::class, $category]);

        $data = $request->all(["committee"]);
        $previousURL = URLHelper::getFormPreviousUrl();

        $committee = Committee::findOrFail($data["committee"]);
        $category->committees()->attach($committee);

        return redirect()
            ->to($previousURL)
            ->with("message", "Committee permission created!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CommitteePermission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(CommitteePermission $permission) {
        $this->authorize("manage", $permission);

        $category = $permission->category;

        try {
            $permission->delete();

            return redirect()
                ->route(CategoryManagementController::routeNames . ".show", ["category" => $category])
                ->with("message", "Committee permission deleted!");
        } catch (\Exception $e) {

            return redirect()
                ->route(CategoryManagementController::routeNames . ".show", ["category" => $category])
                ->with("message", $e->getMessage());
        }
    }
}
