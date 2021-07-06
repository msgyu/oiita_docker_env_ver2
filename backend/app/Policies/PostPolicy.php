<?php

namespace App\Policies;

use App\Models\Post;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  Post  $post
     * @return mixed
     */
    public function update(Post $post)
    {
        if(!Auth::check()) {
            return false;
        }
        return Auth::id() === $post->user_id;
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  Post  $post
     * @return mixed
     */
    public function delete(Post $post)
    {
        //
    }
}
