<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;
use App\Models\Source;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
class ArticleRetrieve extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'retrieve:articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Making API request to News API for latest articles';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date=Carbon::today()->toDateString();

        $sources=Source::all();

        foreach ($sources as $source){

            $domain=$source->domain;
            $response=Http::get('https://newsapi.org/v2/everything?domains='.$domain.'&from='.$date.'&language='.config('news.language').'&apiKey='.config('news.key'));
            $news=json_decode($response);
            foreach ($news->articles as $article){
                $article= Article::firstOrCreate([
                    'author'=>$article->author,
                    'title'=>$article->title,
                    'description'=>$article->description,
                    'image_url'=>$article->urlToImage,
                    'content'=>$article->content,
                    'article_url'=>$article->url,
                    'published'=>$article->publishedAt,
                    'status_id'=>1,
                    'source_id'=>$source->id
                ]);

            }
        }
    }
}
