<?php

namespace App\TableActions;

use Illuminate\Database\Eloquent\Model;
use LaravelViews\Actions\Action;
use LaravelViews\Views\View;

class DeleteAction extends Action {
    /**
     * Default title to be rendered on tooltop
     * 
     * @var string
     */
    public $title = "Delete";

    /**
     * Bootstrap icon name to be rendered
     * 
     * @var string
     */
    public $icon = "trash";

    /**
     * Action constructor
     * 
     * @param  string   $title
     * @param  string   $icon 
     * @param  string   $deleteWord
     */
    public function __construct(string $title = null, string $icon = null) {
        parent::__construct();

        if ($title) $this->title = $title;
        if ($icon) $this->icon = $icon;
    }

    /**
     * Execute the action when the user clicked on the button
     *
     * @param  Model   $model Model object of the list where the user has clicked
     * @param  View    $view Current view where the action was executed from
     * @return void
     */
    public function handle(Model $model, View $view): void {
        try {
            $model->delete();
            $this->success("Delete operation successful.");
        } catch (\Exception $e) {
            dd($e->getMessage());
            $this->error($e->getMessage());
        }
    }
}
