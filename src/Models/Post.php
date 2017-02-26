<?php

namespace Laralum\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {

	protected $table = 'laralum_blog_posts';
	public $timestamps = true;

	public function blog()
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