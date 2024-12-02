<?php

namespace App\Providers;

use App\Repositories\Interfaces\ShortenedUrlRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ShortenedUrlRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ShortenedUrlRepositoryInterface::class, ShortenedUrlRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
