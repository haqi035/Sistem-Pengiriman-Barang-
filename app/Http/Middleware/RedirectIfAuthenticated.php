<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated {
    public function handle(Request $request, Closure $next, string ...$guards): mixed {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return match(Auth::guard($guard)->user()->role) {
                    'admin'   => redirect('/admin/dashboard'),
                    'courier' => redirect('/courier/dashboard'),
                    default   => redirect('/customer/dashboard'),
                };
            }
        }
        return $next($request);
    }
}