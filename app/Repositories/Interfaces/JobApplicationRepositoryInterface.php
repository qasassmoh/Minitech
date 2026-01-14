<?php

namespace App\Repositories\Interfaces;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;

/**
 * Job Application Repository Interface
 * Following Interface Segregation Principle - focused interface for job application data access
 * Following Dependency Inversion Principle - abstraction for data access layer
 */
interface JobApplicationRepositoryInterface
{
    /**
     * Find an application by ID
     * Returns the application or null if not found
     */
    public function findById(int $id): ?JobApplication;

    /**
     * Check if user has already applied to a job post
     * Returns true if application exists
     */
    public function hasUserApplied(int $jobPostId, int $userId): bool;

    /**
     * Get existing application for user and job post
     * Returns the application or null if not found
     */
    public function getExistingApplication(int $jobPostId, int $userId): ?JobApplication;

    /**
     * Get all applications for a specific job post
     * Returns collection of applications with user relationship
     */
    public function getApplicationsForJob(int $jobPostId): Collection;

    /**
     * Create a new job application
     * Returns the created application
     */
    public function create(array $data): JobApplication;
}
