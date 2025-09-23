<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class MasterLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array('api', request()->route()->middleware())) {
            return response()->json(['data' => "token failed"]);
        } else {
            $login = Session::get('masterlogin');
            if (empty($login)) {
                return redirect('login');
            }
        }
        return $next($request);
    }
}
