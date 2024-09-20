<?php

namespace App\Http\Controllers\Contest;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Contest\ContestManagementController;
use App\Http\Requests\Contest\StoreCategoryRequest;
use App\Http\Requests\Contest\UpdateCategoryRequest;
use App\Models\Contest;
use App\Models\ContestCategory;

class CategoryManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contests_categories";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contests.categories";

    /**
     * Show the form for creating a new resource.
     *
     * @param  Contest $contest
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Contest $contest) {
        $this->authorize("create", [ContestCategory::class, $contest]);

        $title = "Create Contest Category";

        $category = new ContestCategory();
        $category->contest()->associate($contest);

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store", ["contest" => $contest]))
            ->with("method", "POST")
            ->with("title", $title)
            ->with("contest", $contest)
            ->with("category", $category);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCategoryRequest  $request
     * @param  Contest  $contest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategoryRequest $request, Contest $contest) {
        $this->authorize("create", [ContestCategory::class, $contest]);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $category = new ContestCategory();

        $category->title = $data["title"];
        $category->description = $data["description"];
        $category->max_team_member = $data["max_team_member"];
        $category->max_answer_uploads = $data["max_answer_uploads"];

        if (array_key_exists("guide_file", $data)) {
            $guide_file = $request->file("guide_file");
            $guide_file_path = $guide_file->storeAs("contests/categories", $guide_file->getClientOriginalName());

            $category->guide_file_path = $guide_file_path;
        }

        if (array_key_exists("case_file", $data)) {
            $case_file = $request->file("case_file");
            $case_file_path = $case_file->storeAs("contests/categories", $case_file->getClientOriginalName());

            $category->case_file_path = $case_file_path;
        }

        $category->contest()->associate($contest);
        $category->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Contest category created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  ContestCategory  $category
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(ContestCategory $category) {
        $this->authorize("manage", $category);

        $category->load("contest");
        $contest = $category->contest;

        return view(self::viewPath . ".show")
            ->with("back", route(ContestManagementController::routeNames . ".show", ["contest" => $contest]))
            ->with("category", $category)
            ->with("contest", $contest);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ContestCategory  $category
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(ContestCategory $category) {
        $this->authorize("manage", $category);

        $category->load("contest");
        $contest = $category->contest;

        $title = "Edit Contest Category";
        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".update", ["contest" => $contest, "category" => $category]))
            ->with("method", "PUT")
            ->with("title", $title)
            ->with("contest", $contest)
            ->with("category", $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest    $request
     * @param  ContestCategory  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, ContestCategory $category) {
        $this->authorize("manage", $category);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $category->title = $data["title"];
        $category->description = $data["description"];
        $category->max_team_member = $data["max_team_member"];
        $category->max_answer_uploads = $data["max_answer_uploads"];

        if (array_key_exists("guide_file", $data)) {
            $guide_file = $request->file("guide_file");
            $guide_file_path = $guide_file->storeAs("contests/categories", $guide_file->getClientOriginalName());

            $category->guide_file_path = $guide_file_path;
        }

        if (array_key_exists("case_file", $data)) {
            $case_file = $request->file("case_file");
            $case_file_path = $case_file->storeAs("contests/categories", $case_file->getClientOriginalName());

            $category->case_file_path = $case_file_path;
        }

        $category->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ContestCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContestCategory $category) {
        $contest = $category->contest;

        try {
            $category->delete();

            return redirect()
                ->route(ContestManagementController::routeNames . ".show", ["contest" => $contest])
                ->with("message", "Contest category deleted!");
        } catch (\Exception $e) {

            return redirect()
                ->route(ContestManagementController::routeNames . ".show", ["contest" => $contest])
                ->with("error", $e->getMessage());
        }
    }
}
