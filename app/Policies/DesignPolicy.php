<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Design;
use Illuminate\Auth\Access\HandlesAuthorization;

class DesignPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Design $design)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Design $design)
    {
        return $design->user_id === $user->id;
    }

    public function delete(User $user, Design $design)
    {
        return $design->user_id === $user->id;
    }

    public function restore(User $user, Design $design)
    {
        //
    }

    public function forceDelete(User $user, Design $design)
    {
        //
    }
}
