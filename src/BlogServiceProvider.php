<?php

namespace Laralum\Blog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

use Laralum\Blog\Models\Blog;
use Laralum\Blog\Policies\BlogPolicy;

use Laralum\Permissions\PermissionsChecker;


class BlogServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Blog::class => BlogPolicy::class,
    ];

    /**
     * The mandatory permissions for the module.
     *
     * @var array
     */
    protected $permissions = [
        [
            'name' => 'Blog Access',
            'slug' => 'laralum::blog.access',
            'desc' => "Grants access to laralum/blog module",
        ],
        [
            'name' => 'Create Category',
            'slug' => 'laralum::blog.cateogories.create',
            'desc' => "Allows creating cateogries",
        ],
        [
            'name' => 'Update Category',
            'slug' => 'laralum::blog.cateogories.update',
            'desc' => "Allows updating categories",
        ],
        [
            'name' => 'View Categories',
            'slug' => 'laralum::blog.cateogories.view',
            'desc' => "Allows view categories",
        ],
        [
            'name' => 'Delete Categories',
            'slug' => 'laralum::blog.cateogories.delete',
            'desc' => "Allows delete categories",
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

        $this->loadViewsFrom(__DIR__.'/Views', 'laralum_blog');

        $this->loadTranslationsFrom(__DIR__.'/Translations', 'laralum_blog');

        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Routes/web.php';
        }

        $this->loadMigrationsFrom(__DIR__.'/Migrations');

        // Make sure the permissions are OK
        PermissionsChecker::check($this->permissions);
    }

    /**
     * I cheated this comes from the AuthServiceProvider extended by the App\Providers\AuthServiceProvider
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
