<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;

class AdminPermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:super-admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $permissions=Permission::query()
            ->when(request('search'),function ($query,$search){
                $query->where('name','like', '%'.$search.'%');
            })
            ->paginate(10)->withQueryString()
            ->through(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'guard_name' => $role->guard_name
                ];
            });

        $filters=request()->only(['search']);

        return inertia::render('permissions.index', compact('filters','permissions'));
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
            'name'=>'required|string|max:25|unique:permissions',
            'guard_name'=>'required|string|max:25'
        ]);

        $permission=Permission::create([
            'name'=>$validated['name'],
            'guard_name'=>$validated['guard_name']
        ]);

        return redirect()->back()
            ->with('status','Permission created Successfully');
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
        $validated=$request->validate([
            'name'=>'required|string|max:25',
            'guard_name'=>'required|string|max:25'
        ]);
        $permission=Permission::findOrFail($id);
        $permission->update([
            'name'=>$validated['name'],
            'guard_name'=>$validated['guard_name']
        ]);

        return redirect()->back()
            ->with('status','Permission updated Successfully');
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
