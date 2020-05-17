<?php

namespace App\Repositories\Contracts;

interface BaseContract
{
    public function all();
    public function find($id);
    public function findWhere($colomn, $value);
    public function findWhereFirst($column, $value);
    public function paginate($perPage = 100);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function createForCurrentUser(string $relationship, array $data);
}