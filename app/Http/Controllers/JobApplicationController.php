<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationRequest;
use App\Models\JobApplication;
use App\Models\JobPost;
use App\Repositories\Interfaces\JobApplicationRepositoryInterface;
use App\Services\Interfaces\JobApplicationServiceInterface;
use App\Services\Interfaces\JobPostServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Job Application Controller
 * Following Single Responsibility Principle - only handles HTTP requests/responses for job applications
 * Following Dependency Inversion Principle - depends on service interfaces, not concrete implementations
 */
class JobApplicationController extends Controller
{
    /**
     * Constructor injection - Dependency Inversion Principle
     * Depends on abstractions (interfaces), not concretions
     */
    public function __construct(
        private readonly JobPostServiceInterface $jobPostService,
        private readonly JobApplicationServiceInterface $applicationService,
        private readonly JobApplicationRepositoryInterface $applicationRepository
    ) {
    }

    /**
     * Display a list of available jobs for users to apply
     * Shows all active job posts that users can apply to
     */
    public function index(): View
    {
        // Use service to get active job posts - business logic is in service
        $jobPosts = $this->jobPostService->getActiveJobPostsForUsers(10);

        return view('jobs.index', compact('jobPosts'));
    }

    /**
     * Show a specific job post for application
     * Displays job details and application form
     */
    public function show(JobPost $jobPost): View
    {
        // Use service to validate job post - business logic is in service
        if (!$this->jobPostService->isJobPostValidForApplication($jobPost)) {
            abort(404, 'Job post not found or expired');
        }

        // Check if user already applied using repository
        $hasApplied = $this->applicationRepository->hasUserApplied($jobPost->id, auth()->id());

        return view('jobs.show', compact('jobPost', 'hasApplied'));
    }

    /**
     * Store a new job application with PDF resume
     * Validation is handled by JobApplicationRequest (SRP)
     * Business logic is handled by service (SRP)
     */
    public function store(JobApplicationRequest $request, JobPost $jobPost): RedirectResponse
    {
        try {
            // Use service to create application - business logic is in service
            $this->applicationService->createApplication(
                $jobPost->id,
                $request->user()->id,
                $request->file('resume'),
                $request->input('cover_letter')
            );

            return redirect()->route('jobs.index')
                ->with('success', 'Application submitted successfully!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Download a user's submitted resume (for admin review)
     * Allows admin to download PDF resumes submitted by applicants
     * Returns StreamedResponse (Laravel's Storage::download returns StreamedResponse)
     */
    public function downloadResume(JobApplication $application): StreamedResponse
    {
        // Check authorization: admin or the applicant themselves
        if (!auth()->user()->isAdmin() && $application->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        // Use service to download resume - business logic is in service
        return $this->applicationService->downloadResume($application);
    }
}
