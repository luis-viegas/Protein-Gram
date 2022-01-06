<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function create(User $user){
        return $user->is_admin;
    }

    public function update(User $user, User $user_created){
        return $user->is_admin || $user->id == $user_created->id;
    }

    public function delete(User $user, User $user_created){
        return $user->is_admin || $user->id == $user_created->id;
    }
}
