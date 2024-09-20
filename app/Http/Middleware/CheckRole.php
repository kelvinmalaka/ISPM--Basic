<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  array|string $roles
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$roles) {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!is_array($roles)) $roles = [$roles];
        if (in_array($request->user()->role, $roles)) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
