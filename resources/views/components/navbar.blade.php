<nav class="bg-gray-800 bg-opacity-90 backdrop-blur-sm px-4 sm:px-6 py-4 flex justify-between items-center sticky top-0 z-50 border-b border-purple-500">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="text-2xl sm:text-3xl font-bold logo-gradient font-syne">UniFinder</a>

      @auth
        <form action="{{ route('search.index') }}" method="GET" class="hidden md:flex items-center space-x-2 mx-4">
            <!-- Text Search -->
            <input type="text" name="q" placeholder="Search products, categories"
                value="{{ request('q') }}"
                class="px-3 py-2 border border-purple-500 rounded-lg bg-transparent text-white 
                       focus:outline-none focus:ring-2 focus:ring-purple-500 w-64 placeholder-gray-400">

            <!-- Category Dropdown -->
            <select name="category"
                class="px-3 py-2 border border-purple-500 rounded-lg bg-gray-800 text-white 
                       focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="">All Categories</option>
                @foreach (\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <!-- Submit Button -->
            <button type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                Search
            </button>
        </form>
    @endauth

    <!-- Desktop Menu -->
   <div class="hidden md:flex space-x-2">
    @auth
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('dashboard.admin') }}" 
               class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg 
                      hover:from-purple-700 hover:to-blue-600 transition">
                Dashboard
            </a>
        @elseif(auth()->user()->hasRole('marketer'))
            <a href="{{ route('dashboard.marketer') }}" 
               class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg 
                      hover:from-purple-700 hover:to-blue-600 transition">
                Dashboard
            </a>
        @elseif(auth()->user()->hasRole('user'))
            <a href="{{ route('dashboard.user') }}" 
               class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg 
                      hover:from-purple-700 hover:to-blue-600 transition">
                Dashboard
            </a>
        @endif

        <a href="{{ route('logout') }}" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg 
                  hover:from-red-600 hover:to-pink-600 transition">
            Logout
        </a>
    @else
        @if (Route::is('login'))
            <span class="text-gray-300 flex items-center">
                Don’t have an account?
                <a href="{{ route('register') }}" 
                   class="ml-2 px-4 py-2 bg-gradient-to-r from-green-500 to-teal-400 text-white rounded-lg 
                          hover:from-green-600 hover:to-teal-500 transition">
                    Register
                </a>
            </span>
        @elseif (Route::is('register'))
            <span class="text-gray-300 flex items-center">
                Already have an account?
                <a href="{{ route('login') }}" 
                   class="ml-2 px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg 
                          hover:from-purple-700 hover:to-blue-600 transition">
                    Login
                </a>
            </span>
        @else
            <a href="{{ route('login') }}" 
               class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg 
                      hover:from-purple-700 hover:to-blue-600 transition">
                Login
            </a>
            <a href="{{ route('register') }}" 
               class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-400 text-white rounded-lg 
                      hover:from-green-600 hover:to-teal-500 transition">
                Register
            </a>
        @endif
    @endauth
</div>


    <!-- Mobile Hamburger -->
    <div class="md:hidden">
        <button id="menu-toggle" class="text-white focus:outline-none">
            <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</nav>

    <!-- Floating Search Button (Mobile Only) -->
<button id="search-fab" 
    class="fixed bottom-6 right-6 bg-purple-600 text-white p-4 rounded-full shadow-lg 
           hover:bg-purple-700 focus:outline-none md:hidden z-50">
    <!-- Search Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" 
         viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 016.15 13.65z"/>
    </svg>
</button>

<!-- Search Modal Overlay -->
<div id="search-overlay" 
    class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
    <div class="bg-gray-900 rounded-xl p-6 w-11/12 max-w-lg shadow-lg relative">
        <!-- Close Button -->
        <button id="close-search" 
            class="absolute top-3 right-3 text-white hover:text-red-400">
            ✖
        </button>

        <h2 class="text-xl font-semibold text-purple-400 mb-4">Search</h2>

        <!-- Search Form -->
        <form action="{{ route('search.index') }}" method="GET" class="space-y-4">
            <!-- Text Search -->
            <input type="text" name="q" placeholder="Search products, categories"
                value="{{ request('q') }}"
                class="w-full px-4 py-2 border border-purple-500 rounded-lg bg-transparent text-white 
                       focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400">

            <!-- Category Dropdown -->
            <select name="category"
                class="w-full px-4 py-2 border border-purple-500 rounded-lg bg-gray-800 text-white 
                       focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="">All Categories</option>
                @foreach (\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                Search
            </button>
        </form>
    </div>
</div>


<!-- Mobile Sidebar -->
<div id="mobile-menu" class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden md:hidden">
    <div id="sidebar" class="bg-gray-900 w-64 p-6 space-y-4 text-white shadow-lg h-full transform -translate-x-full transition-transform duration-300 flex flex-col">
        <h2 class="text-2xl font-bold text-purple-400">Menu</h2>
      @auth
    @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('dashboard.admin') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg hover:from-purple-700 hover:to-blue-600 transition">Dashboard</a>
    @elseif(auth()->user()->hasRole('marketer'))
        <a href="{{ route('dashboard.marketer') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg hover:from-purple-700 hover:to-blue-600 transition">Dashboard</a>
    @elseif(auth()->user()->hasRole('user'))
        <a href="{{ route('dashboard.user') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg hover:from-purple-700 hover:to-blue-600 transition">Dashboard</a>
    @endif

    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg hover:from-red-600 hover:to-pink-600 transition">Logout</a>
@else
    <a href="{{ route('login') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg hover:from-purple-700 hover:to-blue-600 transition">Login</a>
    <a href="{{ route('register') }}" class="px-4 py-2 bg-gradient-to-r from-green-500 to-teal-400 text-white rounded-lg hover:from-green-600 hover:to-teal-500 transition">Register</a>
@endauth

    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

<script>
    // Mobile menu functionality
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const sidebar = document.getElementById('sidebar');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

    if (menuToggle && mobileMenu && sidebar && hamburgerIcon && closeIcon) {
        menuToggle.addEventListener('click', () => {
            const isOpen = !mobileMenu.classList.contains('hidden');
            if (isOpen) {
                sidebar.classList.add('-translate-x-full');
                setTimeout(() => mobileMenu.classList.add('hidden'), 300);
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            } else {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => sidebar.classList.remove('-translate-x-full'), 10);
                hamburgerIcon.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            }
        });
        
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                sidebar.classList.add('-translate-x-full');
                setTimeout(() => mobileMenu.classList.add('hidden'), 300);
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    }


    const fab = document.getElementById('search-fab');
    const overlay = document.getElementById('search-overlay');
    const closeBtn = document.getElementById('close-search');

    if (fab && overlay && closeBtn) {
        fab.addEventListener('click', () => overlay.classList.remove('hidden'));
        closeBtn.addEventListener('click', () => overlay.classList.add('hidden'));
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) overlay.classList.add('hidden');
        });
    }
</script>

<style>
    .logo-gradient {
        background: linear-gradient(135deg, #ff00cc 0%, #ff9900 25%, #66ff00 50%, #00ffff 75%, #cc00ff 100%);
        background-size: 200% auto;
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradientShift 8s linear infinite;
    }
    
    @keyframes gradientShift {
        0% { background-position: 0% center; }
        100% { background-position: 200% center; }
    }
</style>