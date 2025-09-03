@extends('components.layouts.app')
@section('content')
@include('components.navbar')
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
        
        .form-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        
        .hero-bg {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        }
    </style>
    
<div class="min-h-screen hero-bg text-white font-chakra flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <!-- Animated background elements -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden opacity-20">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-purple-500 rounded-full filter blur-xl animate-pulse-slow"></div>
        <div class="absolute bottom-1/3 right-1/3 w-48 h-48 bg-cyan-400 rounded-full filter blur-xl animate-pulse-slow delay-1000"></div>
        <div class="absolute top-1/3 right-1/4 w-32 h-32 bg-green-400 rounded-full filter blur-xl animate-pulse-slow delay-2000"></div>
    </div>

    <div class="max-w-md w-full space-y-8 z-10">
        <div>
            <h2 class="text-2xl font-bold text-center">Login to Your Account</h2>
            <p class="mt-2 text-center text-gray-300">Welcome back! Please sign in to continue</p>
        </div>
        
        <form class="mt-8 form-glass rounded-2xl p-8" method="POST" action="{{ route('login') }}">
            @csrf
            
            <!-- Email -->
            <div class="mb-6">
                <label class="block text-gray-200 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="Enter your email">
                </div>
                @error('email') 
                    <p class="text-red-400 text-sm mt-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p> 
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="block text-gray-200 mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" name="password" required
                           class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                           placeholder="Enter your password">
                </div>
                @error('password') 
                    <p class="text-red-400 text-sm mt-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ $message }}
                    </p> 
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-6 flex items-center">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox h-4 w-4 text-purple-600 bg-gray-800 border-gray-700 rounded focus:ring-purple-500">
                    <span class="ml-2 text-gray-300">Remember me</span>
                </label>
            </div>

            <button 
        type="submit"
        x-data="{ loading: false }"
        x-on:click.prevent="
            let form = $el.closest('form');
            if (form.checkValidity()) {
                loading = true;
                form.submit();
            } else {
                form.reportValidity(); // show 'Please fill out this field'
            }
        "
        class="relative w-full py-3 px-4 bg-gradient-to-r from-purple-600 to-blue-500 text-white font-bold rounded-lg hover:from-purple-700 hover:to-blue-600 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 overflow-hidden group disabled:opacity-70"
        :disabled="loading"
    >
        <span class="relative z-10" x-text="loading ? 'Logging in...' : 'Login'"></span>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </button>

            {{-- <div class="mt-6 text-center">
                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm transition-colors duration-300">
                    Forgot your password?
                </a>
            </div> --}}


             <div class="text-center mt-6">
            <p class="text-gray-300">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-medium text-purple-400 hover:text-purple-300 transition-colors duration-300 ml-1">
                    Sign up now
                </a>
            </p>
        </div>
        
        <!-- Social Login Options -->
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-transparent text-gray-400">Or continue with</span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-700 rounded-md shadow-sm bg-gray-800 text-sm font-medium text-gray-300 hover:bg-gray-700 transition-colors duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.477 0 10c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.342-3.369-1.342-.454-1.155-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.268 2.75 1.025A9.578 9.578 0 0110 4.84c.85.004 1.705.114 2.504.336 1.909-1.293 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.934.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.48C17.14 18.163 20 14.418 20 10c0-5.523-4.477-10-10-10z" clip-rule="evenodd" />
                    </svg>
                </a>

                <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-700 rounded-md shadow-sm bg-gray-800 text-sm font-medium text-gray-300 hover:bg-gray-700 transition-colors duration-300">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
            </div>
        </div>
        </form> 
    </div>
</div>
@endsection