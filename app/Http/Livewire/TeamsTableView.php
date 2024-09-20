<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Contest\ContestManagementController;
use App\Http\Controllers\Contest\TeamManagementController;
use App\Http\Livewire\EnhancedTableView;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Actions\RedirectAction;
use LaravelViews\Facades\Header;

class TeamsTableView extends EnhancedTableView {
    /**
     * Store contests
     * 
     * @var  Contest|null
     */
    public $contest;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title = "Registered Teams";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = TeamManagementController::routeNames;

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
    public $emptyDataWords = "No team registered in record.";

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
    public $hidePagination = false;

    /**
     * Sets searchable columns
     * 
     * @var  array<string>
     */
    public $searchBy = ["name", "university"];

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    protected function load($args): void {
        $this->manageAction = [
            "route" => route(ContestManagementController::routeNames . ".report", ["contest" => $this->contest->id]),
            "icon" => "download",
            "text" => "Get Report"
        ];
    }

    /**
     * Sets a query to get the initial data
     * 
     * @return  Builder
     */
    public function repository(): Builder {
        return Team::with(["category", "registration"])
            ->whereRelation("contest", "contest_id", $this->contest->id);
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return [
            Header::title("ID")->sortBy("id"),
            Header::title("Name")->sortBy("name"),
            Header::title("University")->sortBy("university"),
            Header::title("Category"),
            Header::title("Total Score")->sortBy("overall_score"),
            Header::title("Registration")
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param  Team $team Current model for each row
     */
    public function row(Team $team): array {
        return [
            $team->id,
            $team->name,
            $team->university,
            $team->category->title,
            $team->overall_score,
            $team->registration->status->title
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        return [
            new RedirectAction($this->actionRoutes . ".show", "View", "eye")
        ];
    }
}
