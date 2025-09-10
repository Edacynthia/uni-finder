<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketer Dashboard | UniFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700&family=Chakra+Petch:wght@600&display=swap"
        rel="stylesheet">

    <style type="text/css">
        .logo-gradient {
            background: linear-gradient(135deg, #ff00cc 0%, #ff9900 25%, #66ff00 50%, #00ffff 75%, #cc00ff 100%);
            background-size: 200% auto;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientShift 8s linear infinite;
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .header {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            border-bottom: 2px solid #a855f7;
        }

        .sidebar-item {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-left-color: #a855f7;
        }

        .stat-card {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }

        .stat-card.hoverable:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(168, 85, 247, 0.3);
        }

        .stat-card.hoverable::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, #a855f7, #ec4899);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card.hoverable:hover::before {
            opacity: 1;
        }

        .notification-bell {
            animation: pulse-slow 2s infinite;
        }

        /* Sidebar responsive styles */
        .sidebar {
            transition: transform 0.3s ease-in-out;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 50;
                width: 75%;
                max-width: 250px;
            }

            .main-content {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-gray-900 text-white font-chakra flex">
    <!-- Removed old hamburger, only header hamburger remains -->

    <!-- Sidebar Navigation -->
    <div id="sidebar" class="sidebar w-64 bg-gray-800 h-full fixed overflow-y-auto md:translate-x-0 sidebar-hidden">
        <div class="p-5 border-b border-purple-700">
            <h1 class="text-2xl font-bold font-syne">
                <a href={{ url('/') }} class="logo-gradient">UniFinder</a>
            </h1>
            <p class="text-purple-300 text-sm mt-1">Marketer Dashboard</p>
        </div>

        <div class="p-4">
            <!-- User Profile -->
            <div class="flex items-center p-4 bg-gray-750 rounded-lg mb-6 animate-slide-in">
                <div class="w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center font-bold text-white">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="ml-3">
                    <p class="font-medium text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-purple-300">Marketer</p>
                </div>
            </div>

            <!-- Navigation Items -->
            <ul class="space-y-2">
                <li>
                    <a href="#" class="sidebar-item flex items-center p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('marketer.show', auth()->user()->marketerProfile->id ?? 0) }}"
                        class="sidebar-item flex items-center p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                        </svg>
                        <span>Public Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('marketer.index') }}" class="sidebar-item flex items-center p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3-3H7" />
                        </svg>
                        <span>Browse Marketers</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('marketer.products.index') }}"
                        class="sidebar-item flex items-center p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        <span>My Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('marketer.profile.edit') }}"
                        class="sidebar-item flex items-center p-3 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-purple-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span>Edit Profile</span>
                    </a>
                </li>
            </ul>

            <!-- Logout -->
            <div class="mt-8 pt-6 border-t border-gray-700">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center p-3 text-purple-300 hover:text-white rounded-lg transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content flex-1 overflow-x-hidden md:ml-64">
        <!-- Header -->
        <div class="header py-8 px-6">
            <div class="max-w-7xl mx-auto flex justify-between items-center flex-wrap">
                <!-- Hamburger and header text -->
                <div class="flex items-center w-full sm:w-auto justify-between">
                    <div class="flex items-center">
                        <button id="header-hamburger"
                            class="md:hidden mr-4 text-purple-400 focus:outline-none flex-shrink-0">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-bold mb-2 font-syne">
                                <span class="logo-gradient">Marketer Dashboard</span>
                            </h1>
                            <p class="text-purple-200 text-sm sm:text-base">Welcome back, {{ auth()->user()->name }}!
                                Manage your business and products.</p>
                        </div>
                    </div>
                </div>
                <!-- Search icon in navbar for md+ screens -->
                <div class="hidden md:flex ml-auto mt-0 flex-shrink-0">
                    <button id="search-trigger" class="focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>

                <!-- Floating Action Button for mobile only -->
                <button id="search-trigger-mobile" aria-label="Open search"
                    class="md:hidden fixed bottom-6 right-6 bg-purple-600 text-white p-4 rounded-full shadow-lg hover:bg-purple-700 transition focus:outline-none z-40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                <!-- Search Modal/Drawer -->
                <div id="search-modal"
                    class="fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center hidden">
                    <div class="bg-gray-900 rounded-xl shadow-2xl p-6 w-full max-w-lg relative">
                        <button id="close-search-modal"
                            class="absolute top-2 right-2 text-gray-400 hover:text-white focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <form id="dashboard-search-form" method="GET" action="{{ route('search.index') }}"
                            class="flex flex-col gap-4">
                            <input type="text" name="q"
                                placeholder="Search products, categories, or marketers..."
                                class="px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-400 focus:outline-none flex-1" />
                            <select name="category"
                                class="px-4 py-2 rounded bg-gray-800 text-white focus:outline-none flex-1">
                                <option value="">All Categories</option>
                                @foreach (\App\Models\Category::all() as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ request('category') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded hover:from-purple-700 hover:to-blue-600 transition">Search</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="{{ route('marketer.products.index') }}" class="stat-card rounded-xl p-4 flex items-center animate-slide-in cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/20" style="animation-delay: 0.1s;">
        <div class="bg-purple-600 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 5.5V7H9V5.5L3 7V9L10 11V13H9L5 12V14L9 13.5V22H11V14.5L13 15V22H15V15L19 14.5V12L15 13H14V11L21 9Z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold">{{ $activeProducts }}</p>
            <p class="text-purple-300 text-sm">Active Products</p>
        </div>
    </a>

    <div class="stat-card rounded-xl p-4 flex items-center animate-slide-in cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/20" style="animation-delay: 0.2s;">
        <div class="bg-purple-600 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 4a4 4 0 014 4 4 4 0 01-4 4 4 4 0 01-4-4 4 4 0 014-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold">156</p>
            <p class="text-purple-300 text-sm">Total Customers</p>
        </div>
    </div>

    <div class="stat-card rounded-xl p-4 flex items-center animate-slide-in cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/20" style="animation-delay: 0.3s;">
        <div class="bg-purple-600 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold">₦89,500</p>
            <p class="text-purple-300 text-sm">Monthly Revenue</p>
        </div>
    </div>

    <div class="stat-card rounded-xl p-4 flex items-center animate-slide-in cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/20" style="animation-delay: 0.4s;">
        <div class="bg-purple-600 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold">{{ $favoriteCount }}</p>
            <p class="text-purple-300 text-sm">Users Saved Me</p>
        </div>
    </div>

    <a href="{{ route('favorites.index') }}" class="stat-card rounded-xl p-4 flex items-center animate-slide-in cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-lg hover:shadow-purple-500/20" style="animation-delay: 0.5s;">
        <div class="bg-purple-600 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
        </div>
        <div>
            <p class="text-2xl font-bold">
                {{ auth()->user()->favorites()->count() }}
            </p>
            <p class="text-purple-300 text-sm">Marketers I Saved</p>
        </div>
    </a>
</div>

        <!-- Dashboard Content -->
        <div class="px-4 sm:px-6 lg:px-8 pb-8">
            <h2 class="text-xl sm:text-2xl font-bold text-white mb-6">Quick Actions</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- My Public Profile Card -->
                <a href="{{ route('marketer.show', auth()->user()->marketerProfile->id ?? 0) }}"
                    class="stat-card hoverable rounded-xl p-6 group animate-slide-in" style="animation-delay: 0.4s;">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-purple-600 rounded-full w-14 h-14 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                    </div>
                    <h2
                        class="font-semibold text-lg mb-2 text-center group-hover:text-purple-300 transition-colors duration-300">
                        My Public Profile</h2>
                    <p class="text-sm text-purple-300 text-center">View how customers see your business profile and
                        offerings.</p>
                </a>

                <!-- Browse Marketers Card -->
                <a href="{{ route('marketer.index') }}"
                    class="stat-card hoverable rounded-xl p-6 group animate-slide-in" style="animation-delay: 0.5s;">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-purple-600 rounded-full w-14 h-14 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3-3H7" />
                            </svg>
                        </div>
                    </div>
                    <h2
                        class="font-semibold text-lg mb-2 text-center group-hover:text-purple-300 transition-colors duration-300">
                        Browse Marketers</h2>
                    <p class="text-sm text-purple-300 text-center">Discover other marketers and explore their products
                        on campus.</p>
                </a>

                <!-- My Products Card -->
                <a href="{{ route('marketer.products.index') }}"
                    class="stat-card hoverable rounded-xl p-6 group animate-slide-in" style="animation-delay: 0.6s;">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-purple-600 rounded-full w-14 h-14 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                    </div>
                    <h2
                        class="font-semibold text-lg mb-2 text-center group-hover:text-purple-300 transition-colors duration-300">
                        My Products</h2>
                    <p class="text-sm text-purple-300 text-center">Manage your product listings and add new items to
                        your catalog.</p>
                </a>
            </div>
        </div>
    </div>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-in': 'slideIn 0.5s ease-out forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0)'
                            },
                            '50%': {
                                transform: 'translateY(-10px)'
                            },
                        },
                        slideIn: {
                            '0%': {
                                transform: 'translateX(-20px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateX(0)',
                                opacity: '1'
                            },
                        }
                    },
                    fontFamily: {
                        'syne': ['Syne', 'sans-serif'],
                        'chakra': ['Chakra Petch', 'sans-serif'],
                    }
                }
            }
        }

        // Hamburger for sidebar (header button only)
        const headerHamburger = document.getElementById('header-hamburger');
        const sidebar = document.getElementById('sidebar');

        function toggleSidebar() {
            sidebar.classList.toggle('sidebar-hidden');
        }
        if (headerHamburger) headerHamburger.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && !sidebar.contains(e.target) && !headerHamburger?.contains(e.target)) {
                sidebar.classList.add('sidebar-hidden');
            }
        });

        // Search icon triggers modal
        function openSearchModal() {
            document.getElementById('search-modal').classList.remove('hidden');
        }

        function closeSearchModal() {
            document.getElementById('search-modal').classList.add('hidden');
        }
        document.getElementById('search-trigger')?.addEventListener('click', openSearchModal);
        document.getElementById('search-trigger-mobile')?.addEventListener('click', openSearchModal);
        document.getElementById('close-search-modal')?.addEventListener('click', closeSearchModal);
        // Optional: close modal on outside click
        document.getElementById('search-modal')?.addEventListener('click', function(e) {
            if (e.target === this) closeSearchModal();
        });
    </script>
</body>

</html>
