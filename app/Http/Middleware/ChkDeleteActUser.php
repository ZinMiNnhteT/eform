<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;

class ChkDeleteActUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->token;
        $user = JWTAuth::authenticate($request->token);
        if ($user->delete_status) {
            return response()->json([
                'success'       => false,
                'title'         => 'Unauthorized',
                'message'       => 'Your account had been deleted! Login with other account',
            ], 401);
        }elseif(!$user->active){
            return response()->json([
                'success'       => false,
                'title'         => 'Unauthorized',
                'message'       => 'Your account had been blocked for some reason!',
            ], 401);
        }
        return $next($request);
    }
}
