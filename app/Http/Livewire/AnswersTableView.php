<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use LaravelViews\Actions\RedirectAction;
use LaravelViews\Facades\UI;
use App\Http\Controllers\Contestant\AnswerController;
use App\Http\Livewire\EnhancedTableView;
use App\Models\Answer;
use App\Models\Team;
use App\Http\Controllers\FileController;

class AnswersTableView extends EnhancedTableView {
    /**
     * Store members' team
     * 
     * @var  Team
     */
    public $team;

    /**
     * Store if allowed to create new answer
     * 
     * @var  bool
     */
    public $allowCreate;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title = "Submitted Answers";

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = AnswerController::routeNames;

    /**
     * Store manage action
     * 
     * @var  array|null
     */
    public $manageAction;

    /**
     * Sets word to be displayed when no data is available
     * 
     * @var  string|null
     */
    public $emptyDataWords = "No answer has been uploaded.";

    /**
     * Sets data count in each page
     * 
     * @var  int
     */
    protected $paginate = 15;

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    protected function load($args): void {
        $team = $this->team;
        $contest = $team->category->contest;

        if (auth()->user()->can('create', [Answer::class, $this->team])) {
            $this->manageAction = [
                "route" => route($this->actionRoutes . ".create", ["contest" => $contest]),
                "icon" => "plus-circle",
                "text" => "Upload Answer"
            ];
        }
    }

    /**
     * Sets a query to get the initial data
     * 
     * @return  Builder
     */
    public function repository(): Builder {
        return Answer::query()
            ->with("validation")
            ->whereRelation("team", "team_id", $this->team->id)
            ->latest();
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return ["ID", "Uploaded At", "Status"];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row(Answer $model): array {
        return [
            $model->id,
            Carbon::toLocale($model->created_at),
            $model->isVerified() ? UI::icon("check-lg", "danger", "text-2xl") : UI::icon("dash", "danger", "text-2xl")
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        return [
            new RedirectAction(FileController::routeNames . ".answer", "Download", "download")
        ];
    }
}
