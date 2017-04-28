<?php

namespace Laralum\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Laralum\Users\Models\User;

class Post extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'laralum_blog_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'category_id', 'title', 'description', 'content', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function deleteComments()
    {
        foreach ($this->comments as $comment) {
            $comment->delete();
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
