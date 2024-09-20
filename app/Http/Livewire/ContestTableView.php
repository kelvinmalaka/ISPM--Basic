<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Facades\Header;
use LaravelViews\Facades\UI;
use LaravelViews\Actions\RedirectAction;
use Illuminate\Support\Carbon;
use App\TableFilters\PublishedFilter;
use App\TableActions\DeleteAction;
use App\Http\Livewire\EnhancedTableView;
use App\Http\Controllers\Contest\ContestManagementController;
use App\Models\Contest;
use App\Models\Administrator;

class ContestTableView extends EnhancedTableView {
    /**
     * Store contest's administrator
     * 
     * @var  Administrator|null
     */
    public $administrator;

    /**
     * Store allow creation
     * 
     * @var  bool|null
     */
    public $allowCreate;

    /**
     * Store read only
     * 
     * @var  bool|null
     */
    public $readOnly;

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = ContestManagementController::routeNames;

    /**
     * Store manage action
     * 
     * @var  string|null
     */
    public $manageAction;

    /**
     * Sets word to be displayed when no data is available
     * 
     * @var  string|null
     */
    public $emptyDataWords = "No contest in record. Create a new contest using create button.";

    /**
     * Sets data count in each page
     * 
     * @var  int
     */
    protected $paginate = 10;

    /**
     * Sets searchable columns
     * 
     * @var  array<string>
     */
    public $searchBy = ["title"];

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    protected function load($args): void {
        if ($this->allowCreate) $this->manageAction = [
            "route" => route($this->actionRoutes . ".create"),
            "icon" => "plus-circle",
            "text" => "Create"
        ];
    }

    /**
     * Sets a query to get the initial data
     * 
     * @return  Builder
     */
    public function repository(): Builder {
        $query = Contest::with("administrator");

        if ($this->administrator) {
            $query = $query->whereRelation("administrator", "id", $this->administrator->id);
        }

        return $query;
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return  array<string>   Array of headers
     */
    public function headers(): array {
        return [
            Header::title("ID")->sortBy("id"),
            Header::title("Title")->sortBy("title"),
            Header::title("Desccription"),
            Header::title("Created At")->sortBy("created_at"),
            "Published",
            "Administrator"
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param  Contest  $model Current model for each row
     * @return array
     */
    public function row($model): array {
        return [
            $model->id,
            $model->title,
            $model->description,
            Carbon::toLocale($model->created_at),
            $model->isPublished() ?
                UI::icon("check-lg", "success", "text-2xl") :
                UI::icon("dash", "danger", "text-2xl"),
            $model->administrator->user->name
        ];
    }

    /**
     * Register filters
     *
     * @return  array
     */
    protected function filters(): array {
        return [
            new PublishedFilter()
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        $actions = [
            new RedirectAction($this->actionRoutes . ".show", "View", "eye"),
        ];

        if ($this->readOnly) return $actions;

        return array_merge($actions, [
            new RedirectAction($this->actionRoutes . ".edit", "Edit", "pencil"),
            new DeleteAction()
        ]);
    }
}
