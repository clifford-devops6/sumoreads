<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReadlistResource;
use App\Models\Readlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReadlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $articles=ReadlistResource::collection(Readlist::where('user_id',Auth::id())->with(['article','article.source','article.category'])->get());
       // return $articles;
        return inertia::render('readlist.index', compact('articles'));
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
        $readlist=Readlist::create([
            'user_id'=>Auth::id(),
            'article_id'=>$id
        ]);

        return redirect()->back()
        ->with('status','Article Successfully added to read list');
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
        $readlist=Readlist::findOrFail($id);
        $readlist->delete();
        return redirect()->back()
        ->with('status','Article deleted from read list successfully');
    }


    public function confirmRead($id) {
        $readlist=Readlist::findOrFail($id);
        $readlist->update([
            'read_status'=>1
        ]);
        return redirect()->back();
    }

    public function unread(){
        $articles=ReadlistResource::collection(Readlist::where('user_id',Auth::id())->where('read_status',0)->with(['article','article.source','article.category'])->get());
       // return $articles;
        return inertia::render('readlist.unread', compact('articles'));

    }

    public function read(){
        $articles=ReadlistResource::collection(Readlist::where('user_id',Auth::id())->where('read_status',1)->with(['article','article.source','article.category'])->get());
        // return $articles;
         return inertia::render('readlist.read', compact('articles'));
 

    }
}
