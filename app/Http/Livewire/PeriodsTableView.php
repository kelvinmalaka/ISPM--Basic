<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use App\Http\Livewire\EnhancedTableView;
use App\Models\Contest;
use App\Models\Period;

class PeriodsTableView extends EnhancedTableView {
    /**
     * Store period's contest
     * 
     * @var  Contest
     */
    public $contest;

    /**
     * Store table title
     * 
     * @var  string|null
     */
    public $title = "Contest Periods";

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
    public $hidePagination = true;

    /**
     * Run on component load
     * 
     * @param   $args
     * @return  void
     */
    protected function load($args): void {
        $contest = $this->contest;

        $this->manageAction = [
            "route" => route("contests_periods.index", ["contest" => $contest->id]),
            "text" => "Manage",
            "icon" => "gear"
        ];
    }

    /**
     * Sets a query to get the initial data
     * 
     * @return  Builder
     */
    public function repository(): Builder {
        return Period::with("type")->whereBelongsTo($this->contest);
    }

    /**
     * Sets the headers of the table as you want to be displayed
     *
     * @return array<string> Array of headers
     */
    public function headers(): array {
        return [
            "Period Type",
            "Opened At",
            "Closed At"
        ];
    }

    /**
     * Sets the data to every cell of a single row
     *
     * @param $model Current model for each row
     */
    public function row($model): array {
        return [
            $model->type->title,
            Carbon::toLocale($model->opened_at),
            Carbon::toLocale($model->closed_at)
        ];
    }
}
