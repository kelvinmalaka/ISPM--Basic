<?php

namespace App\Http\Livewire;

use App\Http\Livewire\EnhancedTableView;
use App\Http\Controllers\User\RoleManagementController;
use App\Models\User;
use App\Models\RoleUser;
use App\TableActions\ToggleRoleSoftDeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class UserRolesTableView extends EnhancedTableView {
    /**
     * Store user
     * 
     * @var  User
     */
    public $user;

    /**
     * Store table title
     * 
     * @var  string
     */
    public $title = "Attached Roles";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = RoleManagementController::routeNames;

    /**
     * Store manage action
     * 
     * @var  array|null
     */
    public $manageAction;

    /**
     * Hide pagination
     * 
     * @var  bool
     */
    public $hidePagination = true;

    /**
     * Sets word to be displayed when no data is available
     * 
     * @var  string|null
     */
    public $emptyDataWords = "No role attached.";

    /**
     * Sets data count in each page
     * 
     * @var  int
     */
    protected $paginate = 10;

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    protected function load($args): void {
        $this->manageAction = [
            "route" => route($this->actionRoutes . ".create", ["user" => $this->user->id]),
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
        return RoleUser::with(["role", "user"])
            ->whereRelation("user", "id", $this->user->id);
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return  array<string>   Array of headers
     */
    public function headers(): array {
        return ["Role", "Status"];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param  RoleUser $model Current model for each row
     * @return array
     */
    public function row(RoleUser $model): array {
        if ($model->deleted_at) {
            $status =  "Revoked on " . Carbon::toLocale($model->deleted_at);
        } else if (Carbon::parse($model->created_at)->equalTo($model->updated_at)) {
            $status = "Granted on " . Carbon::toLocale($model->created_at);
        } else {
            $status = "Re-granted on " . Carbon::toLocale($model->updated_at);
        }

        return [
            $model->role->title,
            $status
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        return [
            new ToggleRoleSoftDeleteAction
        ];
    }

    /**
     * Override default library method, 
     * as this entity use composite key.
     */
    public function getModelWhoFiredAction($id) {
        [$userId, $roleId] = explode("_", $id);

        return (clone $this->initialQuery)
            ->whereRelation("user", "id", $userId)
            ->whereRelation("role", "id", $roleId)
            ->first();
    }
}
