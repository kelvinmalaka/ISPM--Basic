<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Helpers\URLHelper;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleSwitchController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "role_switch";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "auth.role_switch";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $user = auth()->user()->load("roles");

        if (!$user->hasCurrentRole() || $user->hasMultipleRoles()) {
            $previousURL = URLHelper::getFormPreviousUrl();

            $roles = $user->roles->map(function ($role) {
                $role->route = route(self::routeNames . ".store", $role->name);
                return $role;
            });

            return view(self::viewPath . ".index")
                ->with("back", $previousURL)
                ->with(compact("roles"));
        }

        return redirect()->route("application");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, string $role) {
        $user = auth()->user()->load("roles");

        if (!$user->hasRole($role)) {
            abort(404);
        }

        $role = Role::findByName($role);
        $user->update(["current_role_id" => $role->id]);

        return redirect()
            ->route("application")
            ->with("message", "Role changed");
    }
}
