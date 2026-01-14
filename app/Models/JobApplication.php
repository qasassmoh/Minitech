<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'job_post_id',
        'user_id',
        'resume_path',
        'cover_letter',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // Relationship: An application belongs to a job post
    public function jobPost(): BelongsTo
    {
        return $this->belongsTo(JobPost::class);
    }

    // Relationship: An application belongs to a user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
