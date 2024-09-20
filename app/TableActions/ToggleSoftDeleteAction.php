<?php

namespace App\TableActions;

use LaravelViews\Actions\Action;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\View;

class ToggleSoftDeleteAction extends Action {
    use Confirmable;

    /**
     * Default title to be rendered on tooltop
     * 
     * @var string
     */
    public $title = "Restore / Delete";

    /**
     * Bootstrap icon name to be rendered
     * 
     * @var string
     */
    public $icon = "shield";

    /**
     * Word of restore action
     * 
     * @var string
     */
    private $restoreWord = "restore";

    /**
     * Word of delete action
     * 
     * @var string
     */
    private $deleteWord = "delete";

    /**
     * Action constructor
     * 
     * @param  string   $title
     * @param  string   $icon 
     * @param  string   $restoreWord
     * @param  string   $deleteWord
     */
    public function __construct(string $title = null, string $icon = null, string $restoreWord = null, string $deleteWord = null) {
        $this->id = "toggle-soft-delete-action";

        if ($title) $this->title = $title;
        if ($icon) $this->icon = $icon;
        if ($restoreWord) $this->restoreWord = $restoreWord;
        if ($deleteWord) $this->deleteWord = $deleteWord;
    }

    /**
     * Set confirmation message.
     * 
     * @param  $model
     * @return string
     */
    public function getConfirmationMessage($model = null): string {
        if ($model->trashed()) {
            return "Are you sure to " .  $this->restoreWord . " this data?";
        }

        return "Are you sure to " . $this->deleteWord . " this data?";
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
        $model->refresh();

        $status ? $this->success() : $this->error();
    }
}
