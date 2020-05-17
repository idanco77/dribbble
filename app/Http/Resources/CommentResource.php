<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'createdAt' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'updatedAt' => Carbon::parse($this->updated_at)->format('d/m/Y'),
            'user' => new UserResource($this->user),
        ];
    }
}
