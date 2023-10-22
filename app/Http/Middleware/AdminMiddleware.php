<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role == Role::superadmin() or auth()->user()->role == Role::admin()) {
            return $next($request);
        } else {
            auth()->logout();
            return back()->with('fail', 'Nemate permisiju');
        }
    }
}
