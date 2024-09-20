<?php

namespace App\TableActions;

use LaravelViews\Actions\Action;
use LaravelViews\Actions\Confirmable;
use LaravelViews\Views\View;

class TogglePublishedAction extends Action {
    use Confirmable;

    /**
     * Default title to be rendered on tooltop
     * 
     * @var string
     */
    public $title = "Publish / Unpublish";

    /**
     * Bootstrap icon name to be rendered
     * 
     * @var string
     */
    public $icon = "shield";

    /**
     * Word of publish action
     * 
     * @var string
     */
    private $publishWord = "publish";

    /**
     * Word of unpublish action
     * 
     * @var string
     */
    private $unpublishWord = "unpublish";

    /**
     * Action constructor
     * 
     * @param  string   $title
     * @param  string   $icon 
     * @param  string   $publishWord
     * @param  string   $unpublishWord
     */
    public function __construct(string $title = null, string $icon = null, string $publishWord = null, string $unpublishWord = null) {
        parent::__construct();

        $this->id = "toggle-published-action";
        if ($title) $this->title = $title;
        if ($icon) $this->icon = $icon;
        if ($publishWord) $this->publishWord = $publishWord;
        if ($unpublishWord) $this->unpublishWord = $unpublishWord;
    }

    /**
     * Set confirmation message.
     * 
     * @param  $model
     * @return string
     */
    public function getConfirmationMessage($model = null): string {
        $title = $model->title ?? $model->name ?? "this data";

        if ($model->isPublished()) {
            return "Are you sure to " .  $this->unpublishWord . " " . $title . "?";
        }

        return "Are you sure to " .  $this->publishWord . " " . $title . "?";
    }

    /**
     * Execute the action when the user clicked on the button
     *
     * @param  $model Model object of the list where the user has clicked
     * @param  $view Current view where the action was executed from
     * @return void
     */
    public function handle($model, View $view): void {
        $status = $model->isPublished() ? $model->unpublish() : $model->publish();
        $model->refresh();

        $status ? $this->success() : $this->error();
    }
}
