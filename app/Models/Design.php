<?php

namespace App\Models;

use App\Models\Traits\Likeable;
use Cviebrock\EloquentTaggable\Taggable;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Illuminate\Support\Facades\Storage;

/**
 * Design
 *
 * @mixin Eloquent
 */

class Design extends Model
{
    use Taggable, Likeable;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')
            ->orderBy('created_at', 'asc');
    }

    public function getImagesAttribute()
    {
        return [
            'thumbnail' => $this->getImagePath('thumbnail'),
            'original' => $this->getImagePath('original'),
            'large' => $this->getImagePath('large'),
        ];
    }

    protected function getImagePath($size)
    {
        return Storage::disk($this->disk)
            ->url('uploads/designs/'.$size.'/'.$this->image);
    }

}
