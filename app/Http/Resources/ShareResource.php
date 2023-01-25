<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShareResource extends JsonResource
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
            'sender_id'=>$this->sender_id,
            'comment'=>$this->comment,
            'article_id'=>$this->article_id,
            'read_status'=>$this->read_status,
            'sender'=>new UserResource($this->sender),
            'article'=>new ArticleResource($this->article)
        ];
    }
}
