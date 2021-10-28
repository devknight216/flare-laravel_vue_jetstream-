<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $user = Auth::user();
        $admins = ['tim@onaxim.com'];

        if ($request->ip() !==  '110.141.212.158' && !env('APP_DEBUG')) return redirect(route('view.ftso'));

        if (in_array($user->email, $admins)) {
            if ($user->id === 1) {
                return $next($request);
            }
        }
        return redirect(route('view.ftso'));
    }
}