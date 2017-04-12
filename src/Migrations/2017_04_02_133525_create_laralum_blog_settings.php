<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laralum\Blog\Models\Settings;

class CreateLaralumBlogSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laralum_blog_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('text_editor');
            $table->string('public_url');
            $table->timestamps();
        });

        Settings::create([
            'text_editor' => 'markdown',
            'public_url'  => 'blog',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laralum_blog_settings');
    }
}
