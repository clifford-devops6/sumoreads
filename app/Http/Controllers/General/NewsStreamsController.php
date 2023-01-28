<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsStreamsController extends Controller
{
    //
    public function stream($id){
        $categories=Category::select('id','name')->get();
        $source=Source::findBySlugOrFail($id);
        //trending posts

        $trending=ArticleResource::collection(Article::query()
           ->where('source_id',$source->id)
            ->when(request('trending_category'),function ($query,$trending_category){
                $query->where('category_id',$trending_category);
            })
            ->with('source','source.category')->orderBy('published')->limit(12)->get());

        $latest=ArticleResource::collection(Article::query()
            ->where('source_id',$source->id)
            ->when(request('latest_category'),function ($query,$latest_category) {
                $query->where('category_id', $latest_category);
            })
            ->orderBy('published')->with('source','source.category')->limit(6)->get());

        // all articles
        $posts=ArticleResource::collection(Article::query()
            ->where('source_id',$source->id)
            ->when(request('category'),function ($query,$category) {
                $query->where('category_id', $category);
            })
            ->orderBy('published')->with('source','source.category')->limit(20+request('limit'))->get());


        $filters=request()->only(['trending_category','trending_source','category','source','latest_category','latest_source']);
        return inertia::render('news.streams', compact('trending','source','categories','latest','filters','posts'));
    }
}
