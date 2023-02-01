<?php

namespace App\Http\Controllers\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Resources\AccountResource;
use App\Models\Account;
use App\Models\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AccountSetupController extends Controller
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
        $account=$user->account()->latest()->first();
        $min_slots=5;

        $account=new AccountResource(Account::with(['administrator','type'])->findOrFail($account->id));

        return inertia::render('account-setup.index', compact('account','min_slots'));
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
        $validated=$request->validate([
            'members'=>'required|integer|min:5'

        ]);
        $user=Auth::user();
        $account=$user->account->latest()->first();
        $administrator=$account->administrator;

        //check for spoofed members


        $administrator->update(['slot'=>$validated['members']]);

        Balance::create([
            'description'=>'Payment for a '.$account->type->name.' Account '.$administrator->slot.' members',
            'amount'=>$validated['members']*$account->type->price,
            'status'=>'Pending',
            'account_id'=>$account->id,
            'balance_id'=>Str::upper(Str::random(6)),
            'slots'=>$validated['members'],
            'expires'=>Carbon::today()->addMonth(),
            'balance_type'=>'Full'
        ]);

        return redirect()->route('payments.index');


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
}
