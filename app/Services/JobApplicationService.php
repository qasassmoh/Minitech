<?php

namespace App\Services;

use App\Models\JobApplication;
use App\Repositories\Interfaces\JobApplicationRepositoryInterface;
use App\Services\Interfaces\FileStorageServiceInterface;
use App\Services\Interfaces\JobApplicationServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Job Application Service Implementation
 * Following Single Responsibility Principle - only handles job application business logic
 * Following Dependency Inversion Principle - depends on repository and service interfaces
 */
class JobApplicationService implements JobApplicationServiceInterface
{
    /**
     * Constructor injection - Dependency Inversion Principle
     * Depends on abstractions (interfaces), not concretions
     */
    public function __construct(
        private readonly JobApplicationRepositoryInterface $applicationRepository,
        private readonly FileStorageServiceInterface $fileStorageService
    ) {
    }

    /**
     * Check if user can apply to a job post
     * Returns true if user can apply (not already applied)
     */
    public function canUserApply(int $jobPostId, int $userId): bool
    {
        return !$this->applicationRepository->hasUserApplied($jobPostId, $userId);
    }

    /**
     * Create a new job application with resume
     * Returns the created application
     */
    public function createApplication(
        int $jobPostId,
        int $userId,
        UploadedFile $resume,
        ?string $coverLetter = null
    ): JobApplication {
        // Check if user already applied
        $existingApplication = $this->applicationRepository->getExistingApplication($jobPostId, $userId);
        if ($existingApplication) {
            throw new \Exception('You have already applied to this job.');
        }

        // Store the resume file
        $resumePath = $this->fileStorageService->storeFile($resume, 'resumes');

        // Create the application record
        return $this->applicationRepository->create([
            'job_post_id' => $jobPostId,
            'user_id' => $userId,
            'resume_path' => $resumePath,
            'cover_letter' => $coverLetter,
            'status' => 'pending',
        ]);
    }

    /**
     * Get all applications for a job post
     * Returns collection of applications with user data
     */
    public function getApplicationsForJob(int $jobPostId): Collection
    {
        return $this->applicationRepository->getApplicationsForJob($jobPostId);
    }

    /**
     * Download a resume file
     * Returns StreamedResponse for download (Laravel's Storage::download returns StreamedResponse)
     */
    public function downloadResume(JobApplication $application): StreamedResponse
    {
        // Check if file exists
        if (!$this->fileStorageService->fileExists($application->resume_path)) {
            abort(404, 'Resume file not found');
        }

        // Generate download name
        $downloadName = 'resume_' . $application->user->name . '.pdf';

        // Download the file
        return $this->fileStorageService->downloadFile($application->resume_path, $downloadName);
    }
}
