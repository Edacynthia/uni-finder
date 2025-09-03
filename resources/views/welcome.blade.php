<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniFinder | Campus Marketplace</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@800&family=Major+Mono+Display&family=Syne:wght@700&family=Chakra+Petch:wght@600&display=swap" rel="stylesheet">
    {{-- @vite(['resources/css/app.css','resources/css/auth.css', 'resources/js/app.js']) --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'spin-slow': 'spin 8s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        }
                    },
                    fontFamily: {
                        'syne': ['Syne', 'sans-serif'],
                        'chakra': ['Chakra Petch', 'sans-serif'],
                        'major-mono': ['Major Mono Display', 'monospace'],
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
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-8px) rotate(1deg);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .hero-bg {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(255, 0, 204, 0.4);
            animation: pulseGlow 3s ease-in-out infinite alternate;
        }
        
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 20px rgba(255, 0, 204, 0.4); }
            100% { box-shadow: 0 0 40px rgba(0, 255, 255, 0.6), 
                             0 0 70px rgba(102, 255, 0, 0.4); }
        }
    </style>
</head>
<body class="bg-gray-900 text-white font-chakra">

 
  <!-- Navbar -->
  <nav class="bg-gray-800 bg-opacity-90 backdrop-blur-sm px-6 py-4 flex justify-between items-center sticky top-0 z-50 border-b border-purple-500">
    <!-- Logo -->
    <h1 class="text-3xl font-bold logo-gradient font-syne">UniFinder</h1>

    <!-- Desktop Menu -->
    <div class="hidden md:flex space-x-2">
      @guest
        <a href="{{ route('login') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg hover:from-purple-700 hover:to-blue-600 transition">Login</a>
        <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-gradient-to-r from-green-500 to-teal-400 text-white rounded-lg hover:from-green-600 hover:to-teal-500 transition">Register</a>
      @else
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg hover:from-red-600 hover:to-pink-600 transition">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
      @endguest
    </div>

    <!-- Mobile Hamburger -->
    <div class="md:hidden">
      <button id="menu-toggle" class="text-white focus:outline-none">
        <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>
  </nav>

  <!-- Sidebar -->
  <div id="mobile-menu" class="fixed inset-0 bg-black bg-opacity-60 z-40 hidden">
    <div id="sidebar" class="bg-gray-900 w-64 p-6 space-y-4 text-white shadow-lg h-full transform -translate-x-full transition-transform duration-300">
      <h2 class="text-2xl font-bold text-purple-400">Menu</h2>
      @guest
        <a href="{{ route('login') }}" class="block px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 rounded-lg hover:from-purple-700 hover:to-blue-600 transition">Login</a>
        <a href="{{ route('register') }}" class="block px-4 py-2 bg-gradient-to-r from-green-500 to-teal-400 rounded-lg hover:from-green-600 hover:to-teal-500 transition">Register</a>
      @else
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 rounded-lg hover:from-red-600 hover:to-pink-600 transition">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
      @endguest
    </div>
  </div>

    <!-- Hero Section -->
    <section class="text-center py-20 hero-bg relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20">
            <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-purple-500 rounded-full filter blur-xl animate-pulse-slow"></div>
            <div class="absolute bottom-1/3 right-1/3 w-48 h-48 bg-cyan-400 rounded-full filter blur-xl animate-pulse-slow delay-1000"></div>
            <div class="absolute top-1/3 right-1/4 w-32 h-32 bg-green-400 rounded-full filter blur-xl animate-pulse-slow delay-2000"></div>
        </div>
        
        <div class="relative z-10">
    <h2 class="text-5xl font-bold mb-6 font-syne">
        <span id="typed-text"></span>
    </h2>
    <p class="text-xl mb-8 max-w-2xl mx-auto">
        Find books, gadgets, fashion, and more from fellow students at your university.
    </p>

            <!-- Search Form -->
            @auth
                <form action="{{ route('search.index') }}" method="GET" class="flex max-w-2xl mx-auto bg-gray-800 bg-opacity-70 rounded-lg overflow-hidden shadow-2xl glow border border-cyan-500/30">
                    <input type="text" name="q" 
                           placeholder="Search products, categories, or marketers..."
                           class="flex-grow px-6 py-4 bg-transparent text-white focus:outline-none placeholder-gray-400"
                           value="{{ request('q') }}">
                    <button type="submit" class="px-8 py-4 bg-gradient-to-r from-purple-600 to-blue-500 text-white font-semibold hover:from-purple-700 hover:to-blue-600 transition-all duration-300">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Search
                        </span>
                    </button>
                </form>
            @else
                <form action="{{ route('login') }}" method="GET" class="flex max-w-2xl mx-auto bg-gray-800 bg-opacity-70 rounded-lg overflow-hidden shadow-2xl border border-purple-500/30">
                    <input type="text" name="q" 
                           placeholder="Search products, categories, or business name..."
                           class="flex-grow px-6 py-4 bg-transparent text-white focus:outline-none placeholder-gray-400"
                           value="{{ request('q') }}">
                    <button type="submit" class="px-8 py-4 bg-gray-700 text-white font-semibold hover:bg-gray-600 transition-all duration-300">
                        Search
                    </button>
                </form>
            @endauth

            <div class="mt-10">
                @guest
                    <a href="{{ route('login') }}" 
                       class="px-8 py-3 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg font-bold hover:from-purple-700 hover:to-pink-600 transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                       Get Started
                       <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                         <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                       </svg>
                    </a>
                @else
                    @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('dashboard.admin') }}" 
                           class="px-8 py-3 bg-gradient-to-r from-green-500 to-teal-400 text-white rounded-lg font-bold hover:from-green-600 hover:to-teal-500 transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                           Admin Dashboard
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                             <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                           </svg>
                        </a>
                    @elseif(auth()->user()->hasRole('marketer'))
                        <a href="{{ route('dashboard.marketer') }}" 
                           class="px-8 py-3 bg-gradient-to-r from-blue-500 to-cyan-400 text-white rounded-lg font-bold hover:from-blue-600 hover:to-cyan-500 transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                           Marketer Dashboard
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                             <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                           </svg>
                        </a>
                    @else
                        <a href="{{ route('dashboard.user') }}" 
                           class="px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-400 text-white rounded-lg font-bold hover:from-purple-600 hover:to-pink-500 transition-all duration-300 transform hover:scale-105 inline-flex items-center">
                           Your Dashboard
                           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                             <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                           </svg>
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="py-16 px-6 max-w-6xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-12 font-syne">
            <span class="logo-gradient">Why Choose UniFinder?</span>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-gray-800 p-6 rounded-2xl shadow-xl card-hover border border-cyan-500/20 glow">
                <div class="flex justify-center mb-4">
                    <div class="p-3 bg-gradient-to-br from-purple-600 to-blue-500 rounded-full w-16 h-16 flex items-center justify-center animate-float">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center font-syne">📚 Books & Supplies</h3>
                <p class="text-gray-300 text-center">Find affordable textbooks, notes, and study materials right on campus without the bookstore markup.</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-gray-800 p-6 rounded-2xl shadow-xl card-hover border border-pink-500/20 glow" style="animation-delay: 0.2s">
                <div class="flex justify-center mb-4">
                    <div class="p-3 bg-gradient-to-br from-pink-500 to-red-500 rounded-full w-16 h-16 flex items-center justify-center animate-float" style="animation-delay: 1s">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center font-syne">👕 Fashion & Lifestyle</h3>
                <p class="text-gray-300 text-center">Shop trendy clothes, shoes, and accessories from fellow students with unique campus style.</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-gray-800 p-6 rounded-2xl shadow-xl card-hover border border-green-500/20 glow" style="animation-delay: 0.4s">
                <div class="flex justify-center mb-4">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-teal-400 rounded-full w-16 h-16 flex items-center justify-center animate-float" style="animation-delay: 2s">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-semibold mb-3 text-center font-syne">💻 Gadgets & More</h3>
                <p class="text-gray-300 text-center">Get phones, laptops, and electronics from trusted campus sellers without leaving your university.</p>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 px-6 max-w-5xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-12 font-syne">
            <span class="logo-gradient">Campus Voices</span>
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gradient-to-br from-purple-900 to-gray-800 p-6 rounded-2xl shadow-xl border border-purple-500/30 transform transition-all duration-500 hover:scale-105">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-cyan-400 to-blue-500 rounded-full flex items-center justify-center font-bold text-white">JS</div>
                    <div class="ml-4">
                        <h4 class="font-semibold">Jessica S.</h4>
                        <p class="text-sm text-purple-300">Business Major</p>
                    </div>
                </div>
                <p class="text-gray-300">"I've saved hundreds on textbooks using UniFinder. The platform is easy to use, and I've met some great people through transactions!"</p>
            </div>
            
            <div class="bg-gradient-to-br from-blue-900 to-gray-800 p-6 rounded-2xl shadow-xl border border-blue-500/30 transform transition-all duration-500 hover:scale-105">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gradient-to-r from-pink-400 to-red-500 rounded-full flex items-center justify-center font-bold text-white">MR</div>
                    <div class="ml-4">
                        <h4 class="font-semibold">Mike R.</h4>
                        <p class="text-sm text-blue-300">Computer Science</p>
                    </div>
                </div>
                <p class="text-gray-300">"Sold my old laptop in just one day! UniFinder made the process so simple and secure. Definitely my go-to for buying and selling on campus."</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 py-8 px-6 border-t border-purple-500/20">
        <div class="max-w-6xl mx-auto text-center">
            <h2 class="text-2xl font-bold logo-gradient font-syne mb-4">UniFinder</h2>
            <p class="text-gray-400 mb-6">Connecting students across campus for seamless buying and selling</p>
            <p class="text-gray-500 text-sm">© 2023 UniFinder. All rights reserved.</p>
        </div>
    </footer>

     <!-- Sidebar Script -->
  <script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const sidebar = document.getElementById('sidebar');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');

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
  </script>

{{-- Typing script --}}
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const texts = [
        "Discover Campus Treasures",
        "Shop from Fellow Students",
        "Find Affordable Goods",
        "Explore Unique Campus Style",
        "Buy & Sell Gadgets Easily"
    ];

    const target = document.getElementById('typed-text');
    const typingSpeed = 100;   // ms per character
    const erasingSpeed = 50;   // ms per character when deleting
    const delayBetween = 1500; // pause before erasing

    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    function type() {
        let currentText = texts[textIndex];
        
        if (isDeleting) {
            target.textContent = currentText.substring(0, charIndex--);
        } else {
            target.textContent = currentText.substring(0, charIndex++);
        }

        if (!isDeleting && charIndex === currentText.length) {
            // Finished typing -> wait then start deleting
            isDeleting = true;
            setTimeout(type, delayBetween);
        } else if (isDeleting && charIndex === 0) {
            // Finished deleting -> move to next text
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
            setTimeout(type, typingSpeed);
        } else {
            setTimeout(type, isDeleting ? erasingSpeed : typingSpeed);
        }
    }

    type();
});
</script>

<style>
#typed-text::after {
    content: '|';
    animation: blink 1s infinite;
    margin-left: 2px;
}
@keyframes blink {
    0%, 50% { opacity: 1; }
    50.1%, 100% { opacity: 0; }
}
</style>


</body>
</html>