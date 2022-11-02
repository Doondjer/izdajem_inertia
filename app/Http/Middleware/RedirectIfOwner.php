<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

class RedirectIfOwner
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

        if( $listing && $listing->isOwner(Auth::user())) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorised.'], 403);
            }

            return redirect(RouteServiceProvider::HOME)->withErrors(['error' => 'Nemate dozvolu za ovu aktivnost']);
        }

        return $next($request);
    }
}
