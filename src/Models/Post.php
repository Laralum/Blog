<?php

namespace Laralum\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

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
    protected $fillable = ['user_id', 'category_id', 'title', 'content'];


	public function category()
	{
		return $this->belongsTo('Laralum\Blog\Models\Category');
	}

	public function comments()
	{
		return $this->hasMany('Laralum\Blog\Models\Comment');
	}

	public function user()
	{
		return $this->belongsTo('Laralum\Users\Models\User');
	}

}
