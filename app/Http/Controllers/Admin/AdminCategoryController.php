<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories=CategoryResource::collection(Category::all());
        $statuses=Status::select('name','id')->get();
        return inertia::render('admin.categories.index', compact('categories','statuses'));
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
            'name'=>'required|string|max:50|unique:categories',
            'status_id'=>'required',
            'icon'=>'required|string|max:50'
        ],
            [
                'required'=>'The :attribute field is required',
                'max'=>'The :attribute cannot exceed 50 characters',
                'unique'=>'The category already exists'
            ]
        );

        $category=Category::create([
            'name'=>$validated['name'],
            'status_id'=>$validated['status_id'],
            'icon'=>$validated['icon']
        ]);

        return  redirect('admin/categories')
            ->with('status', 'Category Successfully Created');
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
            'name'=>'required|string|max:50',
            'status_id'=>'required',
            'icon'=>'required|string|max:50'
        ],
            [
                'required'=>'The :attribute field is required',
                'max'=>'The :attribute cannot exceed 50 characters',
                'unique'=>'The category already exists'
            ]
        );

        $category=Category::findOrFail($id);

        $category->update([
            'name'=>$validated['name'],
            'status_id'=>$validated['status_id'],
            'icon'=>$validated['icon']
        ]);
        return  redirect('admin/categories')
            ->with('status', 'Category Successfully Updated');
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
        $category=Category::findOrFail($id);

        $category->delete();
        return  redirect('admin/categories')
            ->with('status', 'Category Successfully Deleted');
    }
}
