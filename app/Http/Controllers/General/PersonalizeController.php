<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PersonalizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=Auth::user();
        $account=Auth::user()->account()->first();
        $account=new AccountResource(Account::with(['sources','categories',])->findOrFail($account->id));
        $user=new UserResource(User::with('categories','sources')->findOrFail(Auth::id()));

        return inertia::render('account.personalize.index',compact('account','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addEnterprise(Request $request){
        $validated=$request->validate([
            'account_id'=>'required|integer',
            'ids'=>'required|array'
        ]);

        $account=Account::findOrFail($validated['account_id']);
        $account->sources()->syncWithoutDetaching($validated['ids']);
        return redirect()->back()
            ->with('status','Sources successfully added to enterprise account');

    }

    public function removeEnterprise(Request $request){
        $validated=$request->validate([
            'account_id'=>'required|integer',
            'ids'=>'required|array'
        ]);

        $account=Account::findOrFail($validated['account_id']);
        $account->sources()->detach($validated['ids']);
        return redirect()->back()
            ->with('status','Sources successfully removed from enterprise account');

    }
    //personal sources

    public function addSource(Request $request){
        $validated=$request->validate([
            'user_id'=>'required|integer',
            'ids'=>'required|array'
        ]);

        $user=User::findOrFail($validated['user_id']);
        $user->sources()->syncWithoutDetaching($validated['ids']);
        return redirect()->back()
            ->with('status','Sources successfully saved');

    }

    public function removeSource(Request $request){
        $validated=$request->validate([
            'user_id'=>'required|integer',
            'ids'=>'required|array'
        ]);

        $user=User::findOrFail($validated['user_id']);
        $user->sources()->detach($validated['ids']);
        return redirect()->back()
            ->with('status','Sources successfully removed');

    }

    //enterprise categories

    public function addCategory(Request $request){
        $validated=$request->validate([
            'account_id'=>'required|integer',
            'ids'=>'required|array'
        ]);

        $account=Account::findOrFail($validated['account_id']);
        $account->categories()->syncWithoutDetaching($validated['ids']);
        return redirect()->back()
            ->with('status','Categories successfully added to enterprise account');

    }

    public function removeCategory(Request $request){
        $validated=$request->validate([
            'account_id'=>'required|integer',
            'ids'=>'required|array'
        ]);

        $account=Account::findOrFail($validated['account_id']);
        $account->categories()->detach($validated['ids']);
        return redirect()->back()
            ->with('status','Categories successfully removed from enterprise account');

    }

    public function addCategoryPersonal(Request $request){
        $validated=$request->validate([
            'user_id'=>'required|integer',
            'ids'=>'required|array'
        ]);

        $user=User::findOrFail($validated['user_id']);
        $user->categories()->syncWithoutDetaching($validated['ids']);
        return redirect()->back()
            ->with('status','Sources successfully saved');

    }

    public function removeCategoryPersonal(Request $request){
        $validated=$request->validate([
            'user_id'=>'required|integer',
            'ids'=>'required|array'
        ]);

        $user=User::findOrFail($validated['user_id']);
        $user->categories()->detach($validated['ids']);
        return redirect()->back()
            ->with('status','Sources successfully removed');

    }
}
