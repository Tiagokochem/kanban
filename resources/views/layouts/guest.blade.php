<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kanban System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
        <header class="py-6 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <div class="container mx-auto px-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="/" class="flex items-center gap-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400">
                            <rect width="6" height="18" x="4" y="3" rx="1" />
                            <rect width="6" height="12" x="14" y="9" rx="1" />
                        </svg>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kanban System</h1>
                    </a>
                </div>
            </div>
        </header>

        <div class="min-h-screen bg-gray-50 dark:bg-gray-800 py-12">
            <div class="container mx-auto px-4">
                <div class="max-w-md mx-auto bg-white dark:bg-gray-900 rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <footer class="py-8 bg-gray-800 dark:bg-gray-900 text-white">
            <div class="container mx-auto px-4">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="6" height="18" x="4" y="3" rx="1" />
                                <rect width="6" height="12" x="14" y="9" rx="1" />
                            </svg>
                            <span class="text-xl font-bold">Kanban System</span>
                        </div>
                        <p class="text-gray-300 mt-2">Simplify your workflow management</p>
                    </div>
                    <div>
                        <p>&copy; {{ date('Y') }} Kanban System. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
