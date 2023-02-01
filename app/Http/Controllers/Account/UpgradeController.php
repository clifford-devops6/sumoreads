<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Balance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UpgradeController extends Controller
{
    //

    public function initiateUpgrade(Request $request,$id){

        $validated=$request->validate([
            'members'=>'required|integer|min:5',
            'price'=>'required'
        ]);


        $account=Account::findOrFail($id);
        $administrator=$account->administrator;
        $administrator->update(['slot'=>$validated['members']]);
        Balance::create([
            'description'=>'Payment for a Enterprise Account '.$validated['members'].' members',
            'amount'=>$validated['price']*$validated['members'],
            'status'=>'Pending',
            'account_id'=>$account->id,
            'balance_id'=>Str::upper(Str::random(6)),
            'slots'=>$validated['members'],
            'expires'=>Carbon::today()->addMonth(),
            'balance_type'=>'Conversion-Enterprise'
        ]);
       return redirect()->route('payments.index');
    }
}
