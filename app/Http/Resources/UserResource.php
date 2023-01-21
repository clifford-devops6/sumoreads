<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name'=>$this->name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'account_id'=>$this->account_id,
            'account'=>new AccountResource($this->whenLoaded('account')),
            'categories'=>CategoryResource::collection($this->whenLoaded('categories')),
            'sources'=>SourceResource::collection($this->whenLoaded('sources'))
        ];
    }
}
