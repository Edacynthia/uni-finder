@extends('components.layouts.app')
@section('content')
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
        
        .message-section {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.9) 0%, rgba(17, 24, 39, 0.95) 100%);
            border: 1px solid rgba(168, 85, 247, 0.3);
        }
        
        .btn-view {
            background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
            transition: all 0.3s ease;
        }
        
        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(79, 70, 229, 0.4);
        }
        
        .btn-resolve {
            background: linear-gradient(135deg, #059669 0%, #10B981 100%);
            transition: all 0.3s ease;
        }
        
        .btn-resolve:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(5, 150, 105, 0.4);
        }
        
        .btn-delete {
            background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);
            transition: all 0.3s ease;
        }
        
        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.4);
        }
        
        .table-header {
            background: linear-gradient(135deg, rgba(55, 48, 163, 0.7) 0%, rgba(109, 40, 217, 0.7) 100%);
        }
        
        .glow {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.3);
        }
    </style>

<div class="bg-gray-800 text-white font-chakra">
    <!-- Include Navbar Component -->
    @include('components.navbar')

    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white font-syne">Messages</h1>
            <p class="text-purple-300 mt-2">View and manage user messages</p>
        </div>

        @if(session('success'))
            <div class="bg-purple-300 text-purple-700
             p-4 rounded-lg mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        
        @if(session('error'))
            <div class="bg-red-900 text-red-300 p-4 rounded-lg mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Pending Messages --}}
        <div class="message-section rounded-xl overflow-hidden mb-10">
            <div class="px-6 py-4 border-b border-purple-500/40 flex items-center justify-between table-header">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Pending Messages
                </h2>
                <span class="text-sm text-purple-300 bg-purple-900/50 px-3 py-1 rounded-full">
                    {{ $pendingMessages->count() }} pending
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-800/60 text-purple-200 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Received</th>
                            <th class="px-6 py-4 text-left">Preview</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($pendingMessages as $message)
                            <tr class="hover:bg-gray-800/40 transition">
                                <td class="px-6 py-4">{{ $message->name }}</td>
                                <td class="px-6 py-4">
                                    <a href="mailto:{{ $message->email }}" class="text-purple-300 hover:text-purple-200 hover:underline transition">
                                        {{ $message->email }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-sm text-purple-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message->created_at?->diffForHumans() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-400">
                                        {{ \Illuminate\Support\Str::limit($message->message, 80) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.messages.show', $message->id) }}"
                                           class="btn-view text-white px-3 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>

                                        <form action="{{ route('admin.messages.resolve', $message->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="btn-resolve text-white px-3 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Resolve
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-purple-300 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905a3.61 3.61 0 01-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        <p class="text-lg">No pending messages</p>
                                        <p class="text-sm mt-1">All messages are currently resolved</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Resolved Messages --}}
        <div class="message-section rounded-xl overflow-hidden">
            <div class="px-6 py-4 border-b border-purple-500/40 flex items-center justify-between table-header">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-[#45FF51]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2a10 10 0 110 20 10 10 0 010-20zm0 4a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm4 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm-4 6c-2.5 0-4.71 1.28-6 3.22M18 15.22c-1.29-1.94-3.5-3.22-6-3.22" />
                    </svg>
                    Resolved Messages
                </h2>
                <span class="text-sm text-green-300 bg-green-900/50 px-3 py-1 rounded-full">
                    {{ $resolvedMessages->count() }} resolved
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-800/60 text-purple-200 text-sm">
                        <tr>
                            <th class="px-6 py-4 text-left">Name</th>
                            <th class="px-6 py-4 text-left">Email</th>
                            <th class="px-6 py-4 text-left">Resolved</th>
                            <th class="px-6 py-4 text-left">Preview</th>
                            <th class="px-6 py-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($resolvedMessages as $message)
                            <tr class="hover:bg-gray-800/40 transition">
                                <td class="px-6 py-4">{{ $message->name }}</td>
                                <td class="px-6 py-4">
                                    <a href="mailto:{{ $message->email }}" class="text-purple-300 hover:text-purple-200 hover:underline transition">
                                        {{ $message->email }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-sm text-green-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $message->updated_at?->diffForHumans() }}
                                    </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-400">
                                        {{ \Illuminate\Support\Str::limit($message->message, 80) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.messages.show', $message->id) }}"
                                           class="btn-view text-white px-3 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View
                                        </a>
                                        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn-delete text-white px-3 py-2 rounded-lg text-sm font-medium inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-purple-300 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-purple-400 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-lg">No resolved messages yet</p>
                                        <p class="text-sm mt-1">Resolved messages will appear here</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Enhance table row interactions
        document.addEventListener('DOMContentLoaded', function() {
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('click', function(e) {
                    // Don't trigger if clicking on a link or button
                    if (!e.target.closest('a') && !e.target.closest('button')) {
                        const viewLink = this.querySelector('a[href*="/messages/"]');
                        if (viewLink) {
                            window.location.href = viewLink.href;
                        }
                    }
                });
            });
        });
    </script>
</div>
@endsection