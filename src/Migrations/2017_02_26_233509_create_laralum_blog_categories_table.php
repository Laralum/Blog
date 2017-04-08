<?php

use Laralum\Blog\Models\Category;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaralumBlogCategoriesTable extends Migration {

	public function up()
	{
		Schema::create('laralum_blog_categories', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Category::create([
			'name' => 'Uncategorized',
		]);
	}

	public function down()
	{
		Schema::dropIfExists('laralum_blog_categories');
	}
}
