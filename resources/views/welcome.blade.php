<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kanban System</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-white">
        <header class="py-6 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
            <div class="container mx-auto px-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400">
                        <rect width="6" height="18" x="4" y="3" rx="1" />
                        <rect width="6" height="12" x="14" y="9" rx="1" />
                    </svg>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kanban System</h1>
                </div>
                <nav>
                    @if (Route::has('login'))
                        <div class="flex items-center gap-4">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2 border border-gray-300 dark:border-blue-400 hover:border-gray-400 dark:hover:border-blue-300 bg-transparent dark:bg-blue-600 text-gray-800 dark:text-white rounded-md font-medium transition-colors">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </nav>
            </div>
        </header>

        <section class="py-16 bg-gray-50 dark:bg-gray-800">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl mx-auto">
                    <h2 class="text-4xl font-bold mb-6 text-center text-gray-900 dark:text-white">Streamline Your Workflow with Our Kanban System</h2>
                    <p class="text-xl mb-8 text-gray-700 dark:text-white text-center">Visualize your work, limit work in progress, and maximize efficiency with our intuitive Kanban board system.</p>
                    @if (Route::has('register'))
                        <div class="flex justify-center gap-4">
                            <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">Get Started</a>
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-5 py-2 border border-gray-300 dark:border-blue-400 hover:border-gray-400 dark:hover:border-blue-300 bg-transparent dark:bg-blue-600 text-gray-800 dark:text-white rounded-md font-medium transition-colors">Go to Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2 border border-gray-300 dark:border-blue-400 hover:border-gray-400 dark:hover:border-blue-300 bg-transparent dark:bg-blue-600 text-gray-800 dark:text-white rounded-md font-medium transition-colors">Log In</a>
                            @endauth
                        </div>
                    @endif
                </div>
                <div class="mt-12">
                    <img src="https://placehold.co/1200x600/3b82f6/FFFFFF/png?text=Kanban+Board+Visualization" alt="Kanban Board Example" class="w-full rounded-lg shadow-lg">
                </div>
            </div>
        </section>

        <section class="py-16 bg-white dark:bg-gray-900">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold mb-12 text-center text-gray-900 dark:text-white">Key Features</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400 mb-4">
                            <rect width="18" height="18" x="3" y="3" rx="2" />
                            <path d="M3 9h18" />
                            <path d="M9 21V9" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Visual Workflow</h3>
                        <p class="text-gray-700 dark:text-white">Visualize your project workflow with customizable boards, columns, and cards.</p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400 mb-4">
                            <path d="M12 20v-6" />
                            <path d="M6 20V10" />
                            <path d="M18 20V4" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Work in Progress Limits</h3>
                        <p class="text-gray-700 dark:text-white">Set WIP limits to prevent bottlenecks and improve team efficiency.</p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400 mb-4">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Real-time Updates</h3>
                        <p class="text-gray-700 dark:text-white">Collaborate with your team in real-time with instant updates and notifications.</p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400 mb-4">
                            <path d="M2 9V5c0-1.1.9-2 2-2h3.93a2 2 0 0 1 1.66.9l.82 1.2a2 2 0 0 0 1.66.9H20a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-1" />
                            <path d="M2 13h10" />
                            <path d="m9 16 3-3-3-3" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Customizable Workflows</h3>
                        <p class="text-gray-700 dark:text-white">Create custom workflows that match your team's unique processes.</p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400 mb-4">
                            <path d="M3 6h18" />
                            <path d="M7 12h10" />
                            <path d="M10 18h4" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Priority Management</h3>
                        <p class="text-gray-700 dark:text-white">Easily prioritize tasks and visualize what needs attention first.</p>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 dark:text-blue-400 mb-4">
                            <path d="M12 20h9" />
                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z" />
                            <path d="m15 5 3 3" />
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">Task Management</h3>
                        <p class="text-gray-700 dark:text-white">Create, assign, and track tasks with detailed descriptions and due dates.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 bg-blue-50 dark:bg-gray-800">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold mb-4 text-center text-gray-900 dark:text-white">Ready to Improve Your Team's Productivity?</h2>
                <p class="text-xl mb-8 text-gray-700 dark:text-white text-center">Join thousands of teams using our Kanban system to deliver projects more efficiently.</p>
                <div class="flex justify-center gap-4">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-medium transition-colors">Sign Up Now</a>
                    @endif
                    <a href="#" class="px-5 py-2 border border-gray-400 dark:border-blue-400 hover:border-gray-500 dark:hover:border-blue-300 bg-transparent dark:bg-blue-600 text-gray-800 dark:text-white rounded-md font-medium transition-colors">Learn More</a>
                </div>
            </div>
        </section>

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
