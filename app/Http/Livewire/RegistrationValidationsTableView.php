<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Facades\Header;
use LaravelViews\Actions\RedirectAction;
use App\Http\Controllers\Validate\RegistrationController;
use App\Http\Livewire\EnhancedTableView;
use App\Models\Committee;
use App\Models\PeriodType;
use App\Models\Team;

class RegistrationValidationsTableView extends EnhancedTableView {
    /**
     * Store committee as table viewer
     * 
     * @var  Committee
     */
    public $committee;

    /**
     * Sets route prefix for actions
     * 
     * @var  string
     */
    protected $actionRoutes = RegistrationController::routeNames;

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
    public $emptyDataWords = "No team need registration validation.";

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
    public $searchBy = ["name"];

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
        return Team::with(["category.contest"])
            ->needRegistrationValidation()
            ->whereRelation("category.committees", "committee_id", $this->committee->id)
            ->whereRelation("contest", fn(Builder $query) => $query->periodActive(PeriodType::REGISTRATION_VALIDATION));
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return [
            Header::title("Team ID")->sortBy("id"),
            Header::title("Team Name")->sortBy("name"),
            "Contest",
            "Contest Category"
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row(Team $model): array {
        $category = $model->contestCategory;
        $contest = $category->contest;

        return [
            $model->id,
            $model->name,
            $contest->title,
            $category->title
        ];
    }

    /**
     * Register actions
     *
     * @return  array
     */
    protected function actionsByRow(): array {
        return [
            new RedirectAction($this->actionRoutes . ".edit", "Validate", "file-earmark-ruled")
        ];
    }
}
