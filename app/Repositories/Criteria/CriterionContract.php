<?php

namespace App\Repositories\Criteria;

interface CriterionContract
{
    public function apply($model);
}
