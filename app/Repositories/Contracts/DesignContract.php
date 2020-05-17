<?php

namespace App\Repositories\Contracts;

interface DesignContract
{
    public function applyTags($id, array $tags);
    public function addComment($designId, array $data);
    public function like($id);
    public function isLikedByUser($id);
}
