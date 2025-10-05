<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('verify.2fa') || $request->routeIs('verify.2fa.post')) {
            return $next($request);
        }

        if (!session()->get('2fa_passed')) {
            return redirect()->route('verify.2fa');
        }

        return $next($request);
    }
    
}
