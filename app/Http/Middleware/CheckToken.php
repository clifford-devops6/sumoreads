<?php

namespace App\Http\Middleware;

use App\Models\Token;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckToken
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
        $user=Auth::user();
        $role=$user->getRoleNames()->first();
        if ($role==='Enterprise'){
            $token =Token::where('account_id',$user->account_id)->where('expiry', '>=', Carbon::today())->first();
            if (!$token){
                return redirect()->route('account-setup.index');
            }
        }
        return $next($request);
    }
}
