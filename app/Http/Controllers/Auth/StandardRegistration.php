<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Balance;
use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use App\Notifications\WelcomeOnboardNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StandardRegistration extends Controller
{
    //
    public function standard(){
        return inertia::render('auth.standard');
    }

    public function create(Request  $request){
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $account=Account::create([
            'name'=>$data['name'],
            'type_id'=>1,
            'status_id'=>1,
            'billing_date'=>Carbon::today()->isoFormat('D')
        ]);
        $role=Role::findOrFail(4);
        $permission=Permission::findOrFail(7);
        $user=User::create([
            'name' => $data['name'],
            'last_name'=>$data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'account_id'=>$account->id
        ]);
        $user->administrator()->create([
            'account_id'=>$account->id,
            'slot'=>1
        ]);

        Balance::create([
            'description'=>'Payment for a Standard Account',
            'amount'=>$account->type->price,
            'status'=>'Pending',
            'account_id'=>$account->id,
            'balance_id'=>Str::upper(Str::random(6)),
            'slots'=>1,
            'expires'=>Carbon::today()->addMonth(),
            'balance_type'=>'Full'
        ]);
        $user->assignRole($role);
        $user->givePermissionTo($permission);
        $sources=Source::inRandomOrder()->limit(5)->pluck('id');
        $categories=Category::inRandomOrder()->limit(5)->pluck('id');
        $user->sources()->syncWithoutDetaching($sources);
        $user->categories()->syncWithoutDetaching($categories);
        $user->notify(new WelcomeOnboardNotification());

        Auth::login($user);
        return redirect()->route('payments.index');
    }


}
