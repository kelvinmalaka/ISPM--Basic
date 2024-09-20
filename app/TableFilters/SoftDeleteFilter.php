<?php

namespace App\TableFilters;

use Illuminate\Database\Eloquent\Builder;
use LaravelViews\Filters\Filter;

class SoftDeleteFilter extends Filter {
    /**
     * Title to be rendered in filter box
     *
     * @var string
     */
    protected $title = "Active Status";

    /**
     * Filter constructor
     *
     * @var string
     */
    public function __construct(string $title = null) {
        parent::__construct();

        if ($title) $this->title = $title;
    }

    /**
     * Modify the current query when the filter is used
     *
     * @param   Builder $query Current query
     * @param   $value  Value selected by the user
     * @return  Builder Query modified
     */
    public function apply(Builder $query, $value, $request): Builder {
        return $query->trashed($value);
    }

    /**
     * Defines the title and value for each option
     *
     * @return Array associative array with the title and values
     */
    public function options(): array {
        return [
            'Active' => 1,
            'Inactive' => 0
        ];
    }
}
