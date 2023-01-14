<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminLangaugeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $languages=LanguageResource::collection(Language::paginate(10));
        $statuses=Status::select('name','id')->get();
        return  inertia::render('admin.languages.index', compact('languages','statuses'));
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
            'name'=>'required|string|max:50|unique:languages',
            'status_id'=>'required',
            'abbreviation'=>'required|string|max:10'
        ],
            [
                'required'=>'The :attribute field is required',
                'max'=>'The :attribute cannot exceed 50 characters',
                'unique'=>'The category already exists'
            ]
        );

        $language=Language::create([
            'name'=>$validated['name'],
            'status_id'=>$validated['status_id'],
            'abbreviation'=>$validated['abbreviation'],
        ]);
        return  redirect('admin/languages')
            ->with('status', 'Language Successfully Added');
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
            'abbreviation'=>'required|string|max:10'
        ],
            [
                'required'=>'The :attribute field is required',
                'max'=>'The :attribute cannot exceed 50 characters',
                'unique'=>'The category already exists'
            ]
        );
        $language=Language::findOrFail($id);
        $language->update([
            'name'=>$validated['name'],
            'status_id'=>$validated['status_id'],
            'abbreviation'=>$validated['abbreviation'],
        ]);
        return  redirect('admin/languages')
            ->with('status', 'Language Successfully Updated');
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
        $language=Language::FindOrFail($id);
        $language->delete();
        return  redirect('admin/languages')
            ->with('status', 'Language Successfully Deleted');
    }
}
