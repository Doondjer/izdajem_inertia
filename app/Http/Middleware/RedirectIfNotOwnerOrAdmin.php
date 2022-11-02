<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RedirectIfNotOwnerOrAdmin
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
        $listing = $request->route()->parameter('listing');

        if( $listing && ! $listing->isOwner(Auth::user())) {
            if( ! Auth::user() || ( Auth::user() && ! Auth::user()->isAdmin() ) ) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Unauthorised.'], 403);
                }

                return redirect(RouteServiceProvider::HOME)->withErrors(['error' => 'Nemate dozvolu za ovu aktivnost']);
            }

        }

        return $next($request);
    }
}
