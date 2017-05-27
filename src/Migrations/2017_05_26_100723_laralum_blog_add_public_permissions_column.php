<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaralumBlogAddPublicPermissionsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laralum_blog_settings', function (Blueprint $table) {
            $table->boolean('public_permissions');
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
            $table->dropColumn('public_permissions');
        });
    }
}
