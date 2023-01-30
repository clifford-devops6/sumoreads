<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Category;
use App\Models\Source;
use App\Models\Type;
use App\Models\User;
use App\Models\Verify;
use App\Notifications\PasswordResetNotification;
use App\Notifications\WelcomeOnboardNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    //

    public function login(){
        return inertia::render('auth.login');
    }

    public function pricing(){
        $free=Type::where('name','Free')->select('id','name','price')->first();
        $standard=Type::where('name','Standard')->select('id','name','price')->first();
        $enterprise=Type::where('name','Enterprise')->select('id','name','price')->first();
        $corporate=Type::where('name','Corporate')->select('id','name','price')->first();
        return inertia::render('auth.pricing', compact('free','standard','enterprise','corporate'));
    }

    public function register(){
        return inertia::render('register');
    }

    public function freeAccount(Request  $request){
        $data=$request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $account=Account::create([
            'name'=>$data['name'],
            'type_id'=>5,
            'status_id'=>1,
            'billing_date'=>Carbon::today()->isoFormat('D')
        ]);
        $role=Role::findOrFail(12);
        $permission=Permission::findOrFail(10);
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

        $user->assignRole($role);
        $user->givePermissionTo($permission);
        $sources=Source::inRandomOrder()->limit(5)->pluck('id');
        $categories=Category::inRandomOrder()->limit(5)->pluck('id');
        $user->sources()->syncWithoutDetaching($sources);
        $user->categories()->syncWithoutDetaching($categories);
        $user->notify(new WelcomeOnboardNotification());
        Auth::login($user);

        return redirect()->route('news.index');
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials,$request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('news');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function forgotPassword(){
        return inertia::render('auth.forgot-password');
    }

    public function requestStore(Request $request){
        $validate=$request->validate([
            'email'=>'required|email|string|max:255|exists:users'
        ],[
            'exists'=>'The email entered do not exist in our database'
        ]);

        $user=User::where('email', $validate['email'])->first();

        $token=$user->verifiable()->create([
            'code'=>rand(111111,999999),
            'email'=>$validate['email'],
            'token'=>base64_encode(Str::random(16))
        ]);
        $user->notify(new PasswordResetNotification($token));

        return redirect()
            ->back()
            ->with('status','We have sent a password reset email. Please check your inbox');

    }

    public function passwordUpdate(){
        $token=request('token');
        return inertia::render('auth.password-update', compact('token'));
    }

    //update user password
    public function newPassword(Request $request){
        $validated=$request->validate([
            'password' => 'required|string|min:8|confirmed',
            'code'=>'required|exists:verifies|integer',
            'token'=>'required|exists:verifies'
        ],
            [
                'exists'=>'The OTP code provided is incorrect',

            ]);

        $verify=Verify::where('token', $validated['token'])->where('code', $validated['code'])->first();
        if ($verify){
            $user=User::findOrFail($verify->verifiable->id);
            $user->update([
                'password'=>Hash::make($validated['password'])
            ]);

        }

        return redirect()->route('login');

    }
}
