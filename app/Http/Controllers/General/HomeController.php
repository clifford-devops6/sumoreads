<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories=Auth::user()->categories()->get();
        $sources=Auth::user()->sources()->get();
        //trending posts

        $trending=ArticleResource::collection(Article::query()
            ->whereIn('source_id', $sources->pluck('id'))
            ->when(request('trending_source'),function ($query,$trending_source){
                $query->where('source_id',$trending_source);
            })
            ->when(request('trending_category'),function ($query,$trending_category){
                $query->where('category_id',$trending_category);
            })
            ->with('source','source.category')->orderBy('published','DESC')->limit(15)->get());

        $latest=ArticleResource::collection(Article::query()
            ->whereIn('category_id', $categories->pluck('id'))
            ->when(request('latest_source'),function ($query,$latest_source){
                $query->where('source_id',$latest_source);
            })
            ->when(request('latest_category'),function ($query,$latest_category) {
                $query->where('category_id', $latest_category);
            })
            ->orderBy('created_at','DESC')->with('source','source.category')->limit(9)->get());

        // all articles
        $posts=ArticleResource::collection(Article::query()
            ->whereIn('category_id', $categories->pluck('id'))
            ->when(request('source'),function ($query,$source){
                $query->where('source_id',$source);
            })
            ->when(request('category'),function ($query,$category) {
                $query->where('category_id', $category);
            })
            ->orderBy('published','DESC')->with('source','source.category')->limit(20+request('limit'))->get());


        $filters=request()->only(['trending_category','trending_source','category','source','latest_category','latest_source']);
        return inertia::render('home.index', compact('trending','sources','categories','latest','filters','posts'));
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
