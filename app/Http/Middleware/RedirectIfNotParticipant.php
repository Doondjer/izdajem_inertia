<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class RedirectIfNotParticipant
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
        $thread = $request->route()->parameter('thread');

        if(  ! $thread->isAuthParticipant()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorised.'], 403);
            }

            return redirect(RouteServiceProvider::HOME)->withErrors(['error' => 'Nemate dozvolu za ovu aktivnost']);
        }

        return $next($request);
    }
}
