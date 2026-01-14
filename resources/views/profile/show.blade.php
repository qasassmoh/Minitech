<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap">
            <div class="w-full md:w-1/3 p-5">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="mb-4">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->username }}</h1>
                    </div>
                    <div class="flex gap-4 mb-4">
                        <div><strong>0</strong> posts</div>
                        <div><strong>0</strong> followers</div>
                        <div><strong>0</strong> following</div>
                    </div>
                    <div class="pt-4 font-bold text-gray-900">{{ $user->name }}</div>
                    <div class="text-gray-600">{{ $user->email }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

