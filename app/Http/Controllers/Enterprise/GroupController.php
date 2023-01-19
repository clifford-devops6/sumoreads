<?php

namespace App\Http\Controllers\Enterprise;

use App\Http\Controllers\Controller;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    //

    public function create(Request $request){
        $validated=$request->validate([
            'name'=>'string|max:255|required',
            'account_id'=>'integer|required'
        ]);
        $group=Group::create([
            'name'=>$validated['name'],
            'account_id'=>$validated['account_id']
        ]);
        return redirect()->back()
            ->with('status','Group created successfully');
    }

    public function update(Request $request, $id){

        $validated=$request->validate([
            'name'=>'string|max:255|required'
        ]);
        $group=Group::findOrFail($id);

        $group->update([
            'name'=>$validated['name']
        ]);

        return redirect()->back()
            ->with('status','Group updated successfully');
    }
}
