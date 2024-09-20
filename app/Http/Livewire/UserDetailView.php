<?php

namespace App\Http\Livewire;

use LaravelViews\Views\DetailView;
use App\TableActions\ToggleSoftDeleteAction;
use Illuminate\Support\Carbon;

class UserDetailView extends DetailView {
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
            $model->email,
        ];
    }

    /**
     * Sets detail to be rendered
     * 
     * @param  $model   Model instance
     * @return Array    Array with all the detail data or the components
     */
    public function detail($model) {
        return [
            "User ID" => $model->id,
            "Name" => $model->name,
            "Email" => $model->email,
            "Created At" => Carbon::toLocale($model->created_at),
            "Status" => $model->deleted_at ?
                "Deactivated on " . Carbon::toLocale($model->deleted_at) :
                "Active",
        ];
    }

    public function actions() {
        return [
            new ToggleSoftDeleteAction("Activate / Deactivate", "shield", "activate", "deactivate")
        ];
    }
}
