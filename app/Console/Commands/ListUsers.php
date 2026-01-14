<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all users with their roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all(['id', 'username', 'email', 'role', 'name']);
        
        $this->info("All Users in the System:");
        $this->table(
            ['ID', 'Username', 'Name', 'Email', 'Role'],
            $users->map(function ($user) {
                return [
                    $user->id,
                    $user->username,
                    $user->name,
                    $user->email,
                    $user->role ?? 'NULL',
                ];
            })->toArray()
        );

        return 0;
    }
}
