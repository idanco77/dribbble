<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DesignResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => new UserResource($this->user),
            'tag_list' => [
                'tags' => $this->tagArray,
                'normalized' => $this->tagArrayNormalized,
            ],
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'is_live' => $this->is_live,
            'likes_count' => $this->likes()->count(),
            'created_at_human' =>  Carbon::parse($this->created_at)->format('d/m/Y'),
            'updated_at_human' =>  Carbon::parse($this->updated_at)->format('d/m/Y'),
            'image' => $this->images,
            'upload_successful' => $this->upload_successful,
            'disk' => $this->disk,
            'team' => $this->team ? [
                'name' => $this->team->name,
                'slug' => $this->team->slug,
            ] : null,
            'comments' => CommentResource::collection($this->comments),
            'user' => new UserResource($this->user),
        ];
    }
}
