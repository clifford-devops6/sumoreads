<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Invitation;
use App\Models\Source;
use App\Models\User;
use App\Notifications\WelcomeOnboardNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InvitationController extends Controller
{
    //
    public function invite($id){
        $token=base64_decode($id);
        $invite=Invitation::where('token',$token)->select('id','email','account_id')->firstOrFail();
        $account=Account::select('id','name')->findOrFail($invite->account_id);


        return inertia::render('auth.invitation', compact('invite','account'));
    }

    public function inviteSave(Request $request){
        $validated=$request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'account_id' => ['required', 'integer'],
            'invitation_id'=>['required', 'integer']
        ]);

        $user=User::where('email',$validated['email'])->first();

        if ($user){

            $user->update([
                'account_id'=>$validated['account_id']
            ]);
            $user->syncPermissions([]);
            $user->syncRoles([]);
            $user->givePermissionTo('reader-account');
            $user->assignRole('Reader');
            Auth::guard('web')->login($user);
            $invite=Invitation::findOrFail($validated['invitation_id']);
            $invite->delete();
            return redirect()->route('news.index')
                ->with('status','Welcome back');
        }
        $reader=User::create([
            'name' => $validated['name'],
            'last_name'=>$validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'account_id'=>$validated['account_id']
        ]);
        $role=Role::findById(10);
        $permission=Permission::findOrFail(8);
        $reader->assignRole($role);
        $reader->givePermissionTo($permission);
        $sources=Source::inRandomOrder()->limit(5)->pluck('id');
        $categories=Category::inRandomOrder()->limit(5)->pluck('id');
        $reader->sources()->syncWithoutDetaching($sources);
        $reader->categories()->syncWithoutDetaching($categories);
        $invite=Invitation::findOrFail($validated['invitation_id']);
        $invite->delete();
        $reader->notify(new WelcomeOnboardNotification());
        Auth::guard('web')->login($reader);
        return redirect()->route('news.index');
    }
}
