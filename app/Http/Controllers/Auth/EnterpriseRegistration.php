<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Source;
use App\Models\User;
use App\Notifications\WelcomeOnboardNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class EnterpriseRegistration extends Controller
{
    //
    public function enterprise(){
        return inertia::render('auth.enterprise');
    }

    public function create(Request $request){
        $data=$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        //create account
        $account=Account::create([
            'name'=>$data['name'],
            'type_id'=>2,
            'status_id'=>1,
            'billing_date'=>Carbon::today()->isoFormat('D')

        ]);

        //create company if available
        $account->company()->create([
            'name'=>$data['company_name'],
            'address'=>$data['address'],
            'city'=>$data['city'],
            'country'=>$data['country']
        ]);

        //save user to db
        $user=User::create([
            'name' => $data['name'],
            'last_name'=>$data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'account_id'=>$account->id
        ]);
        $user->administrator()->create([
            'account_id'=>$account->id,
            'slot'=>5
        ]);

        $role=Role::findOrFail(9);
        $permission=Permission::findOrFail(6);
        $user->assignRole($role);
        $user->givePermissionTo($permission);
        $sources=Source::inRandomOrder()->limit(5)->pluck('id');
        $categories=Category::inRandomOrder()->limit(5)->pluck('id');
        $user->sources()->syncWithoutDetaching($sources);
        $user->categories()->syncWithoutDetaching($categories);
        $user->notify(new WelcomeOnboardNotification());
        Auth::login($user);
        return redirect()->route('account-setup.index');
    }
}
