<?php

namespace App\Repositories\Contracts;

interface DesignContract
{
    public function applyTags($id, array $tags);
}
