<?php

if (\Illuminate\Support\Facades\Schema::hasTable('laralum_blog_settings')) {
    $public_url = \Laralum\Blog\Models\Settings::first()->public_url;
    $comments_system = \Laralum\Blog\Models\Settings::first()->comments_system;
} else {
    $public_url = 'blog';
    $comments_system = 'laralum';
}

// Public routes
Route::group([
        'middleware' => [
            'web', 'laralum.base',
        ],
        'namespace' => 'Laralum\Blog\Controllers',
        'prefix'    => $public_url,
        'as'        => 'laralum_public::blog.',
    ], function () use ($public_url) {
        Route::get('/categories', 'PublicCategoryController@index')->name('categories.index');
        Route::get('/{category?}', 'PublicCategoryController@show')->name('categories.show');
        Route::get('/post/{post}', 'PublicPostController@show')->name('posts.show');

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

// Administration routes
Route::group([
        'middleware' => [
            'web', 'laralum.base', 'laralum.auth',
            'can:access,Laralum\Blog\Models\Category',
        ],
        'prefix'    => config('laralum.settings.base_url').'/blog',
        'namespace' => 'Laralum\Blog\Controllers',
        'as'        => 'laralum::blog.',
    ], function () use ($comments_system) {
        Route::get('categories/{category}/delete', 'CategoryController@confirmDestroy')->name('categories.destroy.confirm');
        Route::resource('categories', 'CategoryController');
        Route::group([
                'middleware' => [
                    'can:access,Laralum\Blog\Models\Post',
                ],
            ], function () use ($comments_system) {
                Route::get('posts/{post}/delete', 'PostController@confirmDestroy')->name('posts.destroy.confirm');
                Route::resource('posts', 'PostController', ['except' => ['index']]);
                if ($comments_system == 'laralum') {
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
                }
            });
    });

// Settings routes
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
