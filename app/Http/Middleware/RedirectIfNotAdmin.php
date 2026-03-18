<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {  
        if ($request->segment(1) == 'admin') {
            if (!auth()->guard('admin')->check()) {
                return redirect()->route('admin');
            }         
        }else{
            return redirect()->route('home');
        }
        return $next($request);
    }
}
