<?php

namespace App\Http\Controllers\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\GroupResource;
use App\Models\Account;
use App\Models\Group;
use App\Models\Invitation;
use App\Models\User;
use App\Notifications\CancelSubscription;
use App\Notifications\MemberOnboard;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ManageAccountcontroller extends Controller
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
        $groups=GroupResource::collection(Group::where('account_id',$account->id)->with(['users','categories','sources'])->get());
        $account=new AccountResource(Account::with(['users','administrator','invitations'])->findOrFail($account->id));

        return inertia::render('account.manage.index', compact('account', 'groups'));
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

    public function sendInvitation(Request $request){
        $validated=$request->validate([
            'account_id'=>'required|integer',
            'email'=>'required|email|string|max:100'
        ]);
       $user=User::where('email',$validated['email'])->first();
       if ($user){
           if ($role=$user->getRoleNames()->first()){
               /*Ensure that invitation can only be sent to a free user or user not registered
                Enterprise users are responsible for managing enterprise accounts.
                Readers belong to an enterprise account
               */

               if ($role==='Enterprise' OR $role==='Reader' ){
                   return redirect()->back()
                       ->withErrors([
                           'email'=>'The use is already registered as enterprise user'
                       ])->onlyInput('email');
               }
           }
       }

       $invite=Invitation::create([
           'account_id'=>$validated['account_id'],
           'email'=>$validated['email'],
           'token'=>Str::random(16)
       ]);
        $invite->notify(new MemberOnboard($invite));
        return redirect()->back()
            ->with('status','Invitation successfully sent');
    }

    public function removeUser($id){

     $user=User::findOrFail($id);
        $account=Account::create([
            'name'=>$user->name,
            'type_id'=>5,
            'status_id'=>1,
            'billing_date'=>Carbon::today()->isoFormat('D')
        ]);
        $user->update([
            'account_id'=>$account->id
        ]);
        $user->syncPermissions([]);
        $user->syncRoles([]);
        $user->givePermissionTo('free-account');
        $user->assignRole('Free');
        $user->notify(new CancelSubscription());
        return redirect()->back()
            ->with('status','Subscription cancelled successfully');
    }

    public function deleteInvite($id){
        $invite=Invitation::findOrFail($id);
        $invite->delete();
        return redirect()->back()
            ->with('status','Invitation successfully deleted');
    }
}
