<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class EnsureDefaultPasswordUpdated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if (auth()->check() && $request->user()->is_default_password_updated == 0) {
            // Redirect...
           return redirect('reset-password');

           // dd("goto reset page");
        }
        else
        {
           return $next($request);

           // dd("goto login page");
        }
 
    }
}
