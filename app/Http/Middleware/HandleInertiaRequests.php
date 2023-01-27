<?php

namespace App\Http\Middleware;

use App\Models\ReadStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Readlist;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return vite()->getHash();
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        if (Auth::user()){
            $auth=[
                'role'=>Auth::user()->getRoleNames()->first(),
                'name'=>Auth::user()->name,
                'last_name'=>Auth::user()->last_name,
                'email'=>Auth::user()->email,
                'id'=>Auth::id(),
                'account_id'=>Auth::user()->account_id,
            ];

            $readlist=Readlist::where('user_id',Auth::id())->where('read_status',0)->count();
            $reads=ReadStatus::where('user_id',Auth::id())->pluck('share_id');
            $shares=Auth::user()->shares()->whereNotIn('id',$reads)->count();

        }else{
            $auth=null;
            $readlist=0;
            $shares=0;
        }
        return array_merge(parent::share($request), [
            'auth' =>$auth,
            'readlist'=>$readlist,
            'shares'=>$shares,
            'status' => $request->session()->get('status')?$request->session()->get('status'):null,
        ]);
    }
}
