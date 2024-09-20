<?php

namespace App\Http\Livewire;

use App\Http\Controllers\Contest\JudgePermissionManagementController;
use App\Http\Livewire\EnhancedTableView;
use App\Models\AssessmentComponent;
use App\Models\JudgePermission;
use App\TableActions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;

class JudgePermissionsTableView extends EnhancedTableView {
    /**
     * Store judge's assessment component
     * 
     * @var  AssessmentComponent
     */
    public $component;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title = "Available Judges";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = JudgePermissionManagementController::routeNames;

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
    public $emptyDataWords = "No judge assigned to this assessment component.";

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
        $component = $this->component;

        $category = $component->contestCategory;
        $contest = $category->contest;

        $this->manageAction = [
            "route" => route($this->actionRoutes . ".create", [
                "category" => $category->id,
                "contest" => $contest->id,
                "assessment" => $component->id
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
        return JudgePermission::with(["judge", "assessmentComponent"])
            ->whereBelongsTo($this->component, "assessmentComponent");
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
     * @param JudgePermission   $permission Current model for each row
     */
    public function row(JudgePermission $permission): array {
        return [
            $permission->judge->user->name,
            $permission->judge->user->email
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
     * @return JudgePermission
     */
    public function getModelWhoFiredAction($id): JudgePermission {
        [$componentId, $judgeId] = explode("_", $id);

        return JudgePermission::query()
            ->whereRelation("assessmentComponent", "assessment_component_id", $componentId)
            ->whereRelation("judge", "judge_id", $judgeId)
            ->first();
    }
}
