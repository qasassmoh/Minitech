<?php

namespace App\Console\Commands;

use App\Models\JobPost;
use App\Models\User;
use Illuminate\Console\Command;

class CheckJobPostOwnership extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:check-ownership {job_id? : The job post ID to check} {--transfer-to= : Username or email to transfer job to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check job post ownership and optionally transfer to another admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jobId = $this->argument('job_id');
        $transferTo = $this->option('transfer-to');

        if ($jobId) {
            // Check specific job post
            $jobPost = JobPost::find($jobId);
            
            if (!$jobPost) {
                $this->error("Job post with ID {$jobId} not found.");
                return 1;
            }

            $admin = $jobPost->admin;
            $this->info("Job Post #{$jobPost->id}: {$jobPost->title}");
            $this->info("Current Owner: {$admin->name} ({$admin->username}) - ID: {$admin->id}");
            $this->info("Admin Role: " . ($admin->role ?? 'NULL'));

            if ($transferTo) {
                // Transfer job to another admin
                $newAdmin = User::where('username', $transferTo)
                    ->orWhere('email', $transferTo)
                    ->first();

                if (!$newAdmin) {
                    $this->error("User not found: {$transferTo}");
                    return 1;
                }

                if (!$newAdmin->isAdmin()) {
                    $this->error("User '{$newAdmin->username}' is not an admin. Set them as admin first using: php artisan user:set-admin {$newAdmin->username}");
                    return 1;
                }

                $jobPost->admin_id = $newAdmin->id;
                $jobPost->save();

                $this->info("✓ Job post transferred to: {$newAdmin->name} ({$newAdmin->username})");
            }
        } else {
            // List all job posts
            $this->info("All Job Posts:");
            $this->table(
                ['ID', 'Title', 'Owner', 'Owner ID', 'Owner Role'],
                JobPost::with('admin')->get()->map(function ($job) {
                    return [
                        $job->id,
                        $job->title,
                        $job->admin->username ?? 'N/A',
                        $job->admin_id,
                        $job->admin->role ?? 'NULL',
                    ];
                })->toArray()
            );
        }

        return 0;
    }
}
