<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsHQ
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->master_user()->role !== '1') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            } else {
                auth()->logout();
                return redirect('/');
            }
        }

        return $next($request);
    }
}
