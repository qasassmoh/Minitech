<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\JobPostServiceInterface;
use Illuminate\View\View;

/**
 * Home Controller
 * Following Single Responsibility Principle - only handles home page display
 * Following Dependency Inversion Principle - depends on service interface, not concrete implementation
 */
class HomeController extends Controller
{
    /**
     * Constructor injection - Dependency Inversion Principle
     * Depends on abstraction (interface), not concretion (service)
     */
    public function __construct(
        private readonly JobPostServiceInterface $jobPostService
    ) {
    }

    /**
     * Display the home page with active job posts
     * Shows all active, non-expired job posts to everyone
     */
    public function index(): View
    {
        // Use service to get active job posts - business logic is in service
        $jobPosts = $this->jobPostService->getActiveJobPostsForUsers(10);

        return view('home', compact('jobPosts'));
    }
}
