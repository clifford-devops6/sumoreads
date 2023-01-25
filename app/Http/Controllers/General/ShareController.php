<?php

namespace App\Http\Controllers\General;

use App\Events\ShareEvent;
use App\Http\Controllers\Controller;
use App\Models\Share;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ShareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return inertia::render('account.share.index');
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
            'share'=>'nullable|string|max:50',
            'selectedUsers'=>'nullable',
            'selectedGroups'=>'nullable',
            'article_id'=>'integer|required',
            'comment'=>'nullable|max:1000'
        ]);

        $share=Share::create([
            'article_id'=>$validated['article_id'],
            'sender_id'=>Auth::id(),
            'comment'=>$validated['comment']
        ]);
        if (filter_var( $validated['share'], FILTER_VALIDATE_EMAIL )){
            $share->update(['email'=>$validated['share']]);
        }
        if($validated['selectedUsers']){
            $share->users()->syncWithoutDetaching(array_column($validated['selectedUsers'],'id'));
        }
        if($validated['selectedUsers']) {
            $share->groups()->syncWithoutDetaching(array_column($validated['selectedGroups'],'id'));
        }

        ShareEvent::dispatch($share);

        return redirect()->back()
            ->with('status','Article Successfully shared');

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
