<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Auth\RoleSwitchController;
use App\Http\Controllers\Assessment\AssessmentController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\Contest\ContestManagementController;
use App\Http\Controllers\Validate\RegistrationController;
use App\Models\Contest;
use App\Models\Role;

class HomeController extends Controller {
    /**
     * Show the homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $contests = Contest::with(["categories", "periods"])->published()->latest()->limit(3)->get();

        return view('public.landing')
            ->with("contests", $contests)
            ->with("contests_path", ContestController::routeNames);
    }

    /**
     * Redirect authenticated user to their default route.
     *
     */
    public function application() {
        if (!Auth::check())
            return redirect()->route('login');

        $user = auth()->user();
        if ($user->hasCurrentRole()) {
            $role = $user->role;

            $default_routes = [
                Role::SUPERADMIN => ContestManagementController::routeNames . ".index",
                Role::ADMIN => ContestManagementController::routeNames . ".index",
                Role::JUDGE => AssessmentController::routeNames . ".index",
                Role::COMMITTEE => RegistrationController::routeNames . ".index",
                Role::CONTESTANT => ContestController::routeNames . ".index"
            ];

            return redirect()->route($default_routes[$role]);
        }

        return redirect()->route(RoleSwitchController::routeNames . ".index");
    }
}
