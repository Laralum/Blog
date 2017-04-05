<?php

Route::group([
        'middleware' => [
            'web', 'laralum.base',
        ],
        'namespace' => 'Laralum\Blog\Controllers',
        'as' => 'laralum_public::'
    ], function () {
        if (\Illuminate\Support\Facades\Schema::hasTable('laralum_blog_settings')) {
            $public_url = \Laralum\Blog\Models\Settings::first()->public_url;
        } else {
            $public_url = 'blog';
        }

        Route::get($public_url, 'PublicCategoryController@index')->name('blog.categories.index');
        Route::get($public_url.'/categories/{category}', 'PublicCategoryController@show')->name('blog.categories.show');
        Route::get($public_url.'/categories/{category}/posts/{post}', 'PublicPostController@show')->name('blog.categories.posts.show');
});

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'auth',
            'can:publicAccess,Laralum\Blog\Models\Comment',
        ],
        'namespace' => 'Laralum\Blog\Controllers',
        'as' => 'laralum_public::'
    ], function () {
        if (\Illuminate\Support\Facades\Schema::hasTable('laralum_blog_settings')) {
            $public_url = \Laralum\Blog\Models\Settings::first()->public_url;
        } else {
            $public_url = 'blog';
        }

        Route::resource($public_url, 'PublicCommentController', [
            'names' => [
                'store' => 'blog.categories.posts.comments.store',
                'edit' => 'blog.categories.posts.comments.update',
                'update' => 'blog.categories.posts.comments.update',
                'destroy' => 'blog.categories.posts.comments.destroy',
            ],
            'only' => [
                'store', 'update', 'destroy'
            ],
        ]);
});


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

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Blog\Models\Settings',
        ],
        'prefix' => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Blog\Controllers',
        'as' => 'laralum::blog.'
    ], function () {
        Route::post('/blog/settings', 'SettingsController@update')->name('settings.update');
});
