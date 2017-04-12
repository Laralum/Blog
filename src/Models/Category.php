<?php

namespace Laralum\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laralum_blog_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->hasMany('Laralum\Blog\Models\Post');
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, Post::class);
    }

    public function deletePosts()
    {
        foreach ($this->posts as $post) {
            $post->delete();
        }
    }

    public function deleteComments()
    {
        foreach ($this->comments as $comment) {
            $comment->delete();
        }
    }
}
