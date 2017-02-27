<?php

namespace Laralum\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

	/**
     * The table associated with the model.
     *
     * @var string
     */
	protected $table = 'laralum_blog_comments';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'post_id', 'comment'];


	public function post()
	{
		return $this->belongsTo('Laralum\Blog\Models\Post');
	}

	public function user()
	{
		return $this->belongsTo('Laralum\Users\Models\User');
	}

}
