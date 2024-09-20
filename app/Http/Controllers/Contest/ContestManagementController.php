<?php

namespace App\Http\Controllers\Contest;

use App\Exports\ContestReportExport;
use App\Helpers\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contest\StoreContestRequest;
use App\Http\Requests\Contest\UpdateContestRequest;
use App\Models\Administrator;
use App\Models\Contest;
use App\Models\Period;
use App\Models\PeriodType;
use App\Models\Role;
use Maatwebsite\Excel\Facades\Excel;

class ContestManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "contests";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "contests.contests";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = auth()->user();

        $table = [];
        if ($user->can("create", Contest::class)) $table["allowCreate"] = true;
        if ($user->role === Role::ADMIN) $table["administrator"] = $user->userable("administrator");

        return view(self::viewPath . ".index")
            ->with("table", $table);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create() {
        $this->authorize("create", Contest::class);

        $title = "Create Contest";
        $contest = new Contest();
        $administrators = Administrator::all();

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store"))
            ->with("method", "POST")
            ->with("title", $title)
            ->with("contest", $contest)
            ->with("administrators", $administrators);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreContestRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreContestRequest $request) {
        $this->authorize("create", Contest::class);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $contest = new Contest();
        $administrator = Administrator::findOrFail($data["administrator"]);
        $contest->title = $data["title"];
        $contest->description = $data["description"];
        $contest->administrator()->associate($administrator);

        if (array_key_exists("guide_file", $data)) {
            $guide_file = $request->file("guide_file");
            $guide_file_path = $guide_file->storeAs("contests", $guide_file->getClientOriginalName());

            $contest->guide_file_path = $guide_file_path;
        }

        if (array_key_exists("banner_img", $data)) {
            $banner_img = $request->file("banner_img");
            $banner_file_name = "contests/" . $banner_img->getClientOriginalName();

            $banner_img->storePubliclyAs("public/", $banner_file_name);
            $contest->banner_img_path = "storage/" . $banner_file_name;
        }

        $contest->save();

        $periods = [];
        foreach (PeriodType::all() as $type) {
            $period = Period::make()->type()->associate($type);
            $periods[] = $period;
        }

        $contest->periods()->saveMany($periods);

        return redirect()
            ->to($previousURL)
            ->with("message", "Contest created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  Contest  $contest
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(Contest $contest) {
        $this->authorize("manage", $contest);

        $contest->load(["periods.type", "administrator"]);

        $periods = $contest->periods;
        $administrator = $contest->administrator;

        return view(self::viewPath . ".show")
            ->with("back", route(self::routeNames . ".index"))
            ->with("contest", $contest)
            ->with("periods", $periods)
            ->with("administrator", $administrator);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Contest  $contest
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(Contest $contest) {
        $this->authorize("manage", $contest);

        $contest->load(["periods.type", "administrator"]);

        $title = "Edit Contest";
        $administrators = Administrator::all();

        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".update", ["contest" => $contest]))
            ->with("method", "PUT")
            ->with("title", $title)
            ->with("contest", $contest)
            ->with("administrators", $administrators);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateContestRequest  $request
     * @param  Contest  $contest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateContestRequest $request, Contest $contest) {
        $this->authorize("manage", $contest);

        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $contest->title = $data["title"];
        $contest->description = $data["description"];

        if (array_key_exists("administrator", $data)) {
            $administrator = Administrator::findOrFail($data["administrator"]);
            $contest->administrator()->associate($administrator);
        }

        if (array_key_exists("guide_file", $data)) {
            $guide_file = $request->file("guide_file");
            $guide_file_path = $guide_file->storeAs("contests", $guide_file->getClientOriginalName());

            $contest->guide_file_path = $guide_file_path;
        }

        if (array_key_exists("banner_img", $data)) {
            $banner_img = $request->file("banner_img");
            $banner_file_name = "contests/" . $banner_img->getClientOriginalName();

            $banner_img->storePubliclyAs("public/", $banner_file_name);
            $contest->banner_img_path = "storage/" . $banner_file_name;
        }

        $contest->save();

        return redirect()
            ->to($previousURL)
            ->with("message", "Contest updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contest  $contest
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contest $contest) {
        $this->authorize("manage", $contest);

        try {
            $contest->delete();

            return redirect()
                ->route(self::routeNames . ".index")
                ->with("message", "Contest deleted!");
        } catch (\Exception $e) {

            return redirect()
                ->route(self::routeNames . ".index")
                ->with("error", $e->getMessage());
        }
    }

    /**
     * Export contest report.
     *
     * @param  Contest  $contest
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function report(Contest $contest) {
        $this->authorize("manage", $contest);

        $filename = $contest->title . " Report." . now() . ".xlsx";
        return Excel::download(new ContestReportExport($contest), $filename);
    }
}
