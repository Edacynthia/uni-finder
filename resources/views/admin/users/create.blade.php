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
        
        .dashboard-bg {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
        }
        
        .form-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .input-field {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.2);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(168, 85, 247, 0.4);
        }
        
        .password-toggle {
            transition: all 0.3s ease;
        }
        
        .password-toggle:hover {
            color: #a855f7;
        }
    </style>


<div class="min-h-screen dashboard-bg text-white font-chakra">
    <div class="max-w-2xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-8">
            <a href="{{ route('dashboard.admin') }}" class="mr-4 text-purple-300 hover:text-white">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold font-syne">
                <span class="logo-gradient">Create New User</span>
            </h1>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-900 bg-opacity-30 border border-red-700 rounded-lg">
                <h3 class="font-semibold text-red-300 flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    Please fix the following errors
                </h3>
                <ul class="list-disc ml-5 mt-2 text-red-200">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card rounded-xl p-6">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-purple-300 font-medium mb-2">Full Name</label>
                    <input type="text" name="name" class="w-full input-field rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                           required placeholder="Enter user's full name">
                </div>

                <div class="mb-6">
                    <label class="block text-purple-300 font-medium mb-2">Email Address</label>
                    <input type="email" name="email" class="w-full input-field rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                           required placeholder="Enter user's email address">
                </div>

                <div class="mb-6">
                    <label class="block text-purple-300 font-medium mb-2">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" 
                               class="w-full input-field rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                               required placeholder="Create a secure password">
                        <button type="button" onclick="togglePassword('password')" 
                                class="password-toggle absolute right-3 top-3 text-gray-400">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-purple-300 font-medium mb-2">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full input-field rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-500" 
                               required placeholder="Confirm the password">
                        <button type="button" onclick="togglePassword('password_confirmation')" 
                                class="password-toggle absolute right-3 top-3 text-gray-400">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-purple-300 font-medium mb-2">Role</label>
                    <select name="role" class="w-full input-field rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                        <option value="" class="text-black">-- Select Role --</option>
                        <option value="user" class="text-black">User (Buyer)</option>
                        <option value="marketer" class="text-black">Marketer</option>
                        <option value="admin" class="text-black">Administrator</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.users.index') }}" class="px-5 py-3 border border-gray-600 rounded-lg hover:bg-gray-700 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary px-5 py-3 rounded-lg font-semibold flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
    </script>
</div>
@endsection