<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AccountDeletionCheck
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
        $user = Auth::user();
        if ($user->delete_status) {
            return response()->view('auth.accountDeletion.delete_noti');
        }
        return $next($request);
    }
}
