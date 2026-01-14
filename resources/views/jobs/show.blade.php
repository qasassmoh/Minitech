<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Job Post Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('jobs.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                            ← Back to Jobs
                        </a>
                    </div>

                    <h1 class="text-3xl font-bold mb-2">{{ $jobPost->title }}</h1>
                    <p class="text-xl text-gray-600 mb-6">{{ $jobPost->company_name }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                        @if($jobPost->location)
                            <div>
                                <p class="text-sm text-gray-500">Location</p>
                                <p class="font-medium">{{ $jobPost->location }}</p>
                            </div>
                        @endif
                        @if($jobPost->job_type)
                            <div>
                                <p class="text-sm text-gray-500">Job Type</p>
                                <p class="font-medium">{{ $jobPost->job_type }}</p>
                            </div>
                        @endif
                        @if($jobPost->salary_min && $jobPost->salary_max)
                            <div>
                                <p class="text-sm text-gray-500">Salary Range</p>
                                <p class="font-medium">${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }}</p>
                            </div>
                        @endif
                        @if($jobPost->experience_required)
                            <div>
                                <p class="text-sm text-gray-500">Experience</p>
                                <p class="font-medium">{{ $jobPost->experience_required }}</p>
                            </div>
                        @endif
                    </div>

                    @if($jobPost->deadline)
                        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
                            <p class="text-sm text-yellow-800">
                                <strong>Application Deadline:</strong> {{ $jobPost->deadline->format('F d, Y') }}
                            </p>
                        </div>
                    @endif

                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Job Description</h3>
                        <div class="text-gray-700 whitespace-pre-wrap">{{ $jobPost->description }}</div>
                    </div>
                </div>
            </div>

            <!-- Application Form -->
            @if($hasApplied)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-900">Application Submitted</h3>
                            <p class="text-blue-700">You have already applied to this job. Thank you for your interest!</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-2xl font-bold mb-4">Apply for this Position</h2>

                        @if($errors->any())
                            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('jobs.apply', $jobPost) }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Resume Upload -->
                            <div class="mb-4">
                                <label for="resume" class="block text-sm font-medium text-gray-700 mb-2">
                                    Resume (PDF only, max 5MB) *
                                </label>
                                <input type="file" id="resume" name="resume" accept=".pdf" required
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">Please upload your resume in PDF format</p>
                                @error('resume')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Cover Letter -->
                            <div class="mb-6">
                                <label for="cover_letter" class="block text-sm font-medium text-gray-700 mb-2">
                                    Cover Letter (Optional)
                                </label>
                                <textarea id="cover_letter" name="cover_letter" rows="6"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Write a cover letter explaining why you're interested in this position...">{{ old('cover_letter') }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Maximum 2000 characters</p>
                                @error('cover_letter')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                                    Submit Application
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
