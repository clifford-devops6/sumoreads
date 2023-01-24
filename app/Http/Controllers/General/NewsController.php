<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        //
        $categories=Category::select('id','name')->get();
        $sources=Source::select('id','name')->get();
        //trending posts

        $trending=ArticleResource::collection(Article::query()
            ->when(request('trending_source'),function ($query,$trending_source){
                $query->where('source_id',$trending_source);
          })
            ->when(request('trending_category'),function ($query,$trending_category){
                $query->where('category_id',$trending_category);
            })
            ->with('source','source.category')->orderBy('published')->limit(12)->get());

        $latest=ArticleResource::collection(Article::query()
            ->when(request('latest_source'),function ($query,$latest_source){
                $query->where('source_id',$latest_source);
            })
            ->when(request('latest_category'),function ($query,$latest_category) {
                $query->where('category_id', $latest_category);
            })
        ->orderBy('published')->with('source','source.category')->limit(6)->get());

       // all articles
        $posts=ArticleResource::collection(Article::query()
            ->when(request('source'),function ($query,$source){
                $query->where('source_id',$source);
            })
            ->when(request('category'),function ($query,$category) {
                $query->where('category_id', $category);
            })
        ->orderBy('published')->with('source','source.category')->limit(20+request('limit'))->get());

        
        $filters=request()->only(['trending_category','trending_source','category','source','latest_category','latest_source']);
        return inertia::render('news.index', compact('trending','sources','categories','latest','filters','posts'));
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
