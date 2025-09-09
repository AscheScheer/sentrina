<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class staff
{
    /**
     * Error message for unauthorized staff access.
     */
    private const ERROR_MESSAGE = 'You must be logged in as staff to access this page.';

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      if (!auth()->guard('staff')->check()) {
            return redirect('/staff/login')->with('error', self::ERROR_MESSAGE);
        }
        return $next($request);
    }}

