<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Http\Resources\UserResource;
use App\Models\Account;
use App\Models\Balance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AccountSubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=new UserResource(User::findOrFail(Auth::id()));
        $account=Auth::user()->account()->first();
        $account=Account::select('id','name','type_id')->withCount(['users','invitations','groups'])->with(['administrator','type'])->findOrFail($account->id);
        $token=$account->tokens()->where('expiry','>',Carbon::today())->latest()->firstOrFail();
        return inertia::render('account.subscription.index', compact('user', 'account','token'));
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

    public function payNow(Request $request){
        $validate=$request->validate([
            'package'=>'required|integer'
        ]);
        $account=Account::findOrFail($request->account_id);
        $administrator=$account->administrator->first();
        $amount=$administrator->slot*$request->package*$account->type->price;

        Balance::create([
            'description'=>'Payment for a '.$account->type->name.' Account '.$administrator->slot.' members',
            'amount'=>$amount,
            'status'=>'Pending',
            'account_id'=>$account->id,
            'balance_id'=>Str::upper(Str::random(6)),
            'slots'=>$administrator->slot,
            'expires'=>Carbon::today()->addMonth(),
            'balance_type'=>'Full'
        ]);

        return redirect()->route('payments.index');
    }

    public function addSlot(Request $request){
        $validated=$request->validate([
            'account_id'=>'required|integer',
            'slots'=>'required|integer'
        ]);
        $account=Account::findOrFail($validated['account_id']);
        $administrator=$account->administrator->latest()->first();
        $token=$account->tokens()->where('expiry','>',Carbon::today())->latest()->firstOrFail();

        $period=Carbon::today()->diffInDays(Carbon::parse($token->expiry));
        $amount=$period*$account->type->price/30;
        $total_amount=number_format($amount*$validated['slots'],2);

        //create a balance for the account
        $administrator->update(['slot'=>$administrator->slot+$validated['slots']]);


        Balance::create([
            'description'=>'Payment for an Additional '.$validated['slots'].' slots',
            'amount'=>$total_amount,
            'status'=>'Pending',
            'account_id'=>$account->id,
            'balance_id'=>Str::upper(Str::random(6)),
            'expires'=>Carbon::parse($token->expiry),
            'slots'=>$validated['slots'],
            'balance_type'=>'Additional'
        ]);

        return redirect()->route('payments.index');
    }
}
