<?php

namespace App\Http\Livewire;

use App\Http\Controllers\FileController;
use Illuminate\Support\Carbon;
use LaravelViews\Views\DetailView;
use LaravelViews\Actions\RedirectAction;

class TeamDetailView extends DetailView {
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
            $model->university,
        ];
    }

    /**
     * @param $model Model instance
     * @return Array Array with all the detail data or the components
     */
    public function detail($model) {
        return [
            "Team ID" => $model->id,
            "Name" => $model->name,
            "University" => $model->university,
            "Members" => $model->members->count() . " Person",
            "Contest" => $model->contestCategory->contest->title,
            "Contest Category" => $model->contestCategory->title,
            "Maximum Team Member" => $model->contestCategory->max_team_member . " Person",
            "Registered At" => Carbon::toLocale($model->created_at),
            "Registration Status" => $model->registration->status->title . " - " . $model->registration->status->description
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    public function actions(): array {
        return [
            new RedirectAction(FileController::routeNames . ".team", "Download", "download")
        ];
    }
}
