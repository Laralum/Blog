<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLaralumBlogCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('laralum_blog_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('description');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('laralum_blog_categories');
	}
}
