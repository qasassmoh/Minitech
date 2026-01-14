<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role', // Add role to fillable for mass assignment
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is an admin
     * Helper method to check if the user has admin role
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Relationship: A user (admin) can post many jobs
    public function jobPosts(): HasMany
    {
        return $this->hasMany(JobPost::class, 'admin_id');
    }

    // Relationship: A user can apply to many jobs
    public function jobApplications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}
