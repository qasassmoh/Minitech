<?php

namespace App\Repositories;

use App\Models\JobApplication;
use App\Repositories\Interfaces\JobApplicationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Job Application Repository Implementation
 * Following Single Responsibility Principle - only handles job application data access
 * Following Dependency Inversion Principle - implements interface, not concrete model logic
 */
class JobApplicationRepository implements JobApplicationRepositoryInterface
{
    /**
     * Find an application by ID
     * Returns the application or null if not found
     */
    public function findById(int $id): ?JobApplication
    {
        return JobApplication::find($id);
    }

    /**
     * Check if user has already applied to a job post
     * Returns true if application exists
     */
    public function hasUserApplied(int $jobPostId, int $userId): bool
    {
        return JobApplication::where('job_post_id', $jobPostId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Get existing application for user and job post
     * Returns the application or null if not found
     */
    public function getExistingApplication(int $jobPostId, int $userId): ?JobApplication
    {
        return JobApplication::where('job_post_id', $jobPostId)
            ->where('user_id', $userId)
            ->first();
    }

    /**
     * Get all applications for a specific job post
     * Returns collection of applications with user relationship
     */
    public function getApplicationsForJob(int $jobPostId): Collection
    {
        return JobApplication::where('job_post_id', $jobPostId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Create a new job application
     * Returns the created application
     */
    public function create(array $data): JobApplication
    {
        return JobApplication::create($data);
    }
}
