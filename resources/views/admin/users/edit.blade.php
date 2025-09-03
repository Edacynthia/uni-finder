@extends('components.layouts.app')
@section('content')
@include('components.navbar')
<div class="min-h-screen dashboard-bg text-white font-inter py-8">
    <div class="max-w-2xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center mb-4">
        <a href="{{ route('admin.users.create') }}" class="mr-4 text-purple-300 hover:text-white">
                <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-3xl font-bold font-syne">
            <span class="logo-gradient">Edit Profile</span>
        </h1>
    </div>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="admin-card rounded-2xl p-6 glow">
                <label class="block mb-2 text-purple-accent font-semibold">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-purple-secondary transition">
                @error('name')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="admin-card rounded-2xl p-6 glow">
                <label class="block mb-2 text-purple-accent font-semibold">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white placeholder-gray-400 focus:outline-none focus:border-purple-secondary transition">
                @error('email')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="admin-card rounded-2xl p-6 glow">
                <label class="block mb-2 text-purple-accent font-semibold">Role</label>
                <select name="role" class="w-full px-4 py-2 rounded bg-gray-800 border border-gray-600 text-white focus:outline-none focus:border-purple-secondary transition">
                    @foreach (\Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ $role->name }}" {{ old('role', $user->roles->first()->name ?? '') === $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                @enderror
                <!-- Debugging: Display current role -->
                @if ($user->roles->isNotEmpty())
                    <p class="text-purple-accent text-sm mt-2">Current role: {{ ucfirst($user->roles->first()->name) }}</p>
                @else
                    <p class="text-red-400 text-sm mt-2">Warning: No role assigned to this user</p>
                @endif
            </div>

            <button type="submit" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-blue-500 text-white rounded hover:from-purple-700 hover:to-blue-600 transition glow">
                Save Changes
            </button>
        </form>
    </div>
</div>

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
        background: linear-gradient(135deg, #1e1b4b, #2e1065, #3b0764);
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
    
    .glow {
        box-shadow: 0 0 15px rgba(167, 139, 250, 0.3);
        animation: pulseGlow 2.5s ease-in-out infinite alternate;
    }
    
    @keyframes pulseGlow {
        0% { box-shadow: 0 0 15px rgba(167, 139, 250, 0.3); }
        100% { box-shadow: 0 0 30px rgba(167, 139, 250, 0.5); }
    }
</style>
@endsection