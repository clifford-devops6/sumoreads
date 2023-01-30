<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Advertisement;
use App\Models\Category;
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

    public function getCategories(){
        return Category::select('id','name')->get();
    }

    public function getGroups($id){
        return Group::where('account_id',$id)->select('name','id')->get();
    }

    public function enterpriseStreams($id){
        $account=Account::findOrFail($id);
        return $account->sources()->get();
    }

    public function enterpriseCategories($id){
        $account=Account::findOrFail($id);
        return $account->categories()->get();
    }

    public function personalStreams($id){
        $user=User::findOrFail($id);
        return $user->sources()->get();
    }

    public function personalCategories($id){
        $user=User::findOrFail($id);
        return $user->categories()->get();
    }

    public function  getAdverts(){
        //adverts. pick 20 items in random order
        return Advertisement::where('status',1)->select('title','id','description','url')->inRandomOrder()->limit(20)->get();
    }
}
