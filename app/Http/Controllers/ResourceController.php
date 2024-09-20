<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceController extends Controller {
    /**
     * Route name of this controller in route definition.
     *
     * @var string 
     */
    const routeNames = "";

    /**
     * View path of controller.
     *
     * @var string 
     */
    const viewPath = "";

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
        return view(self::viewPath . ".form")
            ->with("action", route(self::routeNames . ".store"))
            ->with("method", "POST");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request) {
        return redirect()
            ->route(self::routeNames . ".index")
            ->with("message", "Created!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(int $id) {
        return view(self::viewPath . ".show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(int $id) {
        return view(self::viewPath . ".form")
            ->with("action", route(self::routeNames . ".update", [$id]))
            ->with("method", "PUT");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $id) {
        return redirect()
            ->route(self::routeNames . ".index")
            ->with("message", "Updated!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
        return redirect()
            ->route(self::routeNames . ".index")
            ->with("message", "Deleted!");
    }
}
