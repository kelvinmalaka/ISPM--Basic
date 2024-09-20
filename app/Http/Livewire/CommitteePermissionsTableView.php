<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Contest\CommitteePermissionManagementController;
use App\Http\Livewire\EnhancedTableView;
use App\Models\CommitteePermission;
use App\Models\ContestCategory;
use App\TableActions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;

class CommitteePermissionsTableView extends EnhancedTableView {
    /**
     * Store committee's contest category
     * 
     * @var  ContestCategory
     */
    public $category;

    /**
     * Store table title
     * 
     * @var  string
     */
    public $title = "Available Committees";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = CommitteePermissionManagementController::routeNames;

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
    public $emptyDataWords = "No committee assigned to this contest category.";

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
        return CommitteePermission::with(["category", "committee"])
            ->whereBelongsTo($this->category, "category");
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return ["Name", "Email"];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param  CommitteePermission  $permission
     * @return array
     */
    public function row(CommitteePermission $permission): array {
        return [
            $permission->committee->user->name,
            $permission->committee->user->email
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        return [
            new DeleteAction()
        ];
    }

    /**
     * Override default library method, as this entity use composite key.
     * 
     * @return CommitteePermission
     */
    public function getModelWhoFiredAction($id): CommitteePermission {
        [$categoryId, $committeeId] = explode("_", $id);

        return CommitteePermission::query()
            ->whereRelation("category", "contest_category_id", $categoryId)
            ->whereRelation("committee", "committee_id", $committeeId)
            ->first();
    }
}
