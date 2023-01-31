<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class SourceResource extends JsonResource
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
            'slug'=>$this->slug,
            'name'=>$this->name,
            'category_id'=>$this->category_id,
            'status_id'=>$this->status_id,
            'domain'=>$this->domain,
            'country_id'=>$this->country_id,
            'pulls'=>$this->pulls,
            'category'=>new CategoryResource($this->whenLoaded('category')),
            'status'=>$this->status,
            'country'=>new CountryResource($this->whenLoaded('country')),
            'logo'=>$this->getFirstMediaUrl('logo','logo-icon')
        ];
    }
}
