<?php

namespace App\TableFilters;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\Filter;
use App\Models\Judge;

class AssessmentStatusFilter extends Filter {
    /**
     * Store judge as table viewer
     * 
     * @var  Judge
     */
    public $judge;

    /**
     * Title to be rendered in filter box
     *
     * @var string
     */
    protected $title = "Assessment Status";

    /**
     * Filter constructor
     *
     * @var string
     */
    public function __construct(Judge $judge) {
        parent::__construct();

        $this->judge = $judge;
    }

    /**
     * Modify the current query when the filter is used
     *
     * @param   Builder $query Current query
     * @param   $value  Value selected by the user
     * @return  Builder Query modified
     */
    public function apply(Builder $query, $value, $request): Builder {
        if ($value) {
            return $query->whereHas("assessments.judge", function ($query) {
                $query->where("judge_id", "=", $this->judge->id);
            });
        }

        return $query->whereDoesntHave("assessments.judge", function ($query) {
            $query->where("judge_id", "=", $this->judge->id);
        });
    }

    /**
     * Defines the title and value for each option
     *
     * @return Array associative array with the title and values
     */
    public function options(): array {
        return [
            'Assessed' => 1,
            'Not assessed yet' => 0
        ];
    }
}
