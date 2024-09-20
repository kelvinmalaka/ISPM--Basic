<?php

namespace App\Http\Livewire;

use LaravelViews\Views\DetailView;
use LaravelViews\Actions\RedirectAction;
use App\TableActions\DeleteAction;
use App\Http\Controllers\Contest\AssessmentComponentManagementController;

class AssessmentComponentDetailView extends DetailView {
    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = AssessmentComponentManagementController::routeNames;

    public $title = "";
    public $subtitle = "";

    /**
     * Sets heading to be rendered
     * 
     * @param  $model   Model instance
     * @return array    Array with all the detail data or the components
     */
    public function heading($model) {
        return [
            $model->name,
            $model->description,
        ];
    }

    /**
     * @param $model Model instance
     * @return Array Array with all the detail data or the components
     */
    public function detail($model) {
        return [
            "Component ID" => $model->id,
            "Name" => $model->name,
            "Description" => $model->description,
            "Weight" => $model->weight . "%",
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    public function actions(): array {
        return [
            new RedirectAction($this->actionRoutes . ".edit", "Edit", "pencil"),
            new DeleteAction()
        ];
    }
}
