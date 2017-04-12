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
        'prefix'    => $public_url,
        'as'        => 'laralum_public::blog.',
    ], function () use ($public_url) {
        Route::get('/', 'PublicCategoryController@index')->name('categories.index');
        Route::get('/categories/{category}', 'PublicCategoryController@show')->name('categories.show');
        Route::get('/posts/{post}', 'PublicPostController@show')->name('posts.show');

        Route::group([
                'middleware' => [
                    'auth', 'can:publicAccess,Laralum\Blog\Models\Comment',
                ],
            ], function () use ($public_url) {
                Route::post('/post/{post}/comments', 'PublicCommentController@store')->name('comments.store');
                Route::patch('comments/{comment}', 'PublicCommentController@update')->name('comments.update');
                Route::delete('comments/{comment}', 'PublicCommentController@destroy')->name('comments.destroy');
            });
    });

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Blog\Models\Category',
        ],
        'prefix'    => config('laralum.settings.base_url').'/blog',
        'namespace' => 'Laralum\Blog\Controllers',
        'as'        => 'laralum::blog.',
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
                        Route::post('/post/{post}/comments', 'CommentController@store')->name('comments.store');
                        Route::patch('comments/{comment}', 'CommentController@update')->name('comments.update');
                        Route::get('comments/{comment}/destroy', 'CommentController@confirmDestroy')->name('comments.destroy.confirm');
                        Route::delete('comments/{comment}', 'CommentController@destroy')->name('comments.destroy');
                    });
            });
    });

Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Blog\Models\Settings',
        ],
        'prefix'    => config('laralum.settings.base_url'),
        'namespace' => 'Laralum\Blog\Controllers',
        'as'        => 'laralum::blog.',
    ], function () {
        Route::post('/blog/settings', 'SettingsController@update')->name('settings.update');
    });
