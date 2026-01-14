<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Simple Navbar -->
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <!-- Minitech Logo and Title -->
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <img src="{{ asset('img/instagram.svg') }}" alt="Logo" class="w-10 h-10">
                        <h1 class="text-2xl font-bold text-gray-900">minitech</h1>
                    </div>

                    <!-- Navigation Links and Auth Buttons -->
                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('register') }}" class="text-gray-700 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                                Register as User
                            </a>
                            <a href="{{ route('register.admin') }}" class="text-gray-700 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                                Register as Admin
                            </a>
                            <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Login
                            </a>
                        @else
                            <!-- Navigation Links for Authenticated Users -->
                            <a href="{{ route('home') }}" class="text-gray-700 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                                Home
                            </a>
                            <a href="{{ route('jobs.index') }}" class="text-gray-700 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                                Browse Jobs
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.jobs.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-bold shadow-md">
                                    🛠️ Admin Panel
                                </a>
                            @endif
                            <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                                {{ auth()->user()->username }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-700 hover:text-gray-900 px-4 py-2 rounded-md text-sm font-medium">
                                    Logout
                                </button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
    </body>
</html>
