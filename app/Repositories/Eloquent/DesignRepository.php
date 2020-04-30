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
}
