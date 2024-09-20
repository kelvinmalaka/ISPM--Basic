<?php

namespace App\Http\Livewire;

use App\Http\Controllers\User\UserManagementController;
use App\Http\Livewire\EnhancedTableView;
use App\TableFilters\SoftDeleteFilter;
use App\TableFilters\UsersRoleFilter;
use App\TableActions\ToggleSoftDeleteAction;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use LaravelViews\Facades\UI;
use LaravelViews\Facades\Header;
use LaravelViews\Actions\RedirectAction;

class UsersTableView extends EnhancedTableView {
    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = UserManagementController::routeNames;

    /**
     * Store manage action behaviour
     * 
     * @var  array|null
     */
    public $manageAction;

    /**
     * Sets word to be displayed when no data is available
     * 
     * @var  string|null
     */
    public $emptyDataWords = "No user to show.";

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
    public $searchBy = ["name", "email"];

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    protected function load($args): void {
        $this->manageAction = [
            "route" => route($this->actionRoutes . ".create"),
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
        return User::with("roles")->withTrashed();
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return  array<string>   Array of headers
     */
    public function headers(): array {
        return [
            Header::title("ID")->sortBy("id"),
            Header::title("Name")->sortBy("name"),
            Header::title("Email")->sortBy("email"),
            "Roles",
            "Created At",
            "Active",
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param   User    $model  Current model for each row
     * @return  array
     */
    public function row(User $model): array {
        return [
            $model->id,
            $model->name,
            $model->email,
            $model->roles->map(fn ($role) => $role->title)->implode(", "),
            Carbon::toLocale($model->created_at),
            $model->deleted_at ? UI::icon("dash", "danger", "text-2xl") : UI::icon("check-lg", "success", "text-2xl")
        ];
    }

    /**
     * Register filters
     *
     * @return  array
     */
    protected function filters(): array {
        return [
            new SoftDeleteFilter(),
            new UsersRoleFilter()
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
            new ToggleSoftDeleteAction("Activate / Deactivate", "shield", "activate", "deactivate")
        ];
    }
}
