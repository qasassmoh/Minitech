<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'admin_id',
        'title',
        'description',
        'company_name',
        'location',
        'job_type',
        'salary_min',
        'salary_max',
        'experience_required',
        'is_active',
        'deadline',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'deadline' => 'datetime',
            'is_active' => 'boolean',
            'salary_min' => 'decimal:2',
            'salary_max' => 'decimal:2',
        ];
    }

    // Relationship: A job post belongs to an admin
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relationship: A job post has many applications
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Get the route key for the model.
     * This tells Laravel to use 'id' for route model binding
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
