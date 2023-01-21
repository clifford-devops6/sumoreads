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

    public function delete($id){
     $group=Group::findOrFail($id);
     $group->delete();
     return redirect()->back()
         ->with('status','Group deleted successfully');
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

    public function addUsers( Request $request){
        $validate=$request->validate([
            'ids'=>'required|array',
            'group'=>'required|integer'
        ]);

        $group=Group::findOrFail($validate['group']);
        $group->users()->syncWithoutDetaching($validate['ids']);
        return redirect()->back()
            ->with('status', 'Users successfully added to group');

    }

    public function removeUsers(Request $request){
        $validate=$request->validate([
            'ids'=>'required|array',
            'group'=>'required|integer'
        ]);
        return $validate;
     $group=Group::findOrFail($validate['group']);
     $group->users()->detach($validate['ids']);
        return redirect()->back()
            ->with('status', 'Users successfully removed from group');
    }

    public function addSource(Request $request){
        $validate=$request->validate([
            'ids'=>'required|array',
            'group'=>'required|integer'
        ]);
        $group=Group::findOrFail($validate['group']);
        $group->sources()->syncWithoutDetaching($validate['ids']);
        return redirect()->back()
            ->with('status', 'Sources successfully added to group');
    }

    public function removeSource(Request  $request){
        $validate=$request->validate([
            'ids'=>'required|array',
            'group'=>'required|integer'
        ]);

        $group=Group::findOrFail($validate['group']);
        $group->sources()->detach($validate['ids']);
        return redirect()->back()
            ->with('status', 'Users successfully added to group');
    }

    public function addCategory(Request $request){
        $validate=$request->validate([
            'ids'=>'required|array',
            'group'=>'required|integer'
        ]);
        $group=Group::findOrFail($validate['group']);
        $group->categories()->syncWithoutDetaching($validate['ids']);
        return redirect()->back()
            ->with('status', 'Sources successfully added to group');
    }

    public function removeCategory(Request  $request){
        $validate=$request->validate([
            'ids'=>'required|array',
            'group'=>'required|integer'
        ]);

        $group=Group::findOrFail($validate['group']);
        $group->categories()->detach($validate['ids']);
        return redirect()->back()
            ->with('status', 'Users successfully added to group');
    }
}
