<?php

namespace Laralum\Blog\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'laralum_blog_categories';
	public $timestamps = true;

	public function posts()
	{
		return $this->hasMany('Laralum\Blog\Models\Post');
	}

}