<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLaralumBlogPostsTable extends Migration {

	public function up()
	{
		Schema::create('laralum_blog_posts', function(Blueprint $table) {
			$table->increments('id');
			$table->tinyInteger('user_id');
			$table->tinyInteger('blog_id');
			$table->string('title');
			$table->text('content');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('laralum_blog_posts');
	}
}