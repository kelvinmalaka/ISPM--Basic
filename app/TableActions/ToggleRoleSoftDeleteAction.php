<?php

namespace App\TableActions;

use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class ToggleRoleSoftDeleteAction extends Action {
    /**
     * Default title to be rendered on tooltop
     * 
     * @var string
     */
    public $title = "Grant / Revoke";

    /**
     * Bootstrap icon name to be rendered
     * 
     * @var string
     */
    public $icon = "shield";

    /**
     * Action constructor
     * 
     * @param  string   $title
     * @param  string   $icon 
     * @param  string   $restoreWord
     * @param  string   $deleteWord
     */
    public function __construct(string $title = null, string $icon = null) {
        $this->id = "toggle-role-soft-delete-action";

        if ($title) $this->title = $title;
        if ($icon) $this->icon = $icon;
    }

    /**
     * Execute the action when the user clicked on the button
     *
     * @param  $model Model object of the list where the user has clicked
     * @param  $view Current view where the action was executed from
     * @return void
     */
    public function handle($model, View $view): void {
        $status = $model->trashed() ? $model->restore() : $model->delete();
        $status ? $this->success() : $this->error();
    }
}
