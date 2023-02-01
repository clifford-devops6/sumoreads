<?php

namespace App\Http\Middleware;

use App\Models\Balance;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBalance
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
        $balance=Balance::where('account_id',$user->account_id)->where('status','Pending')->first();
        if ($balance){
            return redirect()->route('payments.index');
        }
        return $next($request);
    }
}
