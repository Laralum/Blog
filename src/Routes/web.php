<?php

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Blog\Models\Blog',
        ],
        'prefix' => config('laralum.settings.base_url').'/blog',
        'namespace' => 'Laralum\Blog\Controllers',
        'as' => 'laralum::blog.'
    ], function () {
        // First the suplementor, then the resource
        // https://laravel.com/docs/5.4/controllers#resource-controllers

        Route::get('categories/{category}/delete', 'CategoryController@confirmDestroy')->name('categories.destroy.confirm');
        Route::resource('categories', 'CategoryController');

        Route::get('posts/{post}/delete', 'PostController@confirmDestroy')->name('blog.posts.destroy.confirm');
        Route::resource('categories.posts', 'PostController');

        Route::get('comments/{role}/delete', 'CommentController@confirmDestroy')->name('blog.comments.destroy.confirm');
        Route::resource('cateogories.posts.comments', 'CommentController', ['except' => ['index', 'show', 'create']]);
});
