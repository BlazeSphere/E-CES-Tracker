<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Do not block the logout action
        if ($request->is('logout') || $request->routeIs('logout')) {
            return $next($request);
        }

        if (Auth::check() && Auth::user()->status === 'inactive' && !$request->routeIs('account.locked')) {
            return redirect()->route('account.locked');
        }

        return $next($request);
    }
}
