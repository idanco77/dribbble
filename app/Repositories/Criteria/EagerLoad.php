<?php

namespace App\Repositories\Criteria;

class EagerLoad implements CriterionContract
{

    protected $relationships;

    public function __construct($relationships)
    {
        $this->relationships = $relationships;
    }

    public function apply($model)
    {
        return $model->with($this->relationships);
    }
}
