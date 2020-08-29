<?php

namespace App\Http\Middleware;

use Closure;

class PositionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(auth()->user()->posisi == 'owner'){

            return $next($request);

        }

        return redirect()->route('admin.home')->with('error',"You don't have owner access.");
    }
}