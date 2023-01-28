<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Models\Source;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NewsCategoryController extends Controller
{
    //
    public function category($id){
        $category=Category::findBySlugOrFail($id);
        $sources=Source::where('category_id',$category->id)->select('id','name')->get();

        $trending=ArticleResource::collection(Article::query()
            ->when(request('trending_source'),function ($query,$trending_source){
                $query->where('source_id',$trending_source);
            })

            ->with('source','source.category')->orderBy('published')->limit(12)->get());

        $latest=ArticleResource::collection(Article::query()
            ->when(request('latest_source'),function ($query,$latest_source){
                $query->where('source_id',$latest_source);
            })

            ->orderBy('published')->with('source','source.category')->limit(6)->get());

        // all articles
        $posts=ArticleResource::collection(Article::query()
            ->when(request('source'),function ($query,$source){
                $query->where('source_id',$source);
            })

            ->orderBy('published')->with('source','source.category')->limit(20+request('limit'))->get());


        $filters=request()->only(['trending_category','trending_source','category','source','latest_category','latest_source']);
        return inertia::render('news.categories', compact('trending','sources','category','latest','filters','posts'));
    }
}
