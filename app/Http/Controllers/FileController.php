<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\Contest;
use App\Models\ContestCategory;
use App\Models\Team;
use App\Models\Answer;

class FileController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "files";

    /**
     * Handle contest guide file download.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return BinaryFileResponse
     */
    public function contestGuide(Request $request, int $id) {
        $contest = Contest::query()->findOrFail($id);
        $guide = $contest->guide;

        if ($guide->exists()) {
            $path = $guide->getPath();
            return response()->download($path);
        }

        return abort(404, "Contest guide not found.");
    }

    /**
     * Handle contest category guide file download.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return BinaryFileResponse
     */
    public function categoryGuide(Request $request, int $id) {
        $category = ContestCategory::query()->findOrFail($id);
        $guide = $category->guide;

        if ($guide->exists()) {
            $user = Auth::user();

            if ($guide->canBeAccessedBy($user)) {
                $path = $guide->getPath();
                return response()->download($path);
            }

            return abort(403, "Forbidden.");
        }

        return abort(404, "Contest guide not found.");
    }

    /**
     * Handle case download.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return BinaryFileResponse
     */
    public function categoryCase(Request $request, int $id) {
        $category = ContestCategory::query()->findOrFail($id);
        $case = $category->case;

        if ($case->exists()) {
            $user = Auth::user();

            if ($case->canBeAccessedBy($user)) {
                $path = $case->getPath();
                return response()->download($path);
            }

            return abort(403, "Forbidden.");
        }

        return abort(404, "Contest guide not found.");
    }

    /**
     * Handle team registration file download.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return BinaryFileResponse
     */
    public function team(Request $request, int $id) {
        $team = Team::with(["contestCategory", "members"])->findOrFail($id);
        $document = $team->document;

        $user = Auth::user();

        if ($document->canBeAccessedBy($user)) {
            $path = $document->getPath();
            return response()->download($path);
        }

        return abort(403, "Forbidden.");
    }

    /**
     * Handle team answer file download.
     *
     * @param  Request  $request
     * @param  int      $id
     * @return BinaryFileResponse
     */
    public function answer(Request $request, int $id) {
        $answer = Answer::with(["team.contestCategory", "details"])->findOrFail($id);
        $file = $answer->file;

        $user = Auth::user();

        if ($file->canBeAccessedBy($user)) {
            $path = $file->getPath();
            return response()->download($path);
        }

        return abort(403, "Forbidden.");
    }
}
