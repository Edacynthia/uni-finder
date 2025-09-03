<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'UniMarket') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@800&family=Major+Mono+Display&family=Syne:wght@700&family=Chakra+Petch:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css','resources/css/auth.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->

    <!-- Page Content -->
    <main>
        <div>
            @yield('content')
        </div>
    </main>
</body>

</html>
