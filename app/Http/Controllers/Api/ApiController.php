<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    //
    public function getUsers($id){
        return User::where('account_id',$id)->select('name','id','last_name')->get();
    }

    public function getGroupUsers($id){
        $group=Group::findOrFail($id);
        return $group->users()->select('name','last_name')->get();
    }

    public function getSources(){
        return Source::select('id','name')->get();
    }
}
