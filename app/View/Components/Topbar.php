<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RoleSwitchController;
use App\View\RoleRoutes;

class Topbar extends Component {
    /**
     * The attributes to hold user.
     *
     * @var \App\Models\User;
     */
    public $user;

    /**
     * The attributes to hold routes.
     *
     * @var array
     */
    public $routes;

    /**
     * The attributes to role switch route.
     *
     * @var string
     */
    public $roleRoute;

    /**
     * The attributes to hold profile route.
     *
     * @var string
     */
    public $profileRoute;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct() {
        $user = auth()->user();
        $role = auth()->check() && $user->hasCurrentRole() ? $user->currentRole->name : null;
        $routes = RoleRoutes::getRoute($role);

        $this->user = $user;
        $this->routes = $routes;
        $this->roleRoute = RoleSwitchController::routeNames . ".index";
        $this->profileRoute = ProfileController::routeNames . ".index";
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render() {
        return view('layouts.components.topbar');
    }
}
