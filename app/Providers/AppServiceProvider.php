<?php

namespace App\Providers;

use App\Repositories\Interfaces\JobApplicationRepositoryInterface;
use App\Repositories\Interfaces\JobPostRepositoryInterface;
use App\Repositories\JobApplicationRepository;
use App\Repositories\JobPostRepository;
use App\Services\Interfaces\FileStorageServiceInterface;
use App\Services\Interfaces\JobApplicationServiceInterface;
use App\Services\Interfaces\JobPostServiceInterface;
use App\Services\FileStorageService;
use App\Services\JobApplicationService;
use App\Services\JobPostService;
use Illuminate\Support\ServiceProvider;

/**
 * Application Service Provider
 * Following Dependency Inversion Principle - binds interfaces to implementations
 * Following Open/Closed Principle - can be extended without modifying existing bindings
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Binds repository and service interfaces to their implementations
     */
    public function register(): void
    {
        // Repository bindings - Dependency Inversion Principle
        // Controllers depend on interfaces, not concrete implementations
        $this->app->bind(JobPostRepositoryInterface::class, JobPostRepository::class);
        $this->app->bind(JobApplicationRepositoryInterface::class, JobApplicationRepository::class);

        // Service bindings - Dependency Inversion Principle
        // Services depend on repository interfaces, not concrete implementations
        $this->app->bind(FileStorageServiceInterface::class, FileStorageService::class);
        $this->app->bind(JobPostServiceInterface::class, JobPostService::class);
        $this->app->bind(JobApplicationServiceInterface::class, JobApplicationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
