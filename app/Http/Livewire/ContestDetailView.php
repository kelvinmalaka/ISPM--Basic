<?php

namespace App\Http\Livewire;

use LaravelViews\Views\DetailView;
use LaravelViews\Actions\RedirectAction;
use LaravelViews\Facades\UI;
use Illuminate\Support\Carbon;
use App\TableActions\DeleteAction;
use App\TableActions\TogglePublishedAction;
use App\Http\Controllers\Contest\ContestManagementController;
use App\Http\Controllers\FileController;

class ContestDetailView extends DetailView {
    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = ContestManagementController::routeNames;

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
            $model->title,
            $model->description,
        ];
    }

    /**
     * @param $model Model instance
     * @return Array Array with all the detail data or the components
     */
    public function detail($model) {
        return [
            "Contest ID" => $model->id,
            "Title" => $model->title,
            "Description" => $model->description,
            "Administrator" => $model->administrator->user->name,
            "Administrator Email" => $model->administrator->user->email,
            "Guide Document" => $model->guide_file_path ?
                UI::component(
                    "vendor.laravel-views.components.link",
                    [
                        "title" => "Available",
                        "to" => route(FileController::routeNames . ".contest", ["contest" => $model->id])
                    ]
                ) :
                UI::icon("dash", "danger", "text-2xl"),
            "Banner Image" => $model->banner_img_path ? "Available" : UI::icon("dash", "danger", "text-2xl"),
            "Created At" => Carbon::toLocale($model->created_at),
            "Status" => $model->published_at ?
                "Published on " . Carbon::toLocale($model->published_at) :
                "Not published",
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    public function actions(): array {
        return [
            new TogglePublishedAction(),
            new RedirectAction($this->actionRoutes . ".edit", "Edit", "pencil"),
            new DeleteAction()
        ];
    }
}
