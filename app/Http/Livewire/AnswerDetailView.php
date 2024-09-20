<?php

namespace App\Http\Livewire;

use LaravelViews\Views\DetailView;
use LaravelViews\Actions\RedirectAction;
use LaravelViews\Facades\UI;
use Illuminate\Support\Carbon;
use App\Http\Controllers\FileController;
use App\Models\Answer;

class AnswerDetailView extends DetailView {
    public $title = "";
    public $subtitle = "";

    /**
     * Sets heading to be rendered
     * 
     * @param  Answer   $model  Model instance
     * @return array    Array with all the detail data or the components
     */
    public function heading(Answer $model) {
        return [
            $model->team->name,
            $model->team->university,
        ];
    }

    /**
     * Sets data to be rendered
     * 
     * @param  Answer   $model Model instance
     * @return Array    Array with all the detail data or the components
     */
    public function detail(Answer $model) {
        return [
            "Answer ID" => $model->id,
            "Team ID" => $model->team->id,
            "Team Name" => $model->team->name,
            "University" => $model->team->university,
            "Contest" => $model->team->contestCategory->contest->title,
            "Contest Category" => $model->team->contestCategory->title,
            "Submitted At" => Carbon::toLocale($model->created_at),
            "Validation Status" => $model->validation ?
                $model->validation->status->title . " - " . $model->validation->status->description
                :  UI::icon("dash", "danger", "text-2xl")
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    public function actions(): array {
        return [
            new RedirectAction(FileController::routeNames . ".answer", "Download", "download")
        ];
    }
}
