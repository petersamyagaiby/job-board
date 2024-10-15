<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
class CheckUserType
{

    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user || $user->type !== $role) {
            return redirect()->route('home')->with('error', 'You\'r not authorized.');
        }

        return $next($request);
    }
}
