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
            0% {
                background-position: 0% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        .marketer-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.2);
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.9) 100%);
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(168, 85, 247, 0.4);
        }

        .btn-view {
            background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
        }

        .btn-unsave {
            background: linear-gradient(135deg, #EF4444 0%, #B91C1C 100%);
            transition: all 0.3s ease;
        }

        .btn-unsave:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.4);
        }

        .pagination .page-link {
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background-color: #a855f7;
            color: white;
        }

        .empty-state {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.9) 100%);
            border: 1px solid rgba(168, 85, 247, 0.2);
        }
        
        .alert-message {
            transition: opacity 0.5s ease-out;
        }
    </style>

    <div class="bg-[#2C2957] text-white font-chakra min-h-screen flex flex-col">
        @include('components.navbar')

        <div class="flex-1 w-full px-4 sm:px-6 lg:px-8 py-8">
            <div class="max-w-6xl mx-auto">
                {{-- Header Section --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-white font-syne">My Saved Marketers</h1>
                        <p class="text-purple-300 mt-2">Marketers you've saved for quick access</p>
                    </div>
                    
                    <a href="{{ route('marketer.index') }}" 
                       class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Browse All Marketers
                    </a>
                </div>

                @if(session('success'))
                    <div id="success-alert" class="mb-6 px-4 py-3 bg-green-700 text-white rounded-lg border border-green-500 alert-message">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                {{ session('success') }}
                            </div>
                            <button type="button" onclick="dismissAlert('success-alert')" class="text-green-200 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div id="error-alert" class="mb-6 px-4 py-3 bg-red-700 text-white rounded-lg border border-red-500 alert-message">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                {{ session('error') }}
                            </div>
                            <button type="button" onclick="dismissAlert('error-alert')" class="text-red-200 hover:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if($favorites->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($favorites as $marketer)
                            <div class="marketer-card rounded-xl p-5">
                                {{-- Profile Image --}}
                                <div class="flex justify-center mb-4">
                                    <img src="{{ $marketer->profile_image ? asset('storage/' . $marketer->profile_image) : asset('images/default-profile.png') }}"
                                        class="w-20 h-20 object-cover rounded-full border-2 border-purple-500 shadow-lg"
                                        alt="{{ optional($marketer->user)->name ?? 'Marketer' }}">
                                </div>

                                {{-- Marketer Name --}}
                                <h2 class="text-center font-semibold text-lg text-white">
                                    {{ optional($marketer->user)->name ?? 'Unknown Marketer' }}
                                </h2>

                                {{-- Business Name --}}
                                @if ($marketer->business_name)
                                    <p class="text-center text-purple-300 font-medium mt-1">
                                        {{ $marketer->business_name }}
                                    </p>
                                @endif

                                {{-- Bio --}}
                                <p class="text-sm text-gray-400 text-center mt-3">
                                    {{ Str::limit($marketer->bio ?? 'No bio available.', 80) }}
                                </p>

                                {{-- Contact Info --}}
                                <div class="mt-4 flex justify-center space-x-3">
                                    @if ($marketer->whatsapp)
                                        <div class="flex items-center text-sm text-green-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67-.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335 .157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                                            </svg>
                                            WhatsApp
                                        </div>
                                    @endif

                                    @if ($marketer->instagram)
                                        <div class="flex items-center text-sm text-pink-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24"
                                                fill="currentColor">
                                                <path
                                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                            </svg>
                                            Instagram
                                        </div>
                                    @endif
                                </div>

                                {{-- Action Buttons --}}
                                <div class="mt-5 flex justify-center space-x-3">
                                    <a href="{{ route('marketer.show', $marketer->id) }}"
                                        class="btn-view text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        View Profile
                                    </a>

                                    <form action="{{ route('favorites.destroy', $marketer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn-unsave text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center justify-center"
                                                onclick="return confirm('Remove {{ optional($marketer->user)->name }} from your saved list?')">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                            Unsave
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($favorites->hasPages())
                        <div class="mt-8 flex justify-center">
                            <div class="flex space-x-2">
                                @if (!$favorites->onFirstPage())
                                    <a href="{{ $favorites->previousPageUrl() }}"
                                        class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">Previous</a>
                                @endif

                                @foreach (range(1, $favorites->lastPage()) as $i)
                                    @if ($i == $favorites->currentPage())
                                        <span class="px-3 py-2 rounded-lg bg-purple-700 text-white">{{ $i }}</span>
                                    @else
                                        <a href="{{ $favorites->url($i) }}"
                                            class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">{{ $i }}</a>
                                    @endif
                                @endforeach

                                @if ($favorites->hasMorePages())
                                    <a href="{{ $favorites->nextPageUrl() }}"
                                        class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">Next</a>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Empty State --}}
                    <div class="empty-state rounded-xl p-8 text-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-purple-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        <h3 class="text-xl font-medium text-white">No saved marketers yet</h3>
                        <p class="text-purple-300 mt-2">Save marketers while browsing to see them listed here.</p>
                        <div class="mt-6">
                            <a href="{{ route('marketer.index') }}" 
                               class="px-5 py-2.5 bg-purple-600 rounded-lg text-white font-medium hover:bg-purple-700 transition inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Browse Marketers
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Enhance pagination styling
        document.addEventListener('DOMContentLoaded', function() {
            const paginationLinks = document.querySelectorAll('.pagination a');
            paginationLinks.forEach(link => {
                link.classList.add('page-link', 'px-3', 'py-2', 'rounded', 'border', 'border-purple-300',
                    'mx-1');

                if (link.classList.contains('active')) {
                    link.classList.add('bg-purple-600', 'text-white', 'border-purple-600');
                } else {
                    link.classList.add('text-purple-300', 'hover:bg-purple-700', 'hover:text-white');
                }
            });
            
            // Auto-dismiss alerts after 5 seconds
            autoDismissAlerts();
        });
        
        // Auto dismiss alerts after 5 seconds
        function autoDismissAlerts() {
            const alerts = document.querySelectorAll('.alert-message');
            alerts.forEach(alert => {
                setTimeout(() => {
                    dismissAlert(alert.id);
                }, 5000);
            });
        }
        
        // Function to dismiss alerts
        function dismissAlert(alertId) {
            const alert = document.getElementById(alertId);
            if (alert) {
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            }
        }
    </script>
@endsection