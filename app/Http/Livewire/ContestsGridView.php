<?php

namespace App\Http\Livewire;

use App\Http\Controllers\ContestController;
use App\Models\Contest;
use App\Models\PeriodType;
use App\TableFilters\ContestRegistrationFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use LaravelViews\Views\GridView;

class ContestsGridView extends GridView {
    /**
     * Override default card component
     *
     * @var string
     */
    public $cardComponent = 'components.contest_card';

    /**
     * Sets max card to show in a row
     *
     * @var int
     */
    public $maxCols = 1;

    /**
     * Sets searchable cards
     *
     * @var array
     */
    public $searchBy = ['title'];

    /**
     * Sets data count in each page
     * 
     * @var  int
     */
    protected $paginate = 5;

    /**
     * Sets sort cards
     *
     * @return array
     */
    public function sortableBy(): array {
        return [
            'Title' => 'title'
        ];
    }

    /**
     * Sets a initial query with the data to fill the table
     *
     * @return Builder Eloquent query
     */
    public function repository(): Builder {
        return Contest::query()
            ->with(["categories", "periods"])
            ->published()
            ->latest();
    }

    /**
     * Sets the data to every card on the view
     *
     * @param  Contest  $model Current model for each card
     * @return array
     */
    public function card(Contest $contest): array {
        $registration = $contest->period(PeriodType::REGISTRATION);

        return [
            'image' => $contest->banner_img_path,
            'title' => $contest->title,
            'description' => $contest->description,
            'categories' => $contest->categories,
            'registration_open' => Carbon::toDateLocale($registration->opened_at),
            'registration_close' => Carbon::toDateLocale($registration->closed_at),
            'route_detail' => route(ContestController::routeNames . ".show", ["contest" => $contest])
        ];
    }

    /**
     * Register filters
     *
     * @return  array
     */
    protected function filters(): array {
        return [
            new ContestRegistrationFilter()
        ];
    }
}
