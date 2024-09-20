<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Helpers\URLHelper;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "users";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "users.manage";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view(self::viewPath . ".index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create() {
        $roles = Role::all();
        $previousURL = URLHelper::getFormPreviousUrl();

        return view(self::viewPath . ".form")
            ->with("back", $previousURL)
            ->with("action", route(self::routeNames . ".store"))
            ->with("method", "POST")
            ->with("roles", $roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request) {
        $data = $request->safe()->all();
        $previousURL = URLHelper::getFormPreviousUrl();

        $user = [
            "name" => $data["name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"]),
        ];

        User::createUser($data["role"], $user);

        return redirect()
            ->to($previousURL)
            ->with("message", "New user created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(int $id) {
        $user = User::with(["roles", "currentRole"])->withTrashed()->findOrFail($id);

        return view(self::viewPath . ".show")
            ->with("back", route(self::routeNames . ".index"))
            ->with("user", $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()
            ->route(self::routeNames . ".index")
            ->with("message", "User deactivated!");
    }
}
