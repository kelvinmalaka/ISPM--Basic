<?php

namespace App\Http\Controllers\Contest;

use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contest\StorePeriodRequest;
use App\Models\Contest;
use App\Models\Period;
use App\Models\PeriodType;

class PeriodManagementController extends Controller {
  /**
   * Route name of this controller in route definition.
   *
   * @var string 
   */
  const routeNames = "contests_periods";

  /**
   * View path of controller.
   *
   * @var string 
   */
  const viewPath = "contests.periods";

  /**
   * Display a listing of the resource.
   *
   * @param  Contest  $contest
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index(Contest $contest) {
    $this->authorize("manage", $contest);

    $contest->load("periods.type");
    $periods = $contest->periods;

    $previousURL = URLHelper::getFormPreviousUrl();

    return view(self::viewPath . ".form")
      ->with("back", $previousURL)
      ->with("action", route(self::routeNames . ".store", ["contest" => $contest]))
      ->with("method", "POST")
      ->with("periods", $periods);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  StorePeriodRequest $request
   * @param  Contest  $contest
   * @return \Illuminate\Http\RedirectResponse
   */
  public function store(StorePeriodRequest $request, Contest $contest) {
    $this->authorize("manage", $contest);

    $contest->load("periods.type");

    $data = $request->safe()->all();
    $previousURL = URLHelper::getFormPreviousUrl();

    $periods = [];

    foreach ($data["periods"] as $inputPeriod) {
      $openedAt = $inputPeriod["opened_at"];
      $closedAt = $inputPeriod["closed_at"];

      if (is_null($openedAt) || is_null($closedAt)) continue;

      $type = PeriodType::find($inputPeriod["id"]);
      $period = Period::query()->whereBelongsTo($contest, "contest")->whereBelongsTo($type, "type")->first();

      $period->opened_at = $openedAt;
      $period->closed_at = $closedAt;

      $periods[] = $period;
    }

    $contest->periods()->saveMany($periods);

    return redirect()
      ->to($previousURL)
      ->with("message", "Contest period created!");
  }
}
