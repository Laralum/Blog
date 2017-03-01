<?php

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Blog\Models\Category',
        ],
        'prefix' => config('laralum.settings.base_url').'/blog',
        'namespace' => 'Laralum\Blog\Controllers',
        'as' => 'laralum::blog.'
    ], function () {
        // First the suplementor, then the resource
        // https://laravel.com/docs/5.4/controllers#resource-controllers

        Route::get('categories/{category}/delete', 'CategoryController@confirmDestroy')->name('categories.destroy.confirm');
        Route::resource('categories', 'CategoryController');
        Route::group([
                'middleware' => [
                    'can:access,Laralum\Blog\Models\Post',
                ],
            ], function () {
                // First the suplementor, then the resource
                // https://laravel.com/docs/5.4/controllers#resource-controllers

                Route::get('categories/{category}/posts/{post}/delete', 'PostController@confirmDestroy')->name('categories.posts.destroy.confirm');
                Route::resource('categories.posts', 'PostController', ['except' => ['index']]);
                Route::group([
                        'middleware' => [
                            'can:access,Laralum\Blog\Models\Comment',
                        ],
                    ], function () {
                        // First the suplementor, then the resource
                        // https://laravel.com/docs/5.4/controllers#resource-controllers

                        Route::get('categories/{category}/posts/{post}/comment/{comment}/delete', 'CommentController@confirmDestroy')->name('categories.posts.comments.destroy.confirm');
                        Route::resource('categories.posts.comments', 'CommentController', ['only' => ['store', 'update', 'destroy']]);
                });
        });
});
