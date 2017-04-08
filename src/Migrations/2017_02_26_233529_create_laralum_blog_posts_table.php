<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaralumBlogPostsTable extends Migration {

	public function up()
	{
		Schema::create('laralum_blog_posts', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('category_id');
			$table->string('title');
			$table->string('description');
			$table->text('content');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('laralum_blog_posts');
	}
}
