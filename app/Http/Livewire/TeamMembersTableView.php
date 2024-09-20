<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Actions\RedirectAction;
use LaravelViews\Facades\Header;
use App\Http\Livewire\EnhancedTableView;
use App\TableActions\DeleteAction;
use App\Http\Controllers\Contestant\TeamMemberController;
use App\Models\Team;
use App\Models\TeamMember;

class TeamMembersTableView extends EnhancedTableView {
    /**
     * Store members' team
     * 
     * @var  Team
     */
    public $team;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title = "Team Members";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = TeamMemberController::routeNames;

    /**
     * Store manage action
     * 
     * @var  array|null
     */
    public $manageAction;

    /**
     * Store read only
     * 
     * @var  bool|null
     */
    public $readOnly;

    /**
     * Sets word to be displayed when no data is available
     * 
     * @var  string|null
     */
    public $emptyDataWords = "No team members recorded yet.";

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
        $user = auth()->user();
        $team = $this->team;
        $contest = $team->contest;

        if ($user->can('create', [TeamMember::class, $team])) {
            $this->manageAction = [
                "route" => route($this->actionRoutes . ".create", ["contest" => $contest, "team" => $team]),
                "icon" => "plus-circle",
                "text" => "Add Member"
            ];
        }
    }

    /**
     * Sets a query to get the initial data
     * 
     * @return  Builder
     */
    public function repository(): Builder {
        return TeamMember::query()
            ->whereRelation("team", "team_id", $this->team->id);
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return [
            Header::title("Name")->sortBy("name"),
            Header::title("Email")->sortBy("email"),
            Header::title("Phone")->sortBy("phone"),
            Header::title("Role")->sortBy("is_leader")
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row(TeamMember $model): array {
        return [
            $model->name,
            $model->email,
            $model->phone,
            $model->is_leader ? "Leader" : "Member"
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {;
        if (auth()->user()->can("update", $this->team)) {
            return [
                new RedirectAction($this->actionRoutes . ".edit", "Edit", "pencil"),
                new DeleteAction()
            ];
        }

        return [];
    }
}
