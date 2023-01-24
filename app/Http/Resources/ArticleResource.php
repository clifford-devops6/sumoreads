<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'created_at'=>$this->created_at,
            'author'=>$this->author,
            'title'=>$this->title,
            'slug'=>$this->slug,
            'description'=>$this->description,
            'image'=>$this->image_url,
            'article_url'=>$this->article_url,
            'content'=>$this->content,
            'published'=>$this->published,
            'source_id'=>$this->source_id,
            'source'=>new SourceResource($this->source),
            'category'=>new CategoryResource($this->category)
        ];
    }
}
