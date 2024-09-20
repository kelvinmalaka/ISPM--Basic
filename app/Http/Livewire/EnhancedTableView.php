<?php

namespace App\Http\Livewire;

use LaravelViews\Views\TableView;
use LaravelViews\Data\QueryStringData;

abstract class EnhancedTableView extends TableView {
    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title;

    /**
     * Sets route prefix for actions
     * 
     * @var  string|null
     */
    protected $actionRoutes;

    /**
     * Store manage action
     * 
     * @var  array|null
     */
    public $manageAction;

    /**
     * Hide pagination
     * 
     * @var  bool
     */
    public $hidePagination = false;

    /**
     * Sets word to be displayed when no data is available
     * 
     * @var  string|null
     */
    public $emptyDataWords;

    /**
     * Sets word to be displayed in result row
     * 
     * @var  array|null
     */
    public $results;

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    abstract protected function load($args): void;

    /**
     * Override default laravel-views mount method
     * 
     * @return  void
     */
    public function mount(QueryStringData $queryStringData, ...$args) {
        parent::mount($queryStringData);
        if (method_exists($this, "load")) $this->load($args);
        if (method_exists($this, "results")) $this->results = $this->results();
    }

    /**
     * Render results row
     * 
     * @return  array
     */
    public function results(): array {
        return [];
    }
}
