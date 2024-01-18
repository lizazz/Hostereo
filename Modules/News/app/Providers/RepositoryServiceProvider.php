<?php

namespace Modules\News\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\News\app\Interfaces\PostRepositoryInterface;
use Modules\News\app\Interfaces\TagRepositoryInterface;
use Modules\News\app\Repositories\PostRepository;
use Modules\News\app\Repositories\TagRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
