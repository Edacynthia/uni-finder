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
        
        .role-btn {
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(168, 85, 247, 0.5);
        }
        
        .role-btn.active {
            background: linear-gradient(135deg, #a855f7 0%, #ec4899 100%);
            border-color: transparent;
            box-shadow: 0 0 15px rgba(168, 85, 247, 0.5);
        }
        
        .role-btn:hover:not(.active) {
            background: rgba(168, 85, 247, 0.2);
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
                <h2 class="text-2xl font-bold text-center">Create Your Account</h2>
                <p class="mt-2 text-center text-gray-300">Join us to start buying and selling on campus</p>
            </div>
            
            <form class="mt-8 form-glass rounded-2xl p-8" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Role Selection -->
                <div class="mb-6">
                    <label class="block text-gray-200 mb-3">Register as:</label>
                    <div class="flex space-x-4 justify-center">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="account_type" value="user" checked
                                   onclick="toggleRole(this)"
                                   class="hidden">
                            <span class="role-btn active block text-center py-3 px-4 rounded-lg transition-all duration-300" id="buyer-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Buyer
                            </span>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="account_type" value="marketer"
                                   onclick="toggleRole(this)"
                                   class="hidden">
                            <span class="role-btn block text-center py-3 px-4 rounded-lg transition-all duration-300" id="marketer-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m2-6h2m-2-2h2m-6 2h2m-6-2h2m-6 2h2m-2-2h2m-6-2h2M7 7h10M7 11h10M7 15h10" />
                                </svg>
                                Marketer
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Common Fields -->
                <div class="mb-6">
                    <label class="block text-gray-200 mb-2">Full Name</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
                               placeholder="Enter your full name">
                    </div>
                    @error('name') 
                        <p class="text-red-400 text-sm mt-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $message }}
                        </p> 
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-200 mb-2">Email Address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
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

                <div class="mb-6">
                    <label class="block text-gray-200 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password" required
                               class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
                               placeholder="Create a password">
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

                <div class="mb-6">
                    <label class="block text-gray-200 mb-2">Confirm Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" name="password_confirmation" required
                               class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
                               placeholder="Confirm your password">
                    </div>
                </div>

                <!-- Marketer Extra Fields -->
                <div id="marketer-fields" class="hidden space-y-4">
                    <div>
                        <label class="block text-gray-200 mb-2">Phone (optional)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                   class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
                                   placeholder="Your phone number">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-200 mb-2">Business Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m2-6h2m-2-2h2m-6 2h2m-6-2h2m-6 2h2m-2-2h2m-6-2h2M7 7h10M7 11h10M7 15h10" />
                                </svg>
                            </div>
                            <input type="text" name="business_name" value="{{ old('business_name') }}"
                                   class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
                                   placeholder="Your business name">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-200 mb-2">Bio</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 pt-3 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                            </div>
                            <textarea name="bio" rows="3"
                                   class="w-full pl-10 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
                                   placeholder="Tell us about your business">{{ old('bio') }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-200 mb-2">Instagram</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-purple-400">@</span>
                            </div>
                            <input type="text" name="instagram" value="{{ old('instagram') }}"
                                   class="w-full pl-8 pr-3 py-3 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent placeholder-gray-400"
                                   placeholder="username">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-200 mb-2">WhatsApp</label>
                        <div class="flex gap-2">
                            <select name="whatsapp_country_code"
                                    class="w-28 bg-gray-800 bg-opacity-50 border border-gray-700 text-white rounded-lg px-3 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                <option value="1">🇺🇸 +1</option>
                                <option value="44">🇬🇧 +44</option>
                                <option value="234" selected>🇳🇬 +234</option>
                                <option value="91">🇮🇳 +91</option>
                            </select>
                            <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                                   class="flex-1 bg-gray-800 bg-opacity-50 border border-gray-700 rounded-lg text-white px-3 py-3 focus:outline-none focus:ring-2 focus:ring-purple-500 placeholder-gray-400"
                                   placeholder="8012345678">
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-200 mb-2">Profile Image</label>
                        <div class="relative border border-gray-300 border-dashed rounded-lg p-4 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-400 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-300">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-400">JPG, PNG up to 2MB</p>
                            <input type="file" name="profile_image" accept=".jpg,.jpeg,.png" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                    </div>
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
                form.reportValidity();
            }
        "
        class="relative w-full mt-4 py-3 px-4 bg-gradient-to-r from-purple-600 to-blue-500 text-white font-bold rounded-lg hover:from-purple-700 hover:to-blue-600 transition-all duration-300 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-opacity-50 overflow-hidden group disabled:opacity-70"
        :disabled="loading"
    >
        <span class="relative z-10" x-text="loading ? 'Creating account...' : 'Create Account'"></span>
        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-purple-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </button>

                <div class="text-center mt-6">
                    <p class="text-gray-300">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-medium text-purple-400 hover:text-purple-300 transition-colors duration-300 ml-1">
                            Sign in here
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <script>
            function toggleRole(radio) {
                const isMarketer = radio.value === 'marketer';
                const buyerBtn = document.getElementById('buyer-btn');
                const marketerBtn = document.getElementById('marketer-btn');
                const marketerFields = document.getElementById('marketer-fields');
                
                // Toggle active class on buttons
                buyerBtn.classList.toggle('active', !isMarketer);
                marketerBtn.classList.toggle('active', isMarketer);
                
                // Toggle marketer fields
                marketerFields.classList.toggle('hidden', !isMarketer);
            }
            
            // Set initial state based on any existing form values
            document.addEventListener('DOMContentLoaded', function() {
                const accountType = "{{ old('account_type', 'user') }}";
                const initialRadio = document.querySelector(`input[name="account_type"][value="${accountType}"]`);
                if (initialRadio) {
                    initialRadio.checked = true;
                    toggleRole(initialRadio);
                }
            });
        </script>
    </div>
@endsection