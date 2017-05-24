<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDisqusSettingsColumnsLaralumBlogSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laralum_blog_settings', function (Blueprint $table) {
            $table->string('comments_system')->default('laralum');
            $table->string('disqus_username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laralum_blog_settings', function (Blueprint $table) {
            $table->dropColumn('comments_system');
            $table->dropColumn('disqus_username');
        });
    }
}
