<?php

namespace App\Console\Commands;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Console\Command;

class CheckApplications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'application:check {job_id? : The job post ID to check}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check applications for a job post';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jobId = $this->argument('job_id');

        if ($jobId) {
            $jobPost = JobPost::find($jobId);
            
            if (!$jobPost) {
                $this->error("Job post with ID {$jobId} not found.");
                return 1;
            }

            $applications = $jobPost->applications()->with('user')->get();
            
            $this->info("Job Post: {$jobPost->title} (ID: {$jobPost->id})");
            $this->info("Total Applications: {$applications->count()}");
            $this->newLine();

            if ($applications->count() > 0) {
                $this->table(
                    ['ID', 'Applicant', 'Email', 'Status', 'Applied Date'],
                    $applications->map(function ($app) {
                        return [
                            $app->id,
                            $app->user->name . ' (' . $app->user->username . ')',
                            $app->user->email,
                            $app->status,
                            $app->created_at->format('Y-m-d H:i:s'),
                        ];
                    })->toArray()
                );
            } else {
                $this->warn("No applications found for this job post.");
            }
        } else {
            // List all applications
            $applications = JobApplication::with(['jobPost', 'user'])->get();
            
            $this->info("All Applications in System: {$applications->count()}");
            $this->newLine();

            if ($applications->count() > 0) {
                $this->table(
                    ['ID', 'Job Post', 'Applicant', 'Status', 'Date'],
                    $applications->map(function ($app) {
                        return [
                            $app->id,
                            $app->jobPost->title . ' (ID: ' . $app->job_post_id . ')',
                            $app->user->username,
                            $app->status,
                            $app->created_at->format('Y-m-d'),
                        ];
                    })->toArray()
                );
            }
        }

        return 0;
    }
}
