<?php

namespace App\Services;

use App\Models\JobPost;
use App\Repositories\Interfaces\JobPostRepositoryInterface;
use App\Services\Interfaces\JobPostServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Job Post Service Implementation
 * Following Single Responsibility Principle - only handles job post business logic
 * Following Dependency Inversion Principle - depends on repository interface, not concrete implementation
 */
class JobPostService implements JobPostServiceInterface
{
    /**
     * Constructor injection - Dependency Inversion Principle
     * Depends on abstraction (interface), not concretion (repository)
     */
    public function __construct(
        private readonly JobPostRepositoryInterface $jobPostRepository
    ) {
    }

    /**
     * Get all job posts for admin dashboard
     * Returns paginated list with application counts
     */
    public function getAllJobPostsForAdmin(int $perPage = 10): LengthAwarePaginator
    {
        return $this->jobPostRepository->getAllWithApplicationCount($perPage);
    }

    /**
     * Get active job posts for users to browse
     * Returns paginated list of active, non-expired job posts
     */
    public function getActiveJobPostsForUsers(int $perPage = 10): LengthAwarePaginator
    {
        return $this->jobPostRepository->getActiveJobs($perPage);
    }

    /**
     * Create a new job post
     * Returns the created job post
     */
    public function createJobPost(array $data, int $adminId): JobPost
    {
        $data['admin_id'] = $adminId;
        return $this->jobPostRepository->create($data);
    }

    /**
     * Update an existing job post
     * Returns true if updated successfully
     */
    public function updateJobPost(JobPost $jobPost, array $data): bool
    {
        return $this->jobPostRepository->update($jobPost, $data);
    }

    /**
     * Delete a job post
     * Returns true if deleted successfully
     */
    public function deleteJobPost(JobPost $jobPost): bool
    {
        return $this->jobPostRepository->delete($jobPost);
    }

    /**
     * Validate if job post is active and not expired
     * Returns true if job post is valid for application
     */
    public function isJobPostValidForApplication(JobPost $jobPost): bool
    {
        if (!$jobPost->is_active) {
            return false;
        }

        if ($jobPost->deadline && $jobPost->deadline < now()) {
            return false;
        }

        return true;
    }
}
