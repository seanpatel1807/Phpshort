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

        .announcement {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: white;
        }

        .announcement-text {
            margin: 0;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased"
    style="background-color: {{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? '#333333' : '#ffffff' }}    ">
    <div class="image">
        <a href="{{ route('dashboard') }}">
            @if ($groupedSettings['appearance']->where('name', 'logo')->first())
                <img src="{{ asset('images/' . $groupedSettings['appearance']->where('name', 'logo')->first()->payload) }}"
                    alt="Logo" class="image1">
            @endif
        </a>
    </div>
    <div class="min-h-screen">
        @include('layouts.navigation')

        <body class="font-sans antialiased">
            <div class="flex">
                <!-- Sidebar -->
                <div class="flex flex-col flex-shrink-0 w-64 text-gray-700 bg-white"
                    style="background-color: {{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? '#333333' : '#ffffff' }}    ">

                    <nav class="flex-grow px-4 pb-4 md:block md:pb-0 md:overflow-y-auto">
                        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                            href='{{ route('dashboard') }}'>Dashboard</a>
                        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                            href="{{ route('links') }}">Links</a>
                        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                            href="{{ route('spaces') }}">Spaces</a>
                        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                            href="{{ route('domains') }}">Domains</a>
                        <a class="block px-4 py-2 mt-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                            href="{{ route('pixels') }}">Pixels</a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="block w-full px-4 py-2 text-sm font-semibold text-gray-900 bg-transparent rounded-lg dark:bg-transparent dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:focus:text-white dark:hover:text-white text-{{ $groupedSettings['appearance']->where('name', 'theme')->first()->payload === 'dark' ? 'white' : 'black' }} hover:text-gray-900 focus:text-gray-900 hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:shadow-outline">
                                Log Out
                            </button>
                        </form>
                    </nav>
                </div>

                <!-- Page Content -->
                <main class="flex-grow p-10">
                    {{ $slot }}
                </main>
                @if ($groupedSettings['announcements']->where('name', 'user')->first())
                    <div class="announcement"
                        style="background-color: {{ $groupedSettings['announcements']->where('name', 'user_color')->first()->payload }}">
                        <p class="announcement-text">
                            {{ $groupedSettings['announcements']->where('name', 'user')->first()->payload }}
                        </p>
                    </div>

                    <script>
                        setTimeout(function() {
                            document.querySelector('.announcement').style.display = 'none';
                        }, 5000);
                    </script>
                @endif

            </div>

        </body>

</html>
