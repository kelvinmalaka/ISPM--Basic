<?php

namespace App\Http\Livewire;

use LaravelViews\Views\DetailView;
use LaravelViews\Actions\RedirectAction;
use LaravelViews\Facades\UI;
use Illuminate\Support\Carbon;
use App\TableActions\DeleteAction;
use App\Http\Controllers\Contest\CategoryManagementController;
use App\Http\Controllers\FileController;

class CategoryDetailView extends DetailView {
    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = CategoryManagementController::routeNames;

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
            "Category: " . $model->title,
            $model->description,
        ];
    }

    /**
     * @param $model Model instance
     * @return Array Array with all the detail data or the components
     */
    public function detail($model) {
        return [
            "Contest Title" => $model->contest->title,
            "Contest Description" => $model->contest->description,
            "Category ID" => $model->id,
            "Category Title" => $model->title,
            "Category Description" => $model->description,
            "Max Team Member" => $model->max_team_member . " Persons",
            "Max Answer Uploads" => $model->max_answer_uploads . " Answers",
            "Guide Document" =>  $model->guide_file_path ?
                UI::component(
                    "vendor.laravel-views.components.link",
                    [
                        "title" => "Available",
                        "to" => route(FileController::routeNames . ".category", ["category" => $model->id])
                    ]
                ) :
                UI::icon("dash", "danger", "text-2xl"),
            "Case Document" => $model->case_file_path  ?
                UI::component(
                    "vendor.laravel-views.components.link",
                    [
                        "title" => "Available",
                        "to" => route(FileController::routeNames . ".case", ["case" => $model->id])
                    ]
                ) :
                UI::icon("dash", "danger", "text-2xl"),
            "Created At" => Carbon::toLocale($model->created_at)
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
