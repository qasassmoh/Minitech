<?php

namespace App\Repositories\Interfaces;

use App\Models\JobPost;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Job Post Repository Interface
 * Following Interface Segregation Principle - focused interface for job post data access
 * Following Dependency Inversion Principle - abstraction for data access layer
 */
interface JobPostRepositoryInterface
{
    /**
     * Get all job posts with pagination
     * Returns paginated list of all job posts
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator;

    /**
     * Get all active job posts that are not expired
     * Returns collection of active job posts
     */
    public function getActiveJobs(int $perPage = 10): LengthAwarePaginator;

    /**
     * Find a job post by ID
     * Returns the job post or null if not found
     */
    public function findById(int $id): ?JobPost;

    /**
     * Create a new job post
     * Returns the created job post
     */
    public function create(array $data): JobPost;

    /**
     * Update an existing job post
     * Returns true if updated successfully
     */
    public function update(JobPost $jobPost, array $data): bool;

    /**
     * Delete a job post
     * Returns true if deleted successfully
     */
    public function delete(JobPost $jobPost): bool;

    /**
     * Get job posts with application count
     * Returns paginated list with applications_count
     */
    public function getAllWithApplicationCount(int $perPage = 10): LengthAwarePaginator;
}
