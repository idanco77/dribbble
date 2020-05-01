<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'name' => $this->name,
            'designs' => $this->designs,
            'createdAt' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'tagline' => $this->tagline,
            'about' => $this->about,
            'location' => $this->location,
        ];
    }
}
