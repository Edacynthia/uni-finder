<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | UniFinder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700&family=Chakra+Petch:wght@600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'float': 'float 6s ease-in-out infinite',
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
                        },
                    },
                    fontFamily: {
                        'syne': ['Syne', 'sans-serif'],
                        'chakra': ['Chakra Petch', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'purple-primary': '#6d28d9',
                        'purple-secondary': '#a78bfa',
                        'purple-accent': '#ede9fe',
                    }
                }
            }
        }
    </script>
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

        .dashboard-bg {
            background: linear-gradient(135deg, #1e1b4b, #2e1065, #3b0764);
        }

        .header {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            border-bottom: 2px solid #a855f7;
        }

        .admin-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(167, 139, 250, 0.25);
            border-color: #a78bfa;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(109, 40, 217, 0.15), rgba(167, 139, 250, 0.15));
            border: 1px solid rgba(167, 139, 250, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(167, 139, 250, 0.35);
        }

        .search-modal {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .search-modal.active {
            opacity: 1;
            visibility: visible;
        }

        .glow {
            box-shadow: 0 0 15px rgba(167, 139, 250, 0.3);
            animation: pulseGlow 2.5s ease-in-out infinite alternate;
        }

        @keyframes pulseGlow {
            0% {
                box-shadow: 0 0 15px rgba(167, 139, 250, 0.3);
            }

            100% {
                box-shadow: 0 0 30px rgba(167, 139, 250, 0.5);
            }
        }

        .mobile-sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .mobile-sidebar.open {
            transform: translateX(0);
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 40;
        }

        .overlay.active {
            display: block;
        }

        .nav-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: rgba(167, 139, 250, 0.1);
            border-left-color: #a78bfa;
        }

        .hamburger span {
            transition: all 0.3s ease;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }
    </style>
</head>

<body class="min-h-screen dashboard-bg text-white font-inter">
    <!-- Mobile overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Search Modal -->
    <div id="search-modal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="bg-gray-900 rounded-xl shadow-2xl p-6 w-full max-w-lg relative">
            <button id="close-search-modal"
                class="absolute top-2 right-2 text-gray-400 hover:text-white focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <form id="dashboard-search-form" method="GET" action="{{ route('search.index') }}"
                class="flex flex-col gap-4">
                <input type="text" name="q" placeholder="Search products, categories, or marketers..."
                    class="px-4 py-2 rounded bg-gray-800 text-white placeholder-gray-400 focus:outline-none flex-1">
                <select name="category" class="px-4 py-2 rounded bg-gray-800 text-white focus:outline-none flex-1">
                    <option value="">All Categories</option>
                    @foreach (\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded 
                           hover:from-purple-700 hover:to-blue-600 transition">
                    Search
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile sidebar -->
    <div class="mobile-sidebar fixed inset-y-0 left-0 w-72 bg-gray-900 h-full overflow-y-auto lg:hidden z-50"
        id="mobile-sidebar">
        <div class="p-6 border-b border-gray-700">
            <h1 class="text-2xl font-bold">
                <span class="logo-gradient font-syne">UniFinder</span>
            </h1>
            <p class="text-purple-accent text-sm mt-1">Admin Dashboard</p>
            <button class="absolute top-6 right-6 text-white lg:hidden" id="close-sidebar">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="p-5">
            <!-- User Profile -->
            <div class="flex items-center p-4 bg-gray-800 rounded-xl mb-6">
                <div
                    class="w-12 h-12 bg-purple-primary rounded-full flex items-center justify-center font-bold text-white">
                    A
                </div>
                <div class="ml-4">
                    <p class="font-semibold text-white">Admin User</p>
                    <p class="text-xs text-purple-accent">Administrator</p>
                </div>
            </div>

            <!-- Navigation Items -->
            <ul class="space-y-2">
                <li>
                    <a href="#" class="nav-item active flex items-center p-4 rounded-xl text-purple-accent">
                        <i class="fas fa-chart-pie w-6 mr-3 text-purple-secondary"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-item flex items-center p-4 rounded-xl">
                        <i class="fas fa-users w-6 mr-3 text-purple-secondary"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('marketer.index') }}" class="nav-item flex items-center p-4 rounded-xl">
                        <i class="fas fa-store w-6 mr-3 text-purple-secondary"></i>
                        <span>Marketer Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.messages.index') }}" class="nav-item flex items-center p-4 rounded-xl">
                        <i class="fas fa-chart-bar w-6 mr-3 text-purple-secondary"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.create') }}" class="nav-item flex items-center p-4 rounded-xl">
                        <i class="fas fa-user-plus w-6 mr-3 text-purple-secondary"></i>
                        <span>Create User</span>
                    </a>
                </li>
            </ul>

            <!-- Logout -->
            <div class="mt-8 pt-6 border-t border-gray-700">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center p-4 text-purple-accent hover:text-white rounded-xl transition-colors">
                    <i class="fas fa-sign-out-alt w-6 mr-3 text-purple-secondary"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Desktop sidebar -->
    <div class="hidden lg:block fixed inset-y-0 left-0 w-72 bg-gray-900 h-full overflow-y-auto z-30">
        <div class="p-6 border-b border-gray-700">
            <h1 class="text-2xl font-bold">
                <span class="logo-gradient font-syne">UniFinder</span>
            </h1>
            <p class="text-purple-accent text-sm mt-1">Admin Dashboard</p>
        </div>

        <div class="p-5">
            <!-- User Profile -->
            <div class="flex items-center p-4 bg-gray-800 rounded-xl mb-6">
                <div
                    class="w-12 h-12 bg-purple-primary rounded-full flex items-center justify-center font-bold text-white">
                    A
                </div>
                <div class="ml-4">
                    <p class="font-semibold text-white">Admin User</p>
                    <p class="text-xs text-purple-accent">Administrator</p>
                </div>
            </div>

            <!-- Navigation Items -->
            <ul class="space-y-2">
                <li>
                    <a href="#" class="nav-item active flex items-center p-4 rounded-xl text-purple-accent">
                        <i class="fas fa-chart-pie w-6 mr-3 text-purple-secondary"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-item flex items-center p-4 rounded-xl">
                        <i class="fas fa-users w-6 mr-3 text-purple-secondary"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('marketer.index') }}" class="nav-item flex items-center p-4 rounded-xl">
                        <i class="fas fa-store w-6 mr-3 text-purple-secondary"></i>
                        <span>Marketer Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.messages.index') }}" class="nav-item flex items-center p-4 rounded-xl">
                        <i class="fas fa-chart-bar w-6 mr-3 text-purple-secondary"></i>
                        <span>Messages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.create') }}" class="nav-item flex items-center p-4 rounded-xl">
                        <i class="fas fa-user-plus w-6 mr-3 text-purple-secondary"></i>
                        <span>Create User</span>
                    </a>
                </li>
            </ul>

            <!-- Logout -->
            <div class="mt-8 pt-6 border-t border-gray-700">
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center p-4 text-purple-300 hover:text-white rounded-xl transition-colors">
                    <i class="fas fa-sign-out-alt w-6 mr-3 text-purple-secondary"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="lg:ml-72 min-h-screen">
        <!-- Top Header -->
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
                                <span class="logo-gradient">Admin Dashboard</span>
                            </h1>
                            <p class="text-purple-200 text-sm sm:text-base">Welcome back, Administrator!</p>
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
            </div>
        </div>

        <!-- Main Content -->
        <main class="p-6 max-w-7xl mx-auto">
            <!-- Stats Overview -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <a href="{{ route('admin.users.index') }}"
                    class="stat-card rounded-2xl p-6 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left">
                    <!-- Icon -->
                    <div class="bg-purple-primary p-3 rounded-full mb-3 sm:mb-0 sm:mr-4">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <!-- Text -->
                    <div>
                        <p class="text-xl sm:text-2xl font-bold text-purple-accent">{{ $totalUsers }}</p>
                        <p class="text-purple-secondary text-xs sm:text-sm">Total Users</p>
                    </div>
                </a>

                <a href="{{ route('search.index') }}"
                    class="stat-card rounded-2xl p-6 flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left">
                    <div class="bg-purple-primary p-3 rounded-full mb-3 sm:mb-0 sm:mr-4">
                        <i class="fas fa-box-open text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl sm:text-2xl font-bold text-purple-accent">{{ $totalProducts }}</p>
                        <p class="text-purple-secondary text-xs sm:text-sm">Total Products</p>
                    </div>
                </a>

                <a href="{{ route('marketer.index') }}"
                    class="stat-card rounded-2xl p-6 flex flex-col sm:flex-row items-center sm:items:start text-center sm:text-left">
                    <div class="bg-purple-primary p-3 rounded-full mb-3 sm:mb-0 sm:mr-4">
                        <i class="fas fa-store text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl sm:text-2xl font-bold text-purple-accent">{{ $totalMarketers }}</p>
                        <p class="text-purple-secondary text-xs sm:text-sm">Total Marketers</p>
                    </div>
                </a>

                <a href="#"
                    class="stat-card rounded-2xl p-6 flex flex-col sm:flex-row items-center sm:items:start text-center sm:text-left">
                    <div class="bg-purple-primary p-3 rounded-full mb-3 sm:mb-0 sm:mr-4">
                        <i class="fas fa-chart-pie text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="text-xl sm:text-2xl font-bold text-purple-accent">78%</p>
                        <p class="text-purple-secondary text-xs sm:text-sm">Engagement Rate</p>
                    </div>
                </a>
            </div>

            <!-- Action Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('admin.users.index') }}" class="admin-card rounded-2xl p-6">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-purple-primary rounded-full w-14 h-14 flex items-center justify-center">
                            <i class="fas fa-user-cog text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2 text-center text-purple-accent">User Management</h3>
                    <p class="text-sm text-purple-secondary text-center">Manage user roles and permissions.</p>
                </a>

                <a href="{{ route('marketer.index') }}" class="admin-card rounded-2xl p-6">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-purple-primary rounded-full w-14 h-14 flex items-center justify-center">
                            <i class="fas fa-store text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2 text-center text-purple-accent">Marketer Management</h3>
                    <p class="text-sm text-purple-secondary text-center">Oversee marketer activities.</p>
                </a>

                <a href="{{ route('admin.messages.index') }}" class="admin-card rounded-2xl p-6">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-purple-primary rounded-full w-14 h-14 flex items-center justify-center">
                            <i class="fas fa-chart-bar text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2 text-center text-purple-accent">Messages</h3>
                    <p class="text-sm text-purple-secondary text-center">Track Messages sent by users.</p>
                </a>

                <a href="{{ route('admin.users.create') }}" class="admin-card rounded-2xl p-6">
                    <div class="flex justify-center mb-4">
                        <div class="p-3 bg-purple-primary rounded-full w-14 h-14 flex items-center justify-center">
                            <i class="fas fa-user-plus text-white text-xl"></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-lg mb-2 text-center text-purple-accent">Create User/Marketer</h3>
                    <p class="text-sm text-purple-secondary text-center">Add new users or marketers.</p>
                </a>
            </div>
        </main>
    </div>

    <script>
        // Ensure script runs after DOM is fully loaded
        document.addEventListener('DOMContentLoaded', () => {
            // Mobile sidebar functionality
            const mobileSidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('overlay');
            const openSidebarBtn = document.getElementById('header-hamburger');
            const closeSidebarBtn = document.getElementById('close-sidebar');

            function openSidebar() {
                mobileSidebar.classList.add('open');
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebar() {
                mobileSidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.style.overflow = 'auto';
            }

            openSidebarBtn.addEventListener('click', openSidebar);
            closeSidebarBtn.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            document.querySelectorAll('.mobile-sidebar a').forEach(link => {
                link.addEventListener('click', closeSidebar);
            });

            /// Search modal functionality
            const searchModal = document.getElementById('search-modal');
            const searchTrigger = document.getElementById('search-trigger');
            const searchTriggerMobile = document.getElementById('search-trigger-mobile');
            const closeSearchBtn = document.getElementById('close-search-modal');

            function openSearchModal() {
                searchModal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            function closeSearchModal() {
                searchModal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }

            searchTrigger?.addEventListener('click', openSearchModal);
            searchTriggerMobile?.addEventListener('click', openSearchModal);
            closeSearchBtn?.addEventListener('click', closeSearchModal);

            // Close when clicking outside modal content
            searchModal?.addEventListener('click', (e) => {
                if (e.target === searchModal) closeSearchModal();
            });

            // Escape key support
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeSearchModal();
            });

        });
    </script>
</body>

</html>
