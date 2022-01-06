<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;

    public function show(User $user){
        return true;
    }

    public function publicTimeline(User $user){
        return true;
    }

    public function create(User $user){
        return Auth::check();
    }

    public function update(User $user, Post $post){
        return $user->id == $post->user_id;
    }

    public function delete(User $user, Post $post){
        return ($user->id == $post->user_id) || ($user->is_admin == true);
    }

}
