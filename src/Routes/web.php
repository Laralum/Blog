<?php

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Blog\Models\Blog',
        ],
        'prefix' => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Blog\Controllers',
        'as' => 'laralum::blog.'
    ], function () {
        // First the suplementor, then the resource
        // https://laravel.com/docs/5.4/controllers#resource-controllers

        Route::get('blog/categories/{category}/delete', 'CategoryController@confirmDelete')->name('categories.destroy.confirm');
        Route::resource('categories', 'CategoryController', ['except' => ['show']]);

        Route::get('blog/posts/{post}/delete', 'PostController@confirmDelete')->name('blog.posts.destroy.confirm');
        Route::resource('categories.posts', 'PostController');

        Route::get('blog/comments/{role}/delete', 'CommentController@confirmDelete')->name('blog.comments.destroy.confirm');
        Route::resource('cateogories.posts.comments', 'CommentController', ['except' => ['index', 'show', 'create']]);
});
