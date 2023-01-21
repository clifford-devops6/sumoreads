<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountResource extends JsonResource
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
            'type_id'=>$this->type_id,
            'administrator'=>new AdministratorResource($this->whenLoaded('administrator')),
            'type'=>new TypeResource($this->whenLoaded('type')),
            'invitations'=>InvitationResource::collection($this->whenLoaded('invitations')),
            'groups'=>GroupResource::collection($this->whenLoaded('groups')),
            'users'=>UserResource::collection($this->whenLoaded('users')),
            'categories'=>CategoryResource::collection($this->whenLoaded('categories')),
            'sources'=>SourceResource::collection($this->whenLoaded('sources'))

        ];
    }
}
