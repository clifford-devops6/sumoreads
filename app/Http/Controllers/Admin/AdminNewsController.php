<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories=Category::select('id','name')->get();
        $sources=Source::select('id','name')->get();
        $articles=ArticleResource::collection(Article::query()
            ->when(request('category'), function ($query, $category){
                $query->where('category_id', "=", $category);
            })
            ->when(request('source'), function ($query, $source){
                $query->where('source_id', "=", $source);
            })
            ->when(request('search'), function ($query, $search){
                $query->where('title', 'LIKE', '%' . $search . '%');
            })
        ->paginate(15));
        $filters=request()->only(['category','source','search']);
        return inertia::render('admin.articles.index', compact('articles','categories','sources','filters'));
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
        $article=new ArticleResource(Article::findBySlugOrFail($id));
        return inertia::render('admin.articles.show', compact('article'));
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
        $article=Article::findOrFail($id);
        $article->delete();
        return redirect()->route('articles.index')
            ->with('status','Article Successfully deleted');
    }
}
