<?php

namespace App\Services\Interfaces;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Job Application Service Interface
 * Following Interface Segregation Principle - focused interface for job application business logic
 * Following Dependency Inversion Principle - abstraction for business operations
 */
interface JobApplicationServiceInterface
{
    /**
     * Check if user can apply to a job post
     * Returns true if user can apply (not already applied)
     */
    public function canUserApply(int $jobPostId, int $userId): bool;

    /**
     * Create a new job application with resume
     * Returns the created application
     */
    public function createApplication(
        int $jobPostId,
        int $userId,
        UploadedFile $resume,
        ?string $coverLetter = null
    ): JobApplication;

    /**
     * Get all applications for a job post
     * Returns collection of applications with user data
     */
    public function getApplicationsForJob(int $jobPostId): Collection;

    /**
     * Download a resume file
     * Returns StreamedResponse for download (Laravel's Storage::download returns StreamedResponse)
     */
    public function downloadResume(JobApplication $application): StreamedResponse;
}
