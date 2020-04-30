<?php

namespace App\Repositories\Criteria;

interface CriteriaContract
{
    public function withCriteria(... $criteria);
}
