<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $users=Admin::whereNotIn('id',[Auth::id(),3])->select('id','name','last_name','email')->with(['roles','permissions'])->paginate(10);

        return inertia::render('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles=Role::whereIn('id',[13,14])->select('name','id')->get();
        $permissions=Permission::whereIn('id',[11,12,13,14])->select('name','id')->get();

        return inertia::render('admin.users.create', compact('roles', 'permissions'));
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
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id'=>'nullable|array',
            'permission_id'=>'nullable|array'
        ]);

        $user=Admin::create([
            'name' => $validated['name'],
            'last_name'=>$validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $permissions=Permission::whereIn('id',$validated['permission_id'])->get();
        $roles=Role::whereIn('id', $validated['role_id'])->get();
        $user->syncPermissions($permissions);
        $user->syncRoles($roles);
        return redirect()->route('users.index')
            ->with('status','User successfully created');
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
        $user=Admin::with(['roles','permissions'])->findOrFail($id);

        return inertia::render('admin.users.show', compact('user'));
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
        $user=Admin::findOrFail($id);
        $user_roles=$user->roles()->pluck('id');
        $user_permissions=$user->permissions()->pluck('id');
        $roles=Role::whereIn('id',[13,14])->select('name','id')->get();
        $permissions=Permission::whereIn('id',[11,12,13,14])->select('name','id')->get();
        return inertia::render('admin.users.edit', compact('user','roles','permissions','user_roles','user_permissions'));
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
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'role_id'=>'nullable|array',
            'permission_id'=>'nullable|array'
        ]);

        $user=Admin::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
            'last_name'=>$validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('users.index')
            ->with('status','User updated successfully');
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
        $user=Admin::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')
            ->with('status','User deleted successfully');
    }
}
