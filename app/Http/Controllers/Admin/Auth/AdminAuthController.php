<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class AdminAuthController extends Controller
{
    //
    public function login(){
        return inertia::render('admin.auth.login');
    }

    public function register(){
        return inertia::render('admin/auth/register');
    }

    public function create(CreateUserRequest $request){
        $user=Admin::create([
             'name'=>$request->name,
             'last_name'=>$request->last_name,
             'email'=>$request->email,
             'password'=>Hash::make($request->password)
         ]);
         $role=Role::find(1);
         $user->assignRole($role);
         Auth::login($user);
         return redirect()->route('admin.index');
        //return redirect()->back();
    }


    //login admin user

    public function authenticate(Request $request){
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.index');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

}
