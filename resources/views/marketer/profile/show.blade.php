@extends('components.layouts.app')
@section('content')
    <style type="text/css">
        .logo-gradient {
            background: linear-gradient(135deg, #ff00cc 0%, #ff9900 25%, #66ff00 50%, #00ffff 75%, #cc极速赛车开奖结果记录ff 100%);
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
        
        .social-btn {
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .social-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px -5px rgba(0, 0, 0, 0.3);
        }
        
        .instagram-btn {
            background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);
        }
        
        .whatsapp-btn {
            background: linear-gradient(45deg, #25D366, #128C7E);
        }
    </style>

<div class="min-h-screen dashboard-bg text-white font-chakra">
    @include('components.navbar')
    <div class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="javascript:history.back()" class="inline-flex items-center text-purple-300 hover:text-white transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        @if($user->marketerProfile)
            <!-- Profile Header -->
            <div class="profile-card rounded-xl overflow-hidden mb-8">
                <div class="p-6 flex flex-col md:flex-row items-center">
                    <!-- Profile Image -->
                    <div class="mb-4 md:mb-0 md:mr-6">
                        @if($user->marketerProfile->profile_image)
                            <img src="{{ asset('storage/' . $user->marketerProfile->profile_image) }}" 
                                 alt="Profile Image" 
                                 class="w-32 h-32 object-cover rounded-full border-4 border-purple-600 shadow-lg">
                        @else
                            <div class="w-32 h-32 bg-purple-600 rounded-full flex items-center justify-center text-4xl font-bold text-white">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Basic Info -->
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl font-bold font-syne mb-2">
                            <span class="logo-gradient">{{ $user->name }}</span>
                        </h1>
                        <p class="text-purple-300 mb-2">{{ $user->marketerProfile->business_name ?? 'Independent Marketer' }}</p>
                        <p class="text-gray-400">{{ $user->marketerProfile->bio ?? 'No bio yet' }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="profile-card rounded-xl overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-700">
                    <h2 class="text-xl font-semibold flex items-center">
                        <i class="fas fa-info-circle mr-2 text-purple-400"></i>
                        Contact Information
                    </h2>
                </div>
                
                <div class="divide-y divide-gray-700">
                    @if($user->marketerProfile->phone)
                    <div class="info-item p-6">
                        <div class="flex items-center">
                            <i class="fas fa-phone w-6 text-purple-400"></i>
                            <div class="ml-4">
                                <p class="text-sm text-purple-300">Phone</p>
                                <p class="text-lg">{{ $user->marketerProfile->phone }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="info-item p-6">
                        <div class="flex items-center">
                            <i class="fas fa-envelope w-6 text-purple-400"></i>
                            <div class="ml-4">
                                <p class="text-sm text-purple-300">Email</p>
                                <p class="text-lg">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media -->
            <div class="profile-card rounded-xl overflow-hidden mb-8">
                <div class="p-6 border-b border-gray-700">
                    <h2 class="text-xl font-semibold flex items-center">
                        <i class="fas fa-share-alt mr-2 text-purple-400"></i>
                        Connect With Me
                    </h2>
                </div>
                
                <div class="p-6 flex flex-wrap gap-4">
                    @if($user->marketerProfile->instagram)
                    <a href="https://instagram.com/{{ ltrim($user->marketerProfile->instagram, '@') }}" 
                       target="_blank" 
                       class="social-btn instagram-btn px-6 py-3 rounded-lg font-semibold flex items-center">
                        <i class="fab fa-instagram mr-2"></i>
                        {{ $user->marketerProfile->instagram }}
                    </a>
                    @endif
                    
                    @if($user->marketerProfile->whatsapp)
                    <a href="https://wa.me/{{ $user->marketerProfile->whatsapp }}" 
                       target="_blank" 
                       class="social-btn whatsapp-btn px-6 py-3 rounded-lg font-semibold flex items-center">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Chat on WhatsApp
                    </a>
                    @endif
                    
                    @if(!$user->marketerProfile->instagram && !$user->marketerProfile->whatsapp)
                    <p class="text-gray-400">No social media links available</p>
                    @endif
                </div>
            </div>

            <!-- Business Details -->
            <div class="profile-card rounded-xl overflow-hidden">
                <div class="p-6 border-b border-gray-700">
                    <h2 class="text-xl font-semibold flex items-center">
                        <i class="fas fa-store mr-2 text-purple-400"></i>
                        Business Details
                    </h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-2 text-purple-300">About</h3>
                            <p class="text-gray-300">{{ $user->marketerProfile->bio ?? 'No bio provided' }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-semibold mb-2 text-purple-300">Business Name</h3>
                            <p class="text-gray-300">{{ $user->marketerProfile->business_name ?? 'Not specified' }}</p>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- No Profile Found -->
            <div class="profile-card rounded-xl p-8 text-center">
                <i class="fas fa-user-slash text-6xl text-purple-400 mb-4"></i>
                <h2 class="text-2xl font-bold mb-2">No Marketer Profile Found</h2>
                <p class="text-purple-300">This user doesn't have a marketer profile set up yet.</p>
            </div>
        @endif
    </div>
</div>
@endsection