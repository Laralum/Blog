<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaralumBlogCommentsTable extends Migration {

	public function up()
	{
		Schema::create('laralum_blog_comments', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('post_id');
			$table->text('comment');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('laralum_blog_comments');
	}
}
