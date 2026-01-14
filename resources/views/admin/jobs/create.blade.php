<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-bold mb-6">Create New Job Post</h2>

                    <form action="{{ route('admin.jobs.store') }}" method="POST">
                        @csrf

                        <!-- Job Title -->
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Job Title *</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div class="mb-4">
                            <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('company_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Description -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Job Description *</label>
                            <textarea id="description" name="description" rows="6" required
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" id="location" name="location" value="{{ old('location') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('location')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Job Type -->
                        <div class="mb-4">
                            <label for="job_type" class="block text-sm font-medium text-gray-700 mb-2">Job Type</label>
                            <select id="job_type" name="job_type"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select Job Type</option>
                                <option value="Full-time" {{ old('job_type') == 'Full-time' ? 'selected' : '' }}>Full-time</option>
                                <option value="Part-time" {{ old('job_type') == 'Part-time' ? 'selected' : '' }}>Part-time</option>
                                <option value="Contract" {{ old('job_type') == 'Contract' ? 'selected' : '' }}>Contract</option>
                                <option value="Internship" {{ old('job_type') == 'Internship' ? 'selected' : '' }}>Internship</option>
                                <option value="Remote" {{ old('job_type') == 'Remote' ? 'selected' : '' }}>Remote</option>
                            </select>
                            @error('job_type')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Salary Range -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="salary_min" class="block text-sm font-medium text-gray-700 mb-2">Min Salary</label>
                                <input type="number" id="salary_min" name="salary_min" value="{{ old('salary_min') }}" step="0.01" min="0"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('salary_min')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="salary_max" class="block text-sm font-medium text-gray-700 mb-2">Max Salary</label>
                                <input type="number" id="salary_max" name="salary_max" value="{{ old('salary_max') }}" step="0.01" min="0"
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('salary_max')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Experience Required -->
                        <div class="mb-4">
                            <label for="experience_required" class="block text-sm font-medium text-gray-700 mb-2">Experience Required</label>
                            <input type="text" id="experience_required" name="experience_required" value="{{ old('experience_required') }}" placeholder="e.g., 2-5 years"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('experience_required')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="mb-4">
                            <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Application Deadline</label>
                            <input type="date" id="deadline" name="deadline" value="{{ old('deadline') }}"
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('deadline')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="mb-6">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" checked
                                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Active (Job post will be visible to applicants)</span>
                            </label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('admin.jobs.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                                Cancel
                            </a>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Create Job Post
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
