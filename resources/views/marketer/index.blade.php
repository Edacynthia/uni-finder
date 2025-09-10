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

        .pagination .page-link {
            transition: all 0.2s ease;
        }

        .pagination .page-link:hover {
            background-color: #a855f7;
            color: white;
        }
        
        /* Favorite star styles */
        .favorite-btn {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
            background: rgba(31, 41, 55, 0.7);
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.3);
        }
        
        .favorite-btn:hover {
            transform: scale(1.1);
            background: rgba(31, 41, 55, 0.9);
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.5);
        }
        
        .favorite-btn.saved {
            animation: pulse 0.5s ease;
        }
        
        .star-icon {
            font-size: 25px;
            transition: all 0.2s ease;
        }
        
        .favorite-btn .saved-star {
            color: #ec9eff;
            text-shadow: 0 0 8px rgba(255, 215, 0, 0.7);
        }
        
        .favorite-btn .unsaved-star {
            color: #9CA3AF;
        }
        
        .favorite-btn:hover .unsaved-star {
            color: #D1D5DB;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
    </style>

    <div class="bg-[#2C2957] text-white font-chakra min-h-screen flex flex-col">
        <!-- Include Navbar Component -->
        @include('components.navbar')

        @if (session('success'))
            <div class="mb-4 px-4 py-2 bg-purple-500 text-white rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-600 text-white p-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content -->
        <div class="flex-1 w-full px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header Section --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white font-syne">All Marketers</h1>
                    <p class="text-purple-300 mt-2">Discover sellers on our platform</p>
                </div>

                @auth
                    @php
                        if (auth()->user()->hasRole('admin')) {
                            $dashboardRoute = route('dashboard.admin');
                        } elseif (auth()->user()->hasRole('marketer')) {
                            $dashboardRoute = route('dashboard.marketer');
                        } else {
                            $dashboardRoute = route('dashboard.user');
                        }
                    @endphp

                    <a href="{{ $dashboardRoute }}"
                        class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 bg-gray-800 text-purple-300 rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        Back to Dashboard
                    </a>
                @endauth
            </div>

            {{-- Search Bar --}}
            <form action="{{ route('marketer.index') }}" method="GET" class="mb-6">
                <div class="flex items-center">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search marketers by name or business..."
                        class="w-full px-4 py-2 rounded-lg border border-purple-400 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <button type="submit"
                        class="ml-2 px-4 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition">
                        Search
                    </button>
                </div>
            </form>


            @if ($marketers->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($marketers as $marketer)
                        <div class="marketer-card rounded-xl p-5">
                            {{-- Favorite Star --}}
                            @auth
                                @php
                                    // Check if THIS marketer is in the logged-in user's favorites
                                    $isSaved = in_array($marketer->id, $userFavorites ?? []);
                                @endphp
                                
                                <div class="favorite-btn {{ $isSaved ? 'saved' : '' }}" 
                                     onclick="toggleFavorite(this, {{ $marketer->id }})"
                                     title="{{ $isSaved ? 'Remove from favorites' : 'Add to favorites' }}">
                                    @if ($isSaved)
                                        <span class="star-icon saved-star">★</span>
                                    @else
                                        <span class="star-icon unsaved-star">☆</span>
                                    @endif
                                </div>
                                
                                <form id="favorite-form-{{ $marketer->id }}-save" 
                                      action="{{ route('favorites.store', $marketer->id) }}" 
                                      method="POST" class="hidden">
                                    @csrf
                                </form>
                                
                                <form id="favorite-form-{{ $marketer->id }}-destroy" 
                                      action="{{ route('favorites.destroy', $marketer->id) }}" 
                                      method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endauth

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
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67-.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
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

                            {{-- View Profile Button --}}
                            @if ($marketer->id)
                                <div class="mt-5 text-center">
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
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                @if ($marketers->hasPages())
                    <div class="mt-8 flex justify-center">
                        <div class="flex space-x-2">
                            @if (!$marketers->onFirstPage())
                                <a href="{{ $marketers->previousPageUrl() }}"
                                    class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">Previous</a>
                            @endif

                            @foreach (range(1, $marketers->lastPage()) as $i)
                                @if ($i == $marketers->currentPage())
                                    <span class="px-3 py-2 rounded-lg bg-purple-700 text-white">{{ $i }}</span>
                                @else
                                    <a href="{{ $marketers->url($i) }}"
                                        class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">{{ $i }}</a>
                                @endif
                            @endforeach

                            @if ($marketers->hasMorePages())
                                <a href="{{ $marketers->nextPageUrl() }}"
                                    class="px-3 py-2 rounded-lg bg-gray-800 text-purple-300 hover:bg-purple-700 hover:text-white transition">Next</a>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-purple-400 mx-auto mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 05.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-xl font-medium text-white">No marketers found</h3>
                    <p class="text-purple-300 mt-2">There are no marketers on the platform yet.</p>
                </div>
            @endif
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
        });
        
        // Toggle favorite function
        function toggleFavorite(button, marketerId) {
            const isSaved = button.classList.contains('saved');
            const formId = isSaved ? 
                `favorite-form-${marketerId}-destroy` : 
                `favorite-form-${marketerId}-save`;
                
            // Submit the appropriate form
            document.getElementById(formId).submit();
            
            // Visual feedback (will be replaced when page reloads)
            if (isSaved) {
                button.classList.remove('saved');
                button.querySelector('.star-icon').className = 'star-icon unsaved-star';
                button.querySelector('.star-icon').textContent = '☆';
                button.title = 'Add to favorites';
            } else {
                button.classList.add('saved');
                button.querySelector('.star-icon').className = 'star-icon saved-star';
                button.querySelector('.star-icon').textContent = '★';
                button.title = 'Remove from favorites';
                
                // Add animation effect
                button.style.animation = 'none';
                setTimeout(() => {
                    button.style.animation = 'pulse 0.5s ease';
                }, 10);
            }
        }
    </script>
@endsection