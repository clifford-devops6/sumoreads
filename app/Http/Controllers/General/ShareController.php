<?php

namespace App\Http\Controllers\General;

use App\Events\ShareEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\GroupResource;
use App\Http\Resources\ShareResource;
use App\Http\Resources\UserResource;
use App\Models\Article;
use App\Models\ReadStatus;
use App\Models\Share;
use App\Models\User;
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
        $user=Auth::user();
      $share_ids=$user->shares()->pluck('share_id');
      $groups=$user->groups()->whereHas('shares')->get();
        foreach ($groups as $group){
            $real=$group->shares()->pluck('id');
            foreach ($real as $ids){
                $share_ids->push($ids);
            }


        }

      $senders=Auth::user()->shares()->pluck('sender_id');
      $users=UserResource::collection(User::whereIn('id',$senders)->get());
      $groups=GroupResource::collection($groups);


     $shareds=ShareResource::collection(Share::whereIn('id',$share_ids)->with(['article','sender'])->get());

        return inertia::render('account.share.index', compact('shareds','users','groups'));
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

        $share_ids=Auth::user()->shares()->where('sender_id',$id)->pluck('share_id');
        $shareds=ShareResource::collection(Share::whereIn('id',$share_ids)->with(['article','sender'])->get());
        $senders=Auth::user()->shares()->pluck('sender_id');
        $users=UserResource::collection(User::whereIn('id',$senders)->get());
        $user_id=$id;
        $groups=Auth::user()->groups()->whereHas('shares')->get();
        $groups=GroupResource::collection($groups);
        return inertia::render('account.share.show', compact('shareds','users','user_id','groups'));
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
        $read=ReadStatus::updateOrCreate([
            'user_id'=>Auth::id(),
            'share_id'=>$id
        ]);
        return redirect()->back();
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

    public function groupShare($id){
        $share_ids=Auth::user()->shares()->where('sender_id',$id)->pluck('share_id');
        $shareds=ShareResource::collection(Share::whereIn('id',$share_ids)->with(['article','sender'])->get());
        $senders=Auth::user()->shares()->pluck('sender_id');
        $users=UserResource::collection(User::whereIn('id',$senders)->get());
        $user_id=$id;
        $groups=Auth::user()->groups()->whereHas('shares')->get();
        $groups=GroupResource::collection($groups);
        return inertia::render('account.share.group-share', compact('shareds','users','user_id','groups'));
    }


    public function articleShare($id){
        $article=new ArticleResource(Article::findBySlugOrFail($id));
        return inertia::render('share.article', compact('article'));
    }
}
