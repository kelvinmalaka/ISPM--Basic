<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller {
  /**
   * Route name of this controller in route definition.
   *
   * @var string 
   */
  const routeNames = "profile";

  /**
   * View path of controller.
   *
   * @var string 
   */
  const viewPath = "profile";

  /**
   * Show the form for editing the specified resource.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index() {
    $user = Auth::user();

    return view(self::viewPath . ".form")
      ->with("action", route(self::routeNames . ".update"))
      ->with("method", "PUT")
      ->with(compact("user"));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(Request $request) {
    $user = Auth::user();
    $data = $request->all([]);

    $this->validate($request, [
      'current_password' => ['required', 'current_password:web'],
      'password' => ['required', 'string', 'min:8', 'confirmed']
    ], [
      'current_password' => "Invalid password"
    ]);

    $user->password = Hash::make($data["password"]);
    $user->save();

    return redirect()
      ->route(self::routeNames . ".index")
      ->with("message", "Password successfully updated!");
  }
}
