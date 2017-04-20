<?php

namespace Laralum\Blog;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laralum\Blog\Models\Category;
use Laralum\Blog\Models\Comment;
use Laralum\Blog\Models\Post;
use Laralum\Blog\Models\Settings;
use Laralum\Blog\Policies\CategoryPolicy;
use Laralum\Blog\Policies\CommentPolicy;
use Laralum\Blog\Policies\PostPolicy;
use Laralum\Blog\Policies\SettingsPolicy;
use Laralum\Permissions\PermissionsChecker;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Comment::class  => CommentPolicy::class,
        Post::class     => PostPolicy::class,
        Settings::class => SettingsPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Blog Categories Access',
            'slug' => 'laralum::blog.categories.access',
            'desc' => 'Grants access to blog categories',
        ],
        [
            'name' => 'Create Blog Categories',
            'slug' => 'laralum::blog.categories.create',
            'desc' => 'Allows creating blog categories',
        ],
        [
            'name' => 'Update Blog Categories',
            'slug' => 'laralum::blog.categories.update',
            'desc' => 'Allows updating blog categories',
        ],
        [
            'name' => 'View Blog Categories',
            'slug' => 'laralum::blog.categories.view',
            'desc' => 'Allows view blog categories',
        ],
        [
            'name' => 'Delete Blog Categories',
            'slug' => 'laralum::blog.categories.delete',
            'desc' => 'Allows delete blog categories',
        ],
        [
            'name' => 'Blog Posts Access',
            'slug' => 'laralum::blog.posts.access',
            'desc' => 'Grants access to blog posts',
        ],
        [
            'name' => 'Create Blog Posts',
            'slug' => 'laralum::blog.posts.create',
            'desc' => 'Allows creating blog posts',
        ],
        [
            'name' => 'Update Blog Posts',
            'slug' => 'laralum::blog.posts.update',
            'desc' => 'Allows updating blog posts',
        ],
        [
            'name' => 'View Blog Posts',
            'slug' => 'laralum::blog.posts.view',
            'desc' => 'Allows view blog posts',
        ],
        [
            'name' => 'Delete Blog Posts',
            'slug' => 'laralum::blog.posts.delete',
            'desc' => 'Allows delete blog posts',
        ],
        [
            'name' => 'Blog Comments Access',
            'slug' => 'laralum::blog.comments.access',
            'desc' => 'Grants access to blog comments',
        ],
        [
            'name' => 'Create Blog Comments',
            'slug' => 'laralum::blog.comments.create',
            'desc' => 'Allows creating blog comments',
        ],
        [
            'name' => 'Update Blog Comments',
            'slug' => 'laralum::blog.comments.update',
            'desc' => 'Allows updating blog comments',
        ],
        [
            'name' => 'View Blog Comments',
            'slug' => 'laralum::blog.comments.view',
            'desc' => 'Allows view blog comments',
        ],
        [
            'name' => 'Delete Blog Comments',
            'slug' => 'laralum::blog.comments.delete',
            'desc' => 'Allows delete blog comments',
        ],
        [
            'name' => 'Blog Comments Access (public)',
            'slug' => 'laralum::blog.comments.access-public',
            'desc' => 'Grants access to blog comments',
        ],
        [
            'name' => 'Create Blog Comments (public)',
            'slug' => 'laralum::blog.comments.create-public',
            'desc' => 'Allows creating blog comments',
        ],
        [
            'name' => 'Update Blog Comments (public)',
            'slug' => 'laralum::blog.comments.update-public',
            'desc' => 'Allows updating blog comments',
        ],
        [
            'name' => 'View Blog Comments (public)',
            'slug' => 'laralum::blog.comments.view-public',
            'desc' => 'Allows view blog comments',
        ],
        [
            'name' => 'Delete Blog Comments (public)',
            'slug' => 'laralum::blog.comments.delete-public',
            'desc' => 'Allows delete blog comments',
        ],
        [
            'name' => 'Update Blog Settings',
            'slug' => 'laralum::blog.settings',
            'desc' => 'Allows update blog settings',
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        
        $this->publishes([
            __DIR__.'/Views/public' => resource_path('views/vendor/laralum/blog'),
        ], 'laralum_blog');
        
        $this->loadViewsFrom(__DIR__.'/Views', 'laralum_blog');

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_blog');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->app->register('GrahamCampbell\\Markdown\\MarkdownServiceProvider');

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider.
     *
     * Register the application's policies.
     *
     * @return void
     */
    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
