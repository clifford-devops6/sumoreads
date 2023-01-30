<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
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
            'title'=>$this->title,
            'created_at'=>$this->created_at,
            'expiry'=>$this->expiry,
            'url'=>$this->url,
            'description'=>$this->description,
            'image'=>$this->getFirstMediaUrl('image','thumb'),
            'full_image'=>$this->getFirstMediaUrl('image'),
            'status'=>$this->status
        ];
    }
}
