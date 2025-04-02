<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AntrenorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('antrenor_id')) {
            return redirect()->route('login')->with('error', 'Acces restricționat. Vă rugăm să vă autentificați ca antrenor.');
        }

        return $next($request);
    }
}