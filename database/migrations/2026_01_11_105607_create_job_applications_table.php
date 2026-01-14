<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Create job_applications table to store user applications with PDF resumes
     */
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained('job_posts')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('resume_path'); // Path to uploaded PDF file
            $table->text('cover_letter')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, accepted, rejected
            $table->timestamps();
            
            // Ensure a user can only apply once to a job
            $table->unique(['job_post_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
