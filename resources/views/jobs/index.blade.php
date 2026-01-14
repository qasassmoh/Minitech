<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-2">Available Job Opportunities</h1>
                    <p class="text-gray-600">Browse and apply to job postings</p>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($jobPosts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($jobPosts as $jobPost)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition-shadow">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $jobPost->title }}</h3>
                                    @if($jobPost->is_active)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    @endif
                                </div>
                                <p class="text-lg text-gray-600 mb-2">{{ $jobPost->company_name }}</p>
                                
                                <div class="space-y-1 mb-4">
                                    @if($jobPost->location)
                                        <p class="text-sm text-gray-500"><strong>Location:</strong> {{ $jobPost->location }}</p>
                                    @endif
                                    @if($jobPost->job_type)
                                        <p class="text-sm text-gray-500"><strong>Type:</strong> {{ $jobPost->job_type }}</p>
                                    @endif
                                    @if($jobPost->salary_min && $jobPost->salary_max)
                                        <p class="text-sm text-gray-500">
                                            <strong>Salary:</strong> ${{ number_format($jobPost->salary_min) }} - ${{ number_format($jobPost->salary_max) }}
                                        </p>
                                    @endif
                                </div>

                                <p class="text-sm text-gray-700 mb-4 line-clamp-3">
                                    {{ Str::limit($jobPost->description, 150) }}
                                </p>

                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-gray-500">
                                        Posted {{ $jobPost->created_at->diffForHumans() }}
                                    </span>
                                    <a href="{{ route('jobs.show', $jobPost) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $jobPosts->links() }}
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <p class="text-gray-500 text-lg">No job opportunities available at the moment.</p>
                        <p class="text-gray-400 text-sm mt-2">Check back later for new job postings.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
