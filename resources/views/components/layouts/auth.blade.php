<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | UniFinder</title>
    @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-white font-chakra">

    <!-- Navbar -->
    <nav class="bg-gray-800 bg-opacity-90 backdrop-blur-sm px-6 py-4 flex justify-between items-center sticky top-0 z-50 border-b border-purple-500">
    <!-- Logo -->
    <a href="{{ url('/') }}" class="text-3xl font-bold logo-gradient font-syne">UniFinder</a>

        <div class="hidden md:flex space-x-2">
      @guest
        <a href="{{ route('login') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded-lg hover:from-purple-700 hover:to-blue-600 transition">Login</a>
        <a href="{{ route('register') }}" class="ml-2 px-4 py-2 bg-gradient-to-r from-green-500 to-teal-400 text-white rounded-lg hover:from-green-600 hover:to-teal-500 transition">Register</a>
      @else
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-lg hover:from-red-600 hover:to-pink-600 transition">Logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
      @endguest
    </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-1 flex items-center justify-center pt-10 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    @vite('resources/js/marketer-dashboard.js')
</body>
</html>
