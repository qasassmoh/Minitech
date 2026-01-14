<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Job Post Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl font-bold">{{ $jobPost->title ?? 'N/A' }}</h1>
                            <p class="text-xl text-gray-600 mt-2">{{ $jobPost->company_name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500 mt-1">
                                Created by: <strong>{{ $jobPost->admin->username ?? 'N/A' }}</strong>
                                @if($jobPost->admin_id === auth()->id())
                                    <span class="text-green-600">(You)</span>
                                @endif
                            </p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.jobs.edit', $jobPost) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Edit
                            </a>
                            <a href="{{ route('admin.jobs.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded">
                                Back to List
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <p class="text-sm text-gray-500">Location</p>
                            <p class="font-medium">{{ $jobPost->location ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Job Type</p>
                            <p class="font-medium">{{ $jobPost->job_type ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Salary Range</p>
                            <p class="font-medium">
                                @if($jobPost->salary_min && $jobPost->salary_max)
                                    ${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }}
                                @else
                                    Not specified
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Experience Required</p>
                            <p class="font-medium">{{ $jobPost->experience_required ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            @if($jobPost->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactive</span>
                            @endif
                        </div>
                        @if($jobPost->deadline)
                            <div>
                                <p class="text-sm text-gray-500">Deadline</p>
                                <p class="font-medium">{{ $jobPost->deadline->format('M d, Y') }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-2">Job Description</h3>
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $jobPost->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Applications Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Applications ({{ $applications->count() }})</h2>
                        @if($applications->count() > 0)
                            <span class="text-sm text-gray-600">Click on applicant name or download resume to view details</span>
                        @endif
                    </div>

                    @if($applications->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applied Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($applications as $application)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $application->user->name ?? 'N/A' }}</div>
                                                <div class="text-sm text-gray-500">{{ $application->user->username ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">{{ $application->user->email ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                    @if($application->status == 'accepted') bg-green-100 text-green-800
                                                    @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                                    @elseif($application->status == 'reviewed') bg-blue-100 text-blue-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    {{ ucfirst($application->status ?? 'pending') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $application->created_at ? $application->created_at->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex flex-col space-y-2">
                                                    <a href="{{ route('applications.resume', $application) }}" class="text-blue-600 hover:text-blue-900 font-medium" target="_blank">
                                                        📄 Download Resume (PDF)
                                                    </a>
                                                    @if($application->cover_letter)
                                                        <button onclick="showCoverLetter('{{ $application->id }}', `{{ addslashes($application->cover_letter) }}`)" class="text-indigo-600 hover:text-indigo-900 text-left">
                                                            📝 View Cover Letter
                                                        </button>
                                                    @else
                                                        <span class="text-gray-400 text-xs">No cover letter</span>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">No applications yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Cover Letter Modal -->
    <div id="coverLetterModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Cover Letter</h3>
                <div id="coverLetterContent" class="text-gray-700 whitespace-pre-wrap border p-4 rounded max-h-96 overflow-y-auto"></div>
                <div class="mt-4 flex justify-end">
                    <button onclick="closeCoverLetter()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showCoverLetter(id, content) {
            document.getElementById('coverLetterContent').textContent = content;
            document.getElementById('coverLetterModal').classList.remove('hidden');
        }

        function closeCoverLetter() {
            document.getElementById('coverLetterModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
