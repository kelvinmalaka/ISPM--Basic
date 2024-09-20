<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use LaravelViews\Facades\Header;
use LaravelViews\Actions\RedirectAction;
use App\Http\Controllers\Assessment\AssessmentController;
use App\TableFilters\AssessmentStatusFilter;
use App\Http\Livewire\EnhancedTableView;
use App\Models\Judge;
use App\Models\Answer;
use App\Models\AnswerStatus;
use App\Models\PeriodType;

class AssessmentsTableView extends EnhancedTableView {
    /**
     * Store judge as table viewer
     * 
     * @var  Judge
     */
    public $judge;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title;

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = AssessmentController::routeNames;

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
    public $emptyDataWords = "No available team answer to show.";

    /**
     * Sets data count in each page
     * 
     * @var  int
     */
    protected $paginate = 20;

    /**
     * Sets searchable columns
     * 
     * @var  array<string>
     */
    public $searchBy = ["team.name"];

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    protected function load($args): void {
    }

    /**
     * Sets a query to get the initial data
     * 
     * @return  Builder
     */
    public function repository(): Builder {
        return Answer::with("team.category.contest")
            ->whereRelation("validation.status", "usid", AnswerStatus::APPROVED)
            ->whereRelation("team.category.assessmentComponents.judges", "judge_id", "=", $this->judge->id)
            ->whereRelation("team.category.contest", fn (Builder $query) => $query->periodActive(PeriodType::ASSESSMENT));
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return [
            Header::title("Team ID")->sortBy("team.id"),
            Header::title("Team Name")->sortBy("team.name"),
            "Contest",
            "Contest Category",
            "Answer Submitted At"
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param  $answer   Current model for each row
     */
    public function row(Answer $answer): array {
        $team = $answer->team;

        return [
            $team->id,
            $team->name,
            $team->category->contest->title,
            $team->category->title,
            Carbon::toLocale($answer->created_at)
        ];
    }

    /**
     * Register filters
     *
     * @return  array
     */
    protected function filters(): array {
        return [
            new AssessmentStatusFilter($this->judge)
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        return [
            new RedirectAction($this->actionRoutes . ".edit", "Assessment", "file-earmark-spreadsheet")
        ];
    }
}
