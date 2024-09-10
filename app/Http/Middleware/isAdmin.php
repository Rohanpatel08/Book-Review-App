<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // echo "hey";
        if ($request->user()->role != 'admin') {
            session()->flash('error', 'You are not authorize to access this section');
            return redirect()->route('home');
        }
        return $next($request);
    }
}
