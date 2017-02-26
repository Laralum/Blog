<?php

namespace Laralum\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	protected $table = 'laralum_blog_comments';
	public $timestamps = true;

	public function post()
	{
		return $this->belongsTo('Laralum\Blog\Models\Post');
	}

	public function user()
	{
		return $this->belongsTo('Laralum\Users\Models\User');
	}

}