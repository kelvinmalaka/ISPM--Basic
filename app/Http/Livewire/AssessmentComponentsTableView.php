<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Actions\RedirectAction;
use App\TableActions\DeleteAction;
use App\Http\Livewire\EnhancedTableView;
use App\Http\Controllers\Contest\AssessmentComponentManagementController;
use App\Models\AssessmentComponent;
use App\Models\ContestCategory;

class AssessmentComponentsTableView extends EnhancedTableView {
    /**
     * Store assessment-component's contest category
     * 
     * @var  ContestCategory
     */
    public $category;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title = "Assessment Components";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = AssessmentComponentManagementController::routeNames;

    /**
     * Store manage action
     * 
     * @var  array|null
     */
    public $manageAction;

    /**
     * Sets word to be displayed when no data is available
     * 
     * @var  string|null
     */
    public $emptyDataWords = "No assessment component created yet.";

    /**
     * Hide pagination
     * 
     * @var  bool
     */
    public $hidePagination = true;

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    protected function load($args): void {
        $category = $this->category;

        $this->manageAction = [
            "route" => route($this->actionRoutes . ".create", [
                "category" => $category->id,
                "contest" => $category->contest->id
            ]),
            "icon" => "plus-circle",
            "text" => "Add"
        ];
    }

    /**
     * Sets a query to get the initial data
     * 
     * @return  Builder
     */
    public function repository(): Builder {
        return AssessmentComponent::query()
            ->whereBelongsTo($this->category);
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return [
            "Name",
            "Description",
            "Weight"
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row(AssessmentComponent $model): array {
        return [
            $model->name,
            $model->description,
            $model->weight . "%"
        ];
    }

    /**
     * Render results row
     * 
     * @return  array
     */
    public function results(): array {
        $sum = $this->repository()->sum("weight");
        $result = "Total weight is " . $sum . "%. ";

        if (intval($sum) !== 100) {
            $result .= "Please ensure that the total weight is 100% before publishing contest.";
        }

        return [$result];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        return [
            new RedirectAction($this->actionRoutes . ".show", "View", "eye"),
            new RedirectAction($this->actionRoutes . ".edit", "Edit", "pencil"),
            new DeleteAction()
        ];
    }
}
