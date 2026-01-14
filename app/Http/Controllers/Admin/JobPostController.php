<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobPostRequest;
use App\Models\JobPost;
use App\Services\Interfaces\JobApplicationServiceInterface;
use App\Services\Interfaces\JobPostServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Job Post Controller (Admin)
 * Following Single Responsibility Principle - only handles HTTP requests/responses for job posts
 * Following Dependency Inversion Principle - depends on service interfaces, not concrete implementations
 */
class JobPostController extends Controller
{
    /**
     * Constructor injection - Dependency Inversion Principle
     * Depends on abstractions (interfaces), not concretions
     */
    public function __construct(
        private readonly JobPostServiceInterface $jobPostService,
        private readonly JobApplicationServiceInterface $applicationService
    ) {
    }

    /**
     * Display a listing of job posts (admin dashboard)
     * Shows all job posts with application counts
     */
    public function index(): View
    {
        // Use service to get all job posts for admin - business logic is in service
        $jobPosts = $this->jobPostService->getAllJobPostsForAdmin(10);

        return view('admin.jobs.index', compact('jobPosts'));
    }

    /**
     * Show the form for creating a new job post
     */
    public function create(): View
    {
        return view('admin.jobs.create');
    }

    /**
     * Store a newly created job post
     * Validation is handled by JobPostRequest (SRP)
     * Business logic is handled by service (SRP)
     */
    public function store(JobPostRequest $request): RedirectResponse
    {
        // Get validated data from request
        $validated = $request->validated();

        // Use service to create job post - business logic is in service
        $this->jobPostService->createJobPost($validated, $request->user()->id);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job post created successfully!');
    }

    /**
     * Display the specified job post with applications
     * Route parameter is 'job' (from resource route), but we use $jobPost for clarity
     */
    public function show(JobPost $job): View
    {
        // Reload job post with admin relationship
        $job->load('admin');

        // Use service to get applications - business logic is in service
        $applications = $this->applicationService->getApplicationsForJob($job->id);

        return view('admin.jobs.show', ['jobPost' => $job, 'applications' => $applications]);
    }

    /**
     * Show the form for editing the specified job post
     * Any admin can edit any job post
     */
    public function edit(JobPost $job): View
    {
        return view('admin.jobs.edit', ['jobPost' => $job]);
    }

    /**
     * Update the specified job post
     * Validation is handled by JobPostRequest (SRP)
     * Business logic is handled by service (SRP)
     */
    public function update(JobPostRequest $request, JobPost $job): RedirectResponse
    {
        // Get validated data from request
        $validated = $request->validated();

        // Use service to update job post - business logic is in service
        $this->jobPostService->updateJobPost($job, $validated);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job post updated successfully!');
    }

    /**
     * Remove the specified job post
     * Business logic is handled by service (SRP)
     */
    public function destroy(JobPost $job): RedirectResponse
    {
        // Use service to delete job post - business logic is in service
        $this->jobPostService->deleteJobPost($job);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job post deleted successfully!');
    }
}
