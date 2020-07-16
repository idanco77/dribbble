<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'total_members' => $this->members->count(),
            'slug' => $this->slug,
            'owner' => new UserResource($this->owner),
            'members' => UserResource::collection($this->members),
            'designs' => DesignResource::collection($this->designs)
        ];
    }
}
