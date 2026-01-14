<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\Admin\JobPostController;
use Illuminate\Support\Facades\Route;

// Home page: show the home view with job posts (accessible to everyone)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Handle browser logger endpoint (for development tools - harmless)
Route::post('/_boost/browser-logs', function () {
    return response()->json(['status' => 'ok'], 200);
})->middleware('web');

// Optional: keep /dashboard URL working and showing the same page
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    // Job posts routes (for users to view and apply)
    Route::get('/jobs', [JobApplicationController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{jobPost}', [JobApplicationController::class, 'show'])->name('jobs.show');
    Route::post('/jobs/{jobPost}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
    Route::get('/applications/{application}/resume', [JobApplicationController::class, 'downloadResume'])->name('applications.resume');
});

// Admin routes for managing job posts
// Using admin middleware for authorization (SRP - middleware handles authorization)
// Note: Form requests also check authorization for extra security
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Resource routes for job post management
    // Use 'job' as the route parameter name to match Laravel's resource route convention
    Route::resource('jobs', JobPostController::class)->parameters([
        'jobs' => 'job' // This tells Laravel to use 'job' as the parameter name
    ]);
});

require __DIR__.'/auth.php';
