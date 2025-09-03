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
        
        .admin-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .filter-btn {
            transition: all 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }
        
        .filter-btn.active {
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            border-color: transparent;
        }
        
        .filter-btn:hover:not(.active) {
            background: rgba(168, 85, 247, 0.2);
        }
        
        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .table-row:hover {
            background: rgba(168, 85, 247, 0.1);
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
        
        .pagination .page-link {
            transition: all 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }
        
        .pagination .page-link:hover {
            background: rgba(168, 85, 247, 0.2);
        }
        
        .pagination .page-link.active {
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            border-color: transparent;
        }
    </style>

<div class="min-h-screen dashboard-bg text-white font-chakra">
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4">
    <!-- Left -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold font-syne">
            <span class="logo-gradient">User Management</span>
        </h1>
        <p class="text-purple-300 mt-2 text-sm sm:text-base">
            Manage all users, marketers, and administrators
        </p>
    </div>

    <!-- Right -->
    <a href="{{ route('admin.users.create') }}" 
       class="px-4 py-2 sm:px-5 sm:py-3 bg-gradient-to-r from-green-500 to-teal-400 text-white rounded-lg font-semibold hover:from-green-600 hover:to-teal-500 transition-all duration-300 flex items-center justify-center sm:justify-start">
        <i class="fas fa-user-plus mr-2"></i>
        Create User
    </a>
</div>

  {{-- ✅ Success Message --}}
        @if (session('success'))
            <div class="mb-6 p-4 bg-purple-300 bg-opacity-30 border border-purple-700 rounded-lg text-purple-700">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif


        <!-- Filter Buttons -->
        <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('admin.users.index') }}" 
               class="filter-btn px-5 py-2 rounded-lg {{ !$role ? 'active' : '' }}">
                All Users
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'user']) }}" 
               class="filter-btn px-5 py-2 rounded-lg {{ $role=='user' ? 'active' : '' }}">
                Buyers
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'marketer']) }}" 
               class="filter-btn px-5 py-2 rounded-lg {{ $role=='marketer' ? 'active' : '' }}">
                Marketers
            </a>
            <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" 
               class="filter-btn px-5 py-2 rounded-lg {{ $role=='admin' ? 'active' : '' }}">
                Administrators
            </a>
        </div>

        <!-- Users Table -->
        <div class="admin-card rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-700">
                            <th class="px-6 py-4 text-left">User</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Role</th>
                            <th class="px-6 py-4 text-left">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="table-row" onclick="window.location='{{ route('admin.users.show', $user) }}'">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center font-bold text-white mr-3">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $user->name }}</div>
                                            <div class="text-sm text-purple-300">Joined {{ $user->created_at->format('M j, Y') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @foreach($user->roles as $role)
                                        @if($role->name == 'user')
                                            <span class="role-badge role-user">Buyer</span>
                                        @elseif($role->name == 'marketer')
                                            <span class="role-badge role-marketer">Marketer</span>
                                        @elseif($role->name == 'admin')
                                            <span class="role-badge role-admin">Administrator</span>
                                        @endif
                                    @endforeach
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                        Active
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" 
                                           class="px-3 py-1 bg-gray-500 hover:bg-gray-600 rounded text-sm transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('admin.users.destroy', $user) }}" 
                                           class="px-3 py-1 bg-red-600 hover:bg-red-400 rounded text-sm transition-colors">
                                            delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="mt-6 flex justify-center">
                <div class="flex space-x-2 pagination">
                    <!-- Previous Page Link -->
                    @if($users->onFirstPage())
                        <span class="page-link px-4 py-2 rounded opacity-50 cursor-not-allowed">
                            <i class="fas fa-chevron-left mr-1"></i> Previous
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="page-link px-4 py-2 rounded">
                            <i class="fas fa-chevron-left mr-1"></i> Previous
                        </a>
                    @endif

                    <!-- Pagination Elements -->
                    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if($page == $users->currentPage())
                            <span class="page-link active px-4 py-2 rounded">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link px-4 py-2 rounded">{{ $page }}</a>
                        @endif
                    @endforeach

                    <!-- Next Page Link -->
                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="page-link px-4 py-2 rounded">
                            Next <i class="fas fa-chevron-right ml-1"></i>
                        </a>
                    @else
                        <span class="page-link px-4 py-2 rounded opacity-50 cursor-not-allowed">
                            Next <i class="fas fa-chevron-right ml-1"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    <script>
        // Enhance table row click functionality
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('.table-row');
            
            tableRows.forEach(row => {
                // Make entire row clickable except for action buttons
                row.addEventListener('click', (e) => {
                    if (!e.target.closest('a') && !e.target.closest('button')) {
                        window.location = row.getAttribute('onclick').match(/'(.*?)'/)[1];
                    }
                });
            });
        });
    </script>
</div>
@endsection