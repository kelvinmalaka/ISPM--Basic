<?php

namespace App\Http\Controllers\Contest;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Contest\CategoryManagementController;
use App\Http\Requests\Contest\StoreAnswerTypeRequest;
use App\Http\Requests\Contest\UpdateAnswerTypeRequest;
use App\Models\AnswerType;
use App\Models\Contest;
use App\Models\ContestCategory;

class AnswerTypeManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contests_categories_answers";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contests.answertypes";

    /**
     * Show the form for creating a new resource.
     *
     * @param  Contest          $contest
     * @param  ContestCategory  $category
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(Contest $contest, ContestCategory $category) {
        $this->authorize("create", [AnswerType::class, $category]);

        $title = "Create Answer Type";

        $type = new AnswerType();
        $validTypes = AnswerType::VAILD_FILE_TYPES;

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store", ["contest" => $contest, "category" => $category]))
            ->with("method", "POST")
            ->with("title", $title)
            ->with("type", $type)
            ->with("validTypes", $validTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreAnswerTypeRequest  $request
     * @param  Contest          $contest
     * @param  ContestCategory  $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAnswerTypeRequest $request, Contest $contest, ContestCategory $category) {
        $this->authorize("create", [AnswerType::class, $category]);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $answerType = new AnswerType();

        $answerType->name = $data["name"];
        $answerType->description = $data["description"];
        $answerType->file_type = $data["file_type"];
        $answerType->max_size = $data["max_size"];

        $answerType->contestCategory()->associate($category);
        $answerType->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Answer Type created!");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  AnswerType   $answer
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(AnswerType $answer) {
        $this->authorize("manage", $answer);

        $title = "Edit Answer Type";
        $validTypes = AnswerType::VAILD_FILE_TYPES;

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".update", ["answer" => $answer]))
            ->with("method", "PUT")
            ->with("title", $title)
            ->with("type", $answer)
            ->with("validTypes", $validTypes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAnswerTypeRequest  $request
     * @param  AnswerType   $answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAnswerTypeRequest $request, AnswerType $answer) {
        $this->authorize("manage", $answer);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $answer->name = $data["name"];
        $answer->description = $data["description"];
        $answer->file_type = $data["file_type"];
        $answer->max_size = $data["max_size"];

        $answer->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Answer Type updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  AnswerType   $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnswerType $answer) {
        $this->authorize("manage", $answer);

        $category = $answer->contestCategory;

        try {
            $answer->delete();

            return redirect()
                ->route(CategoryManagementController::routeNames . ".show", ["category" => $category])
                ->with("message", "Answer Type deleted!");
        } catch (\Exception $e) {

            return redirect()
                ->route(CategoryManagementController::routeNames . ".show", ["category" => $category])
                ->with("message", $e->getMessage());
        }
    }
}
