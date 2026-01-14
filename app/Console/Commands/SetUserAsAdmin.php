<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class SetUserAsAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:set-admin {identifier : Username or email of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set a user as admin by username or email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $identifier = $this->argument('identifier');
        
        // Try to find user by username or email
        $user = User::where('username', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if (!$user) {
            $this->error("User not found with username or email: {$identifier}");
            return 1;
        }

        // Show current role
        $this->info("Found user: {$user->name} ({$user->username})");
        $this->info("Current role: " . ($user->role ?? 'NULL'));

        // Set as admin
        $user->role = 'admin';
        $user->save();

        $this->info("✓ User '{$user->username}' has been set as admin!");
        $this->info("You can now see the Admin Panel link in the navigation.");

        return 0;
    }
}
