<?php

namespace App\Services\Interfaces;

use App\Models\JobPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Job Post Service Interface
 * Following Interface Segregation Principle - focused interface for job post business logic
 * Following Dependency Inversion Principle - abstraction for business operations
 */
interface JobPostServiceInterface
{
    /**
     * Get all job posts for admin dashboard
     * Returns paginated list with application counts
     */
    public function getAllJobPostsForAdmin(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get active job posts for users to browse
     * Returns paginated list of active, non-expired job posts
     */
    public function getActiveJobPostsForUsers(int $perPage = 10): LengthAwarePaginator;

    /**
     * Create a new job post
     * Returns the created job post
     */
    public function createJobPost(array $data, int $adminId): JobPost;

    /**
     * Update an existing job post
     * Returns true if updated successfully
     */
    public function updateJobPost(JobPost $jobPost, array $data): bool;

    /**
     * Delete a job post
     * Returns true if deleted successfully
     */
    public function deleteJobPost(JobPost $jobPost): bool;

    /**
     * Validate if job post is active and not expired
     * Returns true if job post is valid for application
     */
    public function isJobPostValidForApplication(JobPost $jobPost): bool;
}
