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
        
        .profile-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .info-item {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .info-item:hover {
            background: rgba(255, 255, 255, 0.03);
        }
        
        .role-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .role-user {
            background: rgba(96, 165, 250, 0.2);
            color: #93c5fd;
        }
        
        .role-marketer {
            background: rgba(167, 139, 250, 0.2);
            color: #c4b5fd;
        }
        
        .role-admin {
            background: rgba(249, 168, 212, 0.2);
            color: #fbcfe8;
        }
        
        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.4);
        }
        
        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>

<div class="min-h-screen dashboard-bg text-white font-chakra">
    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-8">
            <a href="{{ route('admin.users.index') }}" class="mr-4 text-purple-300 hover:text-white">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold font-syne">
                <span class="logo-gradient">User Profile</span>
            </h1>
        </div>

        <div class="profile-card rounded-xl overflow-hidden mb-6">
            <!-- Profile Header -->
            <div class="p-6 border-b border-gray-700 flex items-center">
                <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center text-2xl font-bold text-white">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-semibold">{{ $user->name }}</h2>
                    <p class="text-purple-300">User Details</p>
                </div>
            </div>
            
            <!-- User Information -->
            <div class="divide-y divide-gray-700">
                <div class="info-item p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-purple-300">Name</p>
                            <p class="text-lg">{{ $user->name }}</p>
                        </div>
                        <i class="fas fa-user text-purple-500"></i>
                    </div>
                </div>
                
                <div class="info-item p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-purple-300">Email Address</p>
                            <p class="text-lg">{{ $user->email }}</p>
                        </div>
                        <i class="fas fa-envelope text-purple-500"></i>
                    </div>
                </div>
                
                <div class="info-item p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-purple-300">Account Status</p>
                            <p class="text-lg">Active</p>
                        </div>
                        <i class="fas fa-check-circle text-green-500"></i>
                    </div>
                </div>
                
                <div class="info-item p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-purple-300">Member Since</p>
                            <p class="text-lg">{{ $user->created_at->format('F j, Y') }}</p>
                        </div>
                        <i class="fas fa-calendar text-purple-500"></i>
                    </div>
                </div>
                
                <div class="p-6">
                    <p class="text-sm text-purple-300 mb-2">Roles</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->roles as $role)
                            @if($role->name == 'user')
                                <span class="role-badge role-user">
                                    <i class="fas fa-user mr-1"></i> Buyer
                                </span>
                            @elseif($role->name == 'marketer')
                                <span class="role-badge role-marketer">
                                    <i class="fas fa-store mr-1"></i> Marketer
                                </span>
                            @elseif($role->name == 'admin')
                                <span class="role-badge role-admin">
                                    <i class="fas fa-shield-alt mr-1"></i> Administrator
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary px-5 py-3 rounded-lg font-semibold text-center flex-1">
                <i class="fas fa-edit mr-2"></i> Edit Profile
            </a>
            
            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirmDelete()" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger px-5 py-3 rounded-lg font-semibold w-full">
                    <i class="fas fa-trash-alt mr-2"></i> Delete User
                </button>
            </form>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this user? This action cannot be undone.');
        }
    </script>
</div>
@endsection