<?php

namespace App\Repositories\Eloquent;

use App\Models\Design;
use App\Repositories\Contracts\DesignContract;

class DesignRepository extends BaseRepository implements DesignContract
{
    public function model()
    {
        return Design::class; // App\Models\Design
    }

    public function applyTags($id, array $data)
    {
        $design = $this->find($id);
        $design->retag($data);
    }

    public function addComment($designId, array $data)
    {
        // get the design for which we want to create a comment

        $design = $this->find($designId);

        // creatre the comment for the design
        $comment = $design->comments()->create($data);

        return $comment;
    }

    public function like($id)
    {
        $design = $this->model->findOrFail($id);
        if($design->isLikedByUser(auth()->id())){
            $design->unlike();
        } else {
            $design->like();
        }
    }

    public function isLikedByUser($id)
    {
        $design = $this->model->findOrFail($id);

        return $design->isLikedByUser(auth()->id());
    }
}
