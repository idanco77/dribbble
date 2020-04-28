<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\UserContract;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserContract $users)
    {
        $this->users = $users;
    }

    public function index()
    {
        $users = $this->users->all();
        return UserResource::collection($users);
    }
}
