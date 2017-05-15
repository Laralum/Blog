<?php

namespace Laralum\Blog\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Blog\Models\Post;
use Laralum\Users\Models\User;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Filters the authoritzation.
     *
     * @param mixed $user
     * @param mixed $ability
     */
    public function before($user, $ability)
    {
        if (User::findOrFail($user->id)->superAdmin()) {
            return true;
        }
    }

    /**
     * Determine if the current user can access posts.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::blog.posts.access');
    }

    /**
     * Determine if the current user can create posts.
     *
     * @param mixed $user
     *
     * @return bool
     */
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::blog.posts.create');
    }

    /**
     * Determine if the current user can view posts.
     *
     * @param mixed                     $user
     * @param \Laralum\Blog\Models\Post $post
     *
     * @return bool
     */
    public function view($user, Post $post)
    {
        if ($post->user->id == $user->id) {
            return true;
        }

        return User::findOrFail($user->id)->hasPermission('laralum::blog.posts.view');
    }

    /**
     * Determine if the current user can update posts.
     *
     * @param mixed                     $user
     * @param \Laralum\Blog\Models\Post $post
     *
     * @return bool
     */
    public function update($user, Post $post)
    {
        if ($post->user->id == $user->id) {
            return true;
        }

        return User::findOrFail($user->id)->hasPermission('laralum::blog.posts.update');
    }

    /**
     * Determine if the current user can delete posts.
     *
     * @param mixed                     $user
     * @param \Laralum\Blog\Models\Post $post
     *
     * @return bool
     */
    public function delete($user, Post $post)
    {
        if ($post->user->id == $user->id) {
            return true;
        }

        return User::findOrFail($user->id)->hasPermission('laralum::blog.posts.delete');
    }

    /**
     * Determine if the current user can publish posts.
     *
     * @param mixed                     $user
     * @param \Laralum\Blog\Models\Post $post
     *
     * @return bool
     */
    public function publish($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::blog.posts.publish');
    }
}
