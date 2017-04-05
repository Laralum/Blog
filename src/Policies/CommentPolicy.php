<?php

namespace Laralum\Blog\Policies;

use Laralum\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Laralum\Blog\Models\Comment;

class CommentPolicy
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
     * Determine if the current user can access comments.
     *
     * @param  mixed $user
     * @return bool
     */
    public function access($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.access');
    }

    /**
     * Determine if the current user can access comments. (public)
     *
     * @param  mixed $user
     * @return bool
     */
    public function publicAccess($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.access-public');
    }



    /**
     * Determine if the current user can create comments.
     *
     * @param  mixed  $user
     * @return bool
     */
    public function create($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.create');
    }

    /**
     * Determine if the current user can create comments. (public)
     *
     * @param  mixed  $user
     * @return bool
     */
    public function publicCreate($user)
    {
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.create-public');
    }

    /**
     * Determine if the current user can view comments.
     *
     * @param  mixed $user
     * @param  \Laralum\Blog\Models\Comment $comment
     * @return bool
     */
    public function view($user, Comment $comment)
    {
        if ($comment->user->id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.view');
    }

    /**
     * Determine if the current user can view comments. (public)
     *
     * @param  mixed $user
     * @param  \Laralum\Blog\Models\Comment $comment
     * @return bool
     */
    public function publicView($user, Comment $comment)
    {
        if ($comment->user->id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.view-public');
    }


    /**
     * Determine if the current user can update comments.
     *
     * @param  mixed $user
     * @param  \Laralum\Blog\Models\Comment $comment
     * @return bool
     */
    public function update($user, Comment $comment)
    {
        if ($comment->user->id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.update');
    }

    /**
     * Determine if the current user can update comments. (public)
     *
     * @param  mixed $user
     * @param  \Laralum\Blog\Models\Comment $comment
     * @return bool
     */
    public function publicUpdate($user, Comment $comment)
    {
        if ($comment->user->id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.update-public');
    }

    /**
     * Determine if the current user can delete comments.
     *
     * @param  mixed $user
     * @param  \Laralum\Blog\Models\Comment $comment
     * @return bool
     */
    public function delete($user, Comment $comment)
    {
        if ($comment->user->id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.delete');
    }

    /**
     * Determine if the current user can delete comments. (public)
     *
     * @param  mixed $user
     * @param  \Laralum\Blog\Models\Comment $comment
     * @return bool
     */
    public function publicDelete($user, Comment $comment)
    {
        if ($comment->user->id == $user->id) {
            return true;
        }
        return User::findOrFail($user->id)->hasPermission('laralum::blog.comments.delete-public');
    }
}
