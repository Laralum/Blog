<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLaralumBlogCommentsTable extends Migration {

	public function up()
	{
		Schema::create('laralum_blog_comments', function(Blueprint $table) {
			$table->increments('id');
			$table->tinyInteger('user_id');
			$table->tinyInteger('post_id');
			$table->text('comment');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('laralum_blog_comments');
	}
}