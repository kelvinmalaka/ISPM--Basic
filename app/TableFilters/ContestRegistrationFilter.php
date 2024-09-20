<?php

namespace App\TableFilters;

use App\Models\PeriodType;
use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\Filter;

class ContestRegistrationFilter extends Filter {
    /**
     * Title to be rendered in filter box
     *
     * @var string
     */
    protected $title = "Registration Status";

    /**
     * Modify the current query when the filter is used
     *
     * @param  Builder $query Current query
     * @param  $value Value selected by the user
     * @return Builder Query modified
     */
    public function apply(Builder $query, $value, $request): Builder {
        return $value ? $query->periodActive(PeriodType::REGISTRATION) : $query;
    }

    /**
     * Defines the title and value for each option
     *
     * @return Array associative array with the title and values
     */
    public function options(): array {
        return [
            'All' => 0,
            'Opened' => 1
        ];
    }
}
