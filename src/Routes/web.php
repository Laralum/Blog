<?php

if (\Illuminate\Support\Facades\Schema::hasTable('laralum_blog_settings')) {
    $public_url = \Laralum\Blog\Models\Settings::first()->public_url;
} else {
    $public_url = 'blog';
}
Route::group([
        'middleware' => [
            'web', 'laralum.base',
        ],
        'namespace' => 'Laralum\Blog\Controllers',
        'prefix' => $public_url,
        'as' => 'laralum_public::blog.'
    ], function () use ($public_url) {
        Route::get('/', 'PublicCategoryController@index')->name('categories.index');
        Route::get('/categories/{category}', 'PublicCategoryController@show')->name('categories.show');
        Route::get('/posts/{post}', 'PublicPostController@show')->name('posts.show');

        Route::group([
                'middleware' => [
                    'auth', 'can:publicAccess,Laralum\Blog\Models\Comment',
                ],
            ], function () use ($public_url) {
                Route::resource('comments', 'PublicCommentController', [
                    'names' => [
                        'store'   => 'comments.store',
                        'update'  => 'comments.update',
                        'destroy' => 'comments.destroy',
                    ],
                    'only' => [
                        'store', 'update', 'destroy'
                    ],
                ]);
        });

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
        Route::get('categories/{category}/delete', 'CategoryController@confirmDestroy')->name('categories.destroy.confirm');
        Route::resource('categories', 'CategoryController');
        Route::group([
                'middleware' => [
                    'can:access,Laralum\Blog\Models\Post',
                ],
            ], function () {
                Route::get('posts/{post}/delete', 'PostController@confirmDestroy')->name('posts.destroy.confirm');
                Route::resource('posts', 'PostController', ['except' => ['index']]);
                Route::group([
                        'middleware' => [
                            'can:access,Laralum\Blog\Models\Comment',
                        ],
                    ], function () {
                        Route::get('comments/{comment}/delete', 'CommentController@confirmDestroy')->name('comments.destroy.confirm');
                        Route::resource('comments', 'CommentController', ['only' => ['store', 'update', 'destroy']]);
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
