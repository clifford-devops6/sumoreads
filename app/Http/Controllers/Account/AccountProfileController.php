<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\confirmEmailChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AccountProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user=User::select('name','id','email','last_name')->findOrFail(Auth::id());
        return inertia::render('account.profile.index', compact('user'));
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
        $user=User::select('name','id','email','last_name')->findOrFail($id);
        return inertia::render('account.profile.show', compact('user'));
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
        $validated=$request->validate([
            'name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255'
        ]);
        $user=User::findOrFail($id);
        $user->update([
            'name'=>$validated['name'],
            'last_name'=>$validated['last_name']
        ]);

        return redirect()->route('profile.index')
            ->with('status', 'Account info updated Successfully');
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
        $user=User::findOrFail($id);
        $user->delete();
        return redirect('/')
            ->with('status','Account Successfully Deleted');
    }

    public function updateEmail(Request $request,$id){
     $validated=$request->validate([
         'email'=>'string|max:255|email|unique:users'
     ]);
     $user=User::findOrFail($id);
     $user->update(['email'=>$validated['email']]);
        $user->notify(new confirmEmailChange($user));
     return redirect()->back()
         ->with('status','Email updated Successfully');
    }

    public function profileSecurity(){
        $user=User::select('name','id','email','last_name')->findOrFail(Auth::id());

        return inertia::render('account.profile.security', compact('user'));
    }

    public function profilePassword(Request $request, $id){
        $validated=$request->validate([
            'password'=>'string|min:8|required',
            'new_password'=>'string|min:8|required|different:password'
        ]);

        $user=User::findOrFail($id);


        if (Hash::check($validated['password'],$user->password)){
            $user->update([
             'password'=>Hash::make($validated['password'])
            ]);
        }else{
            return redirect()->back()
                ->withErrors([
                    'password'=>'The current password is incorrect. Please check and try again'
                ])->onlyInput('password');
        }

        return redirect()->back()
            ->with('status','Password Updated Successfully');


    }

    public function upgrade(){
        return inertia::render('account.upgrade');
    }
}
