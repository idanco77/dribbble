<?php

namespace App\Repositories\Criteria;

class LatestFirst implements CriterionContract
{
    public function apply($model)
    {
        return $model->latest();
    }
}
