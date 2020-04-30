<?php

namespace App\Repositories\Criteria;

class IsLive implements CriterionContract
{
    public function apply($model)
    {
        return $model->where('is_live', true);
    }
}
