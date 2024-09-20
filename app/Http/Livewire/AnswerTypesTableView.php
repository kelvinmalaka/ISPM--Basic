<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Actions\RedirectAction;
use App\TableActions\DeleteAction;
use App\Http\Livewire\EnhancedTableView;
use App\Http\Controllers\Contest\AnswerTypeManagementController;
use App\Models\AnswerType;
use App\Models\ContestCategory;

class AnswerTypesTableView extends EnhancedTableView {
    /**
     * Store answer-type's contest category
     * 
     * @var  ContestCategory
     */
    public $category;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title = "Answer Types";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = AnswerTypeManagementController::routeNames;

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
    public $emptyDataWords = "No answer type created yet.";

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
        return AnswerType::query()
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
            "File Extension",
            "Maximum Size"
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row(AnswerType $model): array {
        return [
            $model->name,
            $model->description,
            $model->file_type,
            $model->max_size . " MB"
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        return [
            new RedirectAction($this->actionRoutes . ".edit", "Edit", "pencil"),
            new DeleteAction()
        ];
    }
}
