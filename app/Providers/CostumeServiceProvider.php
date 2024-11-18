<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CostumeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Services\FileUploadService::class, \App\Services\Impl\FileUploadServiceImpl::class);
        $this->app->bind(\App\Services\FileService::class, \App\Services\Impl\FileServiceImpl::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
