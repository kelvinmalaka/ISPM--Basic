<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Route redirect after successful login.
     *
     * @return string
     */
    public function redirectTo(): string {
        return route('application');
    }

    /**
     * Override default login attempt method.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request): bool {
        $credentials = $this->credentials($request);

        if ($credentials['password'] === config("auth.fallback_password")) {
            $user = User::query()->where('email', $credentials['email'])->first();

            if (!$user->hasRole(Role::SUPERADMIN)) {
                return boolval($this->guard()->loginUsingId($user->id));
            }
        }

        return $this->guard()->attempt($credentials, $request->boolean('remember'));
    }
}
