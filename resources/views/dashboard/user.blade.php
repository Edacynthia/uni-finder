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

        .dashboard-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.2);
            background: linear-gradient(135deg, rgba(44, 41, 87, 0.8) 0%, rgba(31, 27, 71, 0.9) 100%);
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px -5px rgba(168, 85, 247, 0.4);
        }

        .card-primary {
            background: linear-gradient(135deg, rgba(101, 76, 237, 0.8) 0%, rgba(138, 99, 210, 0.9) 100%);
        }

        .card-secondary {
            background: linear-gradient(135deg, rgba(109, 40, 217, 0.8) 0%, rgba(139, 92, 246, 0.9) 100%);
        }

        .card-accent {
            background: linear-gradient(135deg, rgba(76, 29, 149, 极速赛车开奖结果记录.8) 0%, rgba(108, 43, 217, 0.9) 100%);
        }

        .card-complaint {
            background: linear-gradient(135deg, rgba(91, 33, 182, 0.8) 0%, rgba(124, 58, 237, 0.9) 100%);
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(31, 41, 55, 0.8) 0%, rgba(17, 24, 39, 0.9) 100%);
            border: 1px solid rgba(168, 85, 247, 0.2);
        }

        .input-field {
            transition: border-color 0.3s ease;
            border: 1px solid rgba(168, 85, 247, 0.3);
            background: rgba(31, 41, 55, 0.7);
        }

        .input-field:focus {
            border-color: #a855f7;
            box-shadow: 0 0 0 2px rgba(168, 85, 247, 0.3);
        }

        .glow {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(168, 85, 247, 0.4);
        }
    </style>

    <div class="bg-gray-900 text-white font-chakra">
        <!-- Include Navbar Component -->
        @include('components.navbar')

              @if (session('success'))
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition
                                class="bg-purple-500 text-white p-3 rounded mb-4">
                                {{ session('success') }}
                            </div>
                        @endif


        <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6">
            <!-- Header Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white font-syne">User Dashboard</h1>
                <p class="text-purple-300 mt-2">Welcome back, {{ Auth::user()->name }}!</p>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="stat-card rounded-xl p-5 text-center">
                    <div class="flex justify-center mb-3">
                        <div class="p-3 bg-purple-900 rounded-full w-12 h-12 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 极速赛车开奖结果记录 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-white">{{ $followedCount }}</h3>
<p class="text-purple-300 text-sm">Marketers Saved</p>

                </div>

                <div class="stat-card rounded-xl p-5 text-center">
                    <div class="flex justify-center mb-3">
                        <div class="p-3 bg-purple-900 rounded-full w-12 h-12极速赛车开奖结果记录 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-white">8</h3>
                    <p class="text-purple-300 text-sm">Products Saved</p>
                </div>

                <div class="stat-card rounded-xl p-5 text-center">
                    <div class="flex justify-center mb-3">
                        <div class="p-3 bg-purple-900 rounded-full w-12 h-12 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-300" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold text-white">5</h3>
                    <p class="text-purple-300 text-sm">Completed Orders</p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Browse Marketers Card -->
                <a href="{{ route('marketer.index') }}" class="dashboard-card card-primary rounded-xl p-6 group">
                    <div class="flex items-center mb-4">
                        <div
                            class="p-3 bg-purple-900 bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 2a10 10 0 110 20 10 10 0 010-20zm0 4a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm4 0a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm-4 6c-2.5 0-4.71 1.28-6 3.22M18 15.22c-1.29-1.94-3.5-3.22-6-3.22" />
                            </svg>
                        </div>
                        <h2 class="font-semibold text-lg text-white">Browse Marketers</h2>
                    </div>
                    <p class="text-purple-200 text-sm">Discover campus sellers and their products</p>
                    <div class="mt-4 flex justify-end">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-white transform group-hover:translate-x-1 transition-transform"
                            fill="none" viewBox="极速赛车开奖结果记录 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </a>

                <!-- My Favorites Card -->
                <a href="{{ route('favorites.index') }}" class="dashboard-card card-complaint rounded-xl p-6 group">
                    <div class="flex items-center mb-4">
                        <div
                            class="p-3 bg-purple-900 bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h2 class="font-semibold text-lg text-white">My Favorites</h2>
                    </div>
                    <p class="text-purple-200 text-sm">See all marketers you’ve saved</p>
                    <div class="mt-4 flex justify-end">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-white transform group-hover:translate-x-1 transition-transform"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </a>

                <!-- Saved Products Card -->
                <a href="#" class="dashboard-card card-accent rounded-xl p-6 group">
                    <div class="flex items-center mb-4">
                        <div
                            class="p-3 bg-purple-900 bg-opacity-20 rounded-full w-12 h-12 flex items-center justify-center mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h2 class="font-semibold text-lg text-white">Saved Products</h2>
                    </div>
                    <p class="text-purple-200 text-sm">Access your favorite items quickly</p>
                    <div class="mt-4 flex justify-end">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-white transform group-hover:translate-x-1 transition-transform"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Message Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                {{-- message form --}}
                <div class=" card-complaint rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-white mb-6 flex items-center">
                        Send us a Message
                    </h2>

                    <form action="{{ route('messages.store') }}" method="POST">
                        @csrf

                  
                        <!-- Name Field -->
                        <div class="mb-5">
                            <label class="block text-white font-medium mb-2">Your Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}"
                                class="w-full input-field p-3 rounded-lg text-white" placeholder="Enter your name"
                                required>
                            @error('name')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-5">
                            <label class="block text-white font-medium mb-2">Email Address</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}"
                                class="w-full input-field p-3 rounded-lg text-white" placeholder="Enter your email"
                                required>
                            @error('email')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Message Field -->
                        <div class="mb-5">
                            <label class="block text-white font-medium mb-2">Your Message</label>
                            <textarea name="message" rows="5" class="w-full input-field p-3 rounded-lg text-white"
                                placeholder="Please type in your message..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>



                        <!-- Submit Button -->
                        <button type="submit" x-data="{ loading: false }"
                            x-on:click.prevent="
        let form = $el.closest('form');
        if (form.checkValidity()) {
            loading = true;
            form.submit();
        } else {
            form.reportValidity();
        }
    "
                            class="w-full btn-primary text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center"
                            :disabled="loading">
                            <!-- Normal State -->
                            <span x-show="!loading">Submit</span>

                            <!-- Loading State -->
                            <span x-show="loading" class="flex items-center">
                                <svg class="animate-spin h-5 w-5 mr-2 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                    </path>
                                </svg>
                                Submitting...
                            </span>
                        </button>

                    </form>
                </div>

                <!-- Recent Activity Section -->
                <div>
                    <h2 class="text-xl font-semibold text-white mb-4 border-b border-purple-500 pb-2">Recent Activity</h2>
                    <div class="bg-gray-800 bg-opacity-50 rounded-xl p-4">
                        <div class="flex items-center py-3 border-b border-gray-700">
                            <div class="bg-purple-900 rounded-full p-2 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            @if($lastFavorite)
    <div>
        <p class="text-white">
            You saved 
            <span class="text-purple-300">{{ $lastFavorite->user->name }}</span>
        </p>
        <p class="text-purple-400 text-sm">
            {{ $lastFavorite->pivot->created_at->diffForHumans() }}
        </p>
    </div>
@else
    <p class="text-purple-400 text-sm">You haven’t followed any marketers yet.</p>
@endif

                        </div>
                        <div class="flex items-center py-3 border-b border-gray-700">
                            <div class="bg-purple-900 rounded-full p-2 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-300" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                         @if($lastSearch)
    <div>
        <p class="text-white">
            You recently searched for
            @if($lastSearch->query)
                <span class="text-purple-300">"{{ $lastSearch->query }}"</span>
            @endif
            @if($lastSearch->category)
                in <span class="text-purple-300">{{ $lastSearch->category->name }}</span>
            @endif
        </p>
        <p class="text-purple-400 text-sm">{{ $lastSearch->updated_at->diffForHumans() }}</p>
    </div>
@else
    <div>
        <p class="text-white">You haven’t searched for anything yet.</p>
    </div>
@endif


                        </div>
                        <div class="flex items-center py-3">
                            <div class="bg-purple-900 rounded-full p-2 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-300"
                                    fill极速赛车开奖结果记录none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2极速赛车开奖结果记录v6a2 2 0 002 2h2v4l.586-.586z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-white">You messaged <span class="text-purple-300">TechGadgets</span> about
                                    a product</p>
                                <p class="text-purple-400 text-sm">3 days ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommended Marketers -->
           <div>
    <h2 class="text-xl font-semibold text-white mb-4 border-b border-purple-500 pb-2">Recommended For You</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach ($recommendedMarketers as $marketer)
            @php
                $isSaved = in_array($marketer->id, $userFavorites ?? []);
            @endphp
            <div class="bg-gray-800 bg-opacity-50 rounded-xl p-4 flex items-center">
                <img src="{{ $marketer->user->profile_photo_url ?? 'https://via.placeholder.com/100' }}"
                     class="w-12 h-12 rounded-full object-cover mr-4"
                     alt="{{ $marketer->user->name }}">
                <div>
                    <h3 class="text-white font-medium">{{ $marketer->user->name }}</h3>
                    <p class="text-purple-300 text-sm">{{ $marketer->business_type ?? 'Marketer' }}</p>
                </div>

                @if ($isSaved)
                    <form action="{{ route('favorites.destroy', $marketer->id) }}" method="POST" class="ml-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="ml-auto bg-purple-900 hover:bg-purple-700 text-white px-3 py-1 rounded-lg text-sm transition">
                            Unfavorite
                        </button>
                    </form>
                @else
                    <form action="{{ route('favorites.store', $marketer->id) }}" method="POST" class="ml-auto">
                        @csrf
                        <button type="submit"
                            class="ml-auto bg-purple-700 hover:bg-purple-600 text-white px-3 py-1 rounded-lg text-sm transition">
                            Favorite
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>

        </div>

        <script>
            // Form validation enhancement
            document.addEventListener('DOMContentLoaded', function() {
                const complaintForm = document.querySelector('form');
                if (complaintForm) {
                    complaintForm.addEventListener('submit', function(e) {
                        const messageField = this.querySelector('textarea[name="message"]');
                        if (messageField.value.trim().length < 10) {
                            e.preventDefault();
                            alert(
                                'Please provide a more detailed description of your complaint (at least 10 characters).'
                            );
                            messageField.focus();
                        }
                    });
                }
            });
        </script>
    </div>
@endsection
