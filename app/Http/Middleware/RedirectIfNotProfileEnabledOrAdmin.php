<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RedirectIfNotProfileEnabledOrAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->route()->parameter('user');

        if( ! Auth::user() || ( Auth::user() && ! Auth::user()->isAdmin() ) ) {
            if (!$user || !$user->show_profile) {
                return redirect(RouteServiceProvider::HOME)->withErrors(['error' => 'Nemate dozvolu za ovu aktivnost']);
            }
        }

        return $next($request);
    }
}
