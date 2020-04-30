<?php

namespace App\Repositories\Criteria;

class ForUser implements CriterionContract
{

    protected $user_id;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }

    public function apply($model)
    {
        return $model->where('user_id', $this->user_id);
    }
}
