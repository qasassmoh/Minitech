<?php

namespace App\Repositories;

use App\Models\JobPost;
use App\Repositories\Interfaces\JobPostRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Job Post Repository Implementation
 * Following Single Responsibility Principle - only handles job post data access
 * Following Dependency Inversion Principle - implements interface, not concrete model logic
 */
class JobPostRepository implements JobPostRepositoryInterface
{
    /**
     * Get all job posts with pagination
     * Returns paginated list of all job posts
     */
    public function getAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return JobPost::orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all active job posts that are not expired
     * Returns collection of active job posts
     */
    public function getActiveJobs(int $perPage = 10): LengthAwarePaginator
    {
        return JobPost::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('deadline')
                    ->orWhere('deadline', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Find a job post by ID
     * Returns the job post or null if not found
     */
    public function findById(int $id): ?JobPost
    {
        return JobPost::find($id);
    }

    /**
     * Create a new job post
     * Returns the created job post
     */
    public function create(array $data): JobPost
    {
        return JobPost::create($data);
    }

    /**
     * Update an existing job post
     * Returns true if updated successfully
     */
    public function update(JobPost $jobPost, array $data): bool
    {
        return $jobPost->update($data);
    }

    /**
     * Delete a job post
     * Returns true if deleted successfully
     */
    public function delete(JobPost $jobPost): bool
    {
        return $jobPost->delete();
    }

    /**
     * Get job posts with application count
     * Returns paginated list with applications_count
     */
    public function getAllWithApplicationCount(int $perPage = 10): LengthAwarePaginator
    {
        return JobPost::withCount('applications')
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
