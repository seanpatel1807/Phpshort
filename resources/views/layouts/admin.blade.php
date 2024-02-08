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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // Add a script to handle button click and show/hide links
        document.addEventListener('DOMContentLoaded', function() {
            const settingsToggle = document.getElementById('settings-toggle');
            const settingsLinks = document.getElementById('settings-links');

            settingsToggle.addEventListener('click', function() {
                settingsLinks.classList.toggle('hidden');
            });
        });
    </script>
    <style>
        .image {
            position: absolute;
            top: 10px;
            left: 60px;
            height: 50px;
            width: 50px;
        }

        .image1 {
            height: 50px;
            width: 50px;
        }

        .common-link {
            display: block;
            padding: 4px 16px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .common-link:hover {
            background-color: #e5e5e5;
            /* Adjust the color as needed */
        }

        .common-link:focus,
        .common-link:hover,
        .common-link:active {
            outline: none;
            text-decoration: none;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="font-sans antialiased"
    style="background-color: {{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? '#333333' : '#ffffff' }}    ">
    @php
        $textColorClass = $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black';
    @endphp
    <div class="image">
        <a href="{{ route('dashboard') }}">
            @if ($groupedSettings['appearance']->where('name', 'logo')->first())
                <img src="{{ asset('images/' . $groupedSettings['appearance']->where('name', 'logo')->first()->payload) }}"
                    alt="Logo" class="image1">
            @else
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 text-{{ $textColorClass }}" />
            @endif
        </a>
    </div>
    <div class="min-h-screen text-{{ $textColorClass }}">
        @include('layouts.navigation')

        <div class="flex">
            <!-- Sidebar -->
            <div
                class="flex flex-col flex-shrink-0 w-64 text-gray-700 bg-white text-{{ $textColorClass }} "style="background-color: {{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? '#333333' : '#ffffff' }}    ">
                <nav class="flex-grow px-4 pb-4 md:block md:pb-0 md:overflow-y-auto">
                    <a class="common-link text-{{ $textColorClass }} " href='{{ route('dashboard') }}'>Dashboard</a>
                    <a class="common-link text-{{ $textColorClass }} " href="{{ route('links') }}">Links</a>
                    <a class="common-link text-{{ $textColorClass }} " href="{{ route('spaces') }}">Spaces</a>
                    <a class="common-link text-{{ $textColorClass }} " href="{{ route('domains') }}">Domains</a>
                    <a class="common-link text-{{ $textColorClass }} " href="{{ route('pixels') }}">Pixels</a>
                    <a class="common-link text-{{ $textColorClass }} " href="{{ route('users.index') }}">Users</a>
                    <a class="common-link text-{{ $textColorClass }} " href="{{ route('pages.index') }}">Pages</a>
                    <div id="settings-category" class="mb-4">
                        <button id="settings-toggle"
                            class="flex items-center justify-between w-full px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white text-{{ $textColorClass }} hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                            <span>Settings</span>
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400 transform rotate-0 transition-transform duration-300"
                                :class="{ 'rotate-180': open, 'rotate-0': !open }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="settings-links" class="hidden">
                            <a class="common-link" href="{{ route('admin.general') }}">General</a>

                            <a class="common-link" href="{{ route('admin.appearance') }}">Appearance</a>

                            <a class="common-link" href="{{ route('admin.social') }}">Social</a>

                            <a class="common-link" href="{{ route('admin.announcement') }}">Announcement</a>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="mt-4">
                        @csrf
                        <button type="submit"
                            class="block w-full px-4 py-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white text-{{ $textColorClass }} hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                            Log Out
                        </button>
                    </form>
                </nav>
            </div>

            <!-- Page Content -->
            <main class="flex-grow p-10">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
