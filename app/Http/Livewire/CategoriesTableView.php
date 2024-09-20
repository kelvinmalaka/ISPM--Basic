<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Actions\RedirectAction;
use App\TableActions\DeleteAction;
use App\Http\Livewire\EnhancedTableView;
use App\Models\Contest;
use App\Models\ContestCategory;
use App\Http\Controllers\Contest\CategoryManagementController;

class CategoriesTableView extends EnhancedTableView {
    /**
     * Store category's contest
     * 
     * @var  Contest
     */
    public $contest;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title = "Contest Categories";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = CategoryManagementController::routeNames;

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
    public $emptyDataWords = "No contest category in record.";

    /**
     * Sets data count in each page
     * 
     * @var  int
     */
    protected $paginate = 10;

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
        $contest = $this->contest;

        $this->manageAction = [
            "route" => route($this->actionRoutes . ".create", ["contest" => $contest->id]),
            "text" => "Create",
            "icon" => "plus-circle"
        ];
    }

    /**
     * Sets a query to get the initial data
     * 
     * @return  Builder
     */
    public function repository(): Builder {
        return ContestCategory::query()->whereBelongsTo($this->contest, "contest");
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return [
            "Title",
            "Description",
            "Max Team Member"
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array {
        return [
            $model->title,
            $model->description,
            $model->max_team_member
        ];
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
