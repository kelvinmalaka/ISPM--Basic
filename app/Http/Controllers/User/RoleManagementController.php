<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Helpers\URLHelper;
use App\Http\Requests\User\StoreRoleRequest;
use App\Models\Role;
use App\Models\User;

class RoleManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "users.roles";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "users.roles";

    /**
     * Show the form for creating a new resource.
     *
     * @param  int  $userId
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create(int $userId) {
        $user = User::with("roles")->findOrFail($userId);
        $existedRoles = $user->roles()->get()->pluck("id");

        $roles = Role::query()->whereNotIn("id", $existedRoles)->get();
        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store", ["user" => $userId]))
            ->with("method", "POST")
            ->with("roles", $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRoleRequest $request
     * @param  int  $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRoleRequest $request, int $userId) {
        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $user = User::with("roles")->findOrFail($userId);
        $user->attachRole($data["role"]);

        return redirect()
            ->to($previousURL)
            ->with("message", "New role sucessfully attached!");
    }
}
